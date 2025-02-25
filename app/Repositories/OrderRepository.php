<?php

namespace App\Repositories;
use App\Enums\OrderStatusType;

use App\Models\Order;
use DB;

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
                });
                ;
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

}