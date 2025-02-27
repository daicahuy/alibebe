<?php

namespace App\Repositories;

use App\Enums\OrderStatusType;

use App\Models\Order;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Auth;

class OrderRepository extends BaseRepository
{
    public function getModel()
    {
        return Order::class; // Trả về tên class của model Order
    }

    public function filterOrders(array $filters, int $page, int $limit): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Order::query()->with("orderStatuses")->with("payment")->orderBy('created_at', 'desc');

        // dd($filters);

        // Áp dụng các bộ lọc tương tự như trong controller cũ
        foreach ($filters as $key => $value) {

            // dd($key, $value);
            if ($key === 'order_status_id' && isset($value)) {
                $query->whereHas('orderStatuses', function ($q) use ($value) {
                    $q->where('order_status_id', $value);
                });
            } elseif ($key == 'search' && isset($value)) {
                $query->where(function ($query1) use ($value) {
                    $query1->where('orders.fullname', 'LIKE', "%{$value}%")
                        ->orWhere('orders.code', 'LIKE', "%{$value}%")
                        ->orWhere('orders.phone_number', 'LIKE', "%{$value}%");
                });
            } elseif ($key == 'startDate' && isset($value)) {
                $query->whereDate('created_at', '>=', $value);
            } elseif ($key == 'endDate' && isset($value)) {
                $query->whereDate('created_at', '<=', $value);
            }
        }

        // dd($query->toSql());

        return $query->paginate($limit, ['*'], 'page', $page);
    }

    public function filterOrdersByUser(array $filters, int $page, int $limit, $user_id): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Order::query()->where("user_id", $user_id)->with([

            'orderItems' => function ($query) {
                $query->with("product");
            }
        ])->with([
                    "coupon" => function ($query) {
                        $query->with('restriction');
                    }
                ])->with("orderStatuses")->with("payment")->orderBy('created_at', 'desc');

        // dd($filters);

        // Áp dụng các bộ lọc tương tự như trong controller cũ
        foreach ($filters as $key => $value) {

            // dd($key, $value);
            if ($key === 'order_status_id' && isset($value)) {
                $query->whereHas('orderStatuses', function ($q) use ($value) {
                    $q->where('order_status_id', $value);
                });
            } elseif ($key == 'search' && isset($value)) {
                $query->where(function ($query1) use ($value) {
                    $query1->where('orders.fullname', 'LIKE', "%{$value}%")
                        ->orWhere('orders.code', 'LIKE', "%{$value}%")
                        ->orWhere('orders.phone_number', 'LIKE', "%{$value}%");
                });
            } elseif ($key == 'startDate' && isset($value)) {
                $query->whereDate('created_at', '>=', $value);
            } elseif ($key == 'endDate' && isset($value)) {
                $query->whereDate('created_at', '<=', $value);
            }
        }

        // dd($query->toSql());

        return $query->paginate($limit, ['*'], 'page', $page);
    }

    public function getOrdersByStatus(int $activeTab)
    {
        $query = Order::query()->with([
            'orderItems',
            'orderStatuses' => function ($query) use ($activeTab) {
                $query->where('order_status_id', $activeTab);
            }
        ]);
        $query->whereHas('orderStatuses', function ($query) use ($activeTab) {
            $query->where('order_status_id', $activeTab);
        });
        $orders = $query->get();

        return $orders;
    }

    public function getOrdersByID(array $idOrders)
    {
        $query = Order::query()->with([
            'orderItems',

        ])->whereIn("id", $idOrders);

        $orders = $query->get();

        return $orders;
    }
    public function countOrdersByStatus(array $filters): \Illuminate\Database\Eloquent\Collection
    {
        $orderStatusCounts = Order::query()
            ->select(DB::raw('COUNT(*) as count'), 'order_status_id')
            ->join('order_order_status', 'orders.id', '=', 'order_order_status.order_id')
            ->groupBy('order_status_id');
        // dd($filters);
        foreach ($filters as $key => $value) {
            if ($key === 'order_status_id' && isset($value)) {
                $orderStatusCounts->where('order_order_status.order_status_id', $value);
            } elseif ($key === 'search' && isset($value)) {
                $orderStatusCounts->where(function ($query) use ($value) {
                    $query->where('orders.fullname', 'LIKE', "%{$value}%")
                        ->orWhere('orders.code', 'LIKE', "%{$value}%")
                        ->orWhere('orders.phone_number', 'LIKE', "%{$value}%");
                });;
            } elseif ($key === 'startDate' && isset($value)) {
                $orderStatusCounts->whereDate('orders.created_at', '>=', $value);
            } elseif ($key === 'endDate' && isset($value)) {
                $orderStatusCounts->whereDate('orders.created_at', '<=', $value);
            }
            //Thêm các điều kiện lọc khác ở đây nếu cần thiết
        }
        // dd($orderStatusCounts->toRawSql());
        $orderStatusCounts = $orderStatusCounts->get();
        return $orderStatusCounts;
    }

    public function getOrderStatistics(): array
    {
        $userId = Auth::id();
        $user = User::with('orders.orderStatuses')->findOrFail($userId);

        // Tổng số đơn hàng của user đăng nhập
        $totalOrders = $user->orders->count();

        // Tổng số đơn hàng đang chờ (Giả sử order_status_id = 1 là "đang chờ")
        $pendingOrders = $user->orders->filter(function ($order) {
            return $order->orderStatuses->where('order_status_id', 1);
        })->count();

        return [
            'total_orders' => $totalOrders,
            'pending_orders' => $pendingOrders,
        ];
    }

    public function getOrdersForUser()
    {
        $userId = Auth::id();
        
        // Truy vấn và phân trang trực tiếp trên orders của người dùng
        return User::findOrFail($userId)
            ->orders()  // Truy vấn mối quan hệ orders
            ->with(['orderStatuses', 'orderItems'])  // Eager load mối quan hệ
            ->paginate(3);  // Phân trang
    }
    
    public function getOrderForUser($order_id)
    {
        $userId = Auth::id();

        // Tìm người dùng và truy xuất đơn hàng với các mối quan hệ liên quan
        $order = User::where('id', $userId)
            ->whereHas('orders', function ($query) use ($order_id) {
                $query->where('id', $order_id);
            })
            ->with(['orders' => function ($query) use ($order_id) {
                $query->where('id', $order_id)
                    ->with([
                        'orderStatuses',
                        'orderItems.product'
                    ]);
            }])
            ->firstOrFail();

        // Lấy order cụ thể và return các order items
        return $order->orders->first()->orderItems;
    }
}
