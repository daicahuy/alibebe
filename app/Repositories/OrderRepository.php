<?php

namespace App\Repositories;

use App\Enums\OrderStatusType;

use App\Models\Order;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderRepository extends BaseRepository
{
    public function getModel()
    {
        return Order::class; // Trả về tên class của model Order
    }

    public function filterOrders(array $filters, int $page, int $limit, $user_id, $role_user): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Order::query()->with("orderStatuses")->with("payment")->orderBy('created_at', 'desc');

        // dd($filters);

        // Áp dụng các bộ lọc tương tự như trong controller cũ
        foreach ($filters as $key => $value) {

            // dd($key, $value);
            if ($key === 'order_status_id' && isset($value)) {
                $query->whereHas('orderStatuses', function ($q) use ($value, $user_id, $role_user) {
                    $q->where('order_status_id', $value);
                    if ($role_user != 2) {
                        if ($value != 1 && $value != 7) {
                            $q->where('modified_by', $user_id);
                        }
                    }
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

    public function filterOrdersByUser(array $filters, int $page, int $limit, $user_id, $search): \Illuminate\Contracts\Pagination\LengthAwarePaginator
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
                $query->where('code', 'LIKE', "%{$value}%")
                    ->orWhereHas('orderItems', function ($query) use ($value) {
                        $query->where("name", "LIKE", "%{$value}%");
                    });
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

    public function getOrderStatistics(): array
    {
        $userId = Auth::id();
        $user = User::with('orders.orderStatuses')->findOrFail($userId);

        // Tổng số đơn hàng của user đăng nhập
        $totalOrders = $user->orders->count();

        // Tổng số đơn hàng đang chờ (Giả sử order_status_id = 1 là "đang chờ")
        $pendingOrders = $user->orders->filter(function ($order) {
            $latestStatus = $order->orderStatuses->sortByDesc(function ($status) {
                return $status->pivot->created_at;
            })->first();

            return $latestStatus && $latestStatus->id == 1;
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
            ->with([
                'orders' => function ($query) use ($order_id) {
                    $query->where('id', $order_id)
                        ->with([
                            'orderStatuses',
                            'orderItems.product'
                        ]);
                }
            ])
            ->firstOrFail();

        // Lấy order cụ thể và return các order items
        return $order->orders->first()->orderItems;
    }

    // customer detail 

    // lịch sử hoạt động
    public function getTimeActivity($userId)
    {
        $latestActivity = $this->model->where('user_id', $userId)->latest()->first();
        return $latestActivity;
    }

    // danh sách đơn hàng - list order
    public function getUserOrder($userId, $filterStatus)
    {
        $listOrders = $this->model->where('user_id', $userId)

            ->with(['payment', 'orderStatuses'])
            ->select('id', 'code', 'user_id', 'payment_id', 'is_refund', 'total_amount', 'created_at')
            ->orderByDesc('created_at');
        if ($filterStatus) {
            if ($filterStatus == 'refunded') {
                $listOrders->where('is_refund', true);
            } else {
                if ($filterStatus == 'Hoàn thành') {
                    $listOrders->where('is_refund', 0);
                }
                $listOrders->whereHas('orderStatuses', function ($q) use ($filterStatus) {
                    $q->where('name', $filterStatus);
                });
            }
        }

        return $listOrders->paginate(5, ['*'], 'order_page');
    }
    public function countUserOrderById($userId)
    {

        $user = User::with('orders')->findOrFail($userId);

        return $user->orders->count();
    }

    // phương thức thanh toán
    public function getPaymentMethod($userId, $startDate = null, $endDate = null)
    {
        return $this->filterDate(
            $this->model->where('user_id', $userId),
            $startDate,
            $endDate
        )->with('payment', function ($q) {
            $q->select(['id', 'name']);
        })
            ->get()
            ->groupBy('payment.name')
            ->map(function ($orders, $paymentName) {
                return [
                    'payment_method' => $paymentName,
                    'order_count' => $orders->count(),
                    // 'revenue' => $orders['total_amount'],
                    'total_revenue' => $orders->sum('total_amount', )
                ];
            })->values();
    }


    // đếm đơn hàng theo status
    public function countOrderByUserId($userId)
    {
        $allCount = $this->model->where('user_id', $userId)->count();
        $successCount = $this->model->where('user_id', $userId)
            ->where('is_refund', 0)
            ->whereHas('orderStatuses', function ($q) {
                $q->where('name', 'Hoàn thành');
            })->count();
        $cancelCount = $this->model->where('user_id', $userId)->whereHas('orderStatuses', function ($q) {
            $q->where('name', 'Đã hủy');
        })->count();
        $refundCount = $this->model->where('user_id', $userId)->whereHas('orderStatuses', function ($q) {
            $q->where('is_refund', 1);
        })->count();
        return [
            'allCount' => $allCount,
            'successCount' => $successCount,
            'cancelCount' => $cancelCount,
            'refundCount' => $refundCount
        ];
    }

    // chi tiết các đơn hàng


    // Hàm lấy doanh thu theo status và date
    public function getRevenueByDateAndStatus($userId, $status, $startDate, $endDate)
    {
        $query = $this->model->where('user_id', $userId);

        // Thêm điều kiện is_refund = 0 chỉ khi trạng thái là 'Hoàn thành'
        if ($status === 'Hoàn thành') {
            $query->where('is_refund', 0);
        }

        $query->whereHas('orderStatuses', function ($q) use ($status) {
            $q->where('name', $status);
        });

        return $this->filterDate(
            $query,
            $startDate,
            $endDate
        )->sum('total_amount');
    }
    // lấy tổng doanh SỐ (bán được bao nhiêu), bao gồm tổng đơn bán được trong hoảng thời gian cụ thể (doanh thu = thu dc bnhieu)
    public function getTotalRevenue($userId, $startDate, $endDate)
    {
        return $this->filterDate(
            $this->model->where('user_id', $userId),
            // ->where('is_paid', 1),
            $startDate,
            $endDate
        )->sum('total_amount');
    }

    // B3 hàm chung gọi ra từng trạng thái 
    public function countOrderDetail($userId, $status, $startDate, $endDate)
    {
        // số lượng đơn
        $allCount = $this->filterDate($this->model->where('user_id', $userId), $startDate, $endDate)->count();
        $successCount = $this->countOrdersByDateAndStatus($userId, 'Hoàn thành', $startDate, $endDate);
        $processingCount = $this->countOrdersByDateAndStatus($userId, 'Đang xử lý', $startDate, $endDate);
        $shipCount = $this->countOrdersByDateAndStatus($userId, 'Đang giao hàng', $startDate, $endDate);
        $cancelCount = $this->countOrdersByDateAndStatus($userId, 'Đã hủy', $startDate, $endDate);
        $refundCount = $this->filterDate($this->model->where('user_id', $userId)->where('is_refund', 1), $startDate, $endDate)->count();

        // tiền
        $successRevenue = $this->getRevenueByDateAndStatus($userId, 'Hoàn thành', $startDate, $endDate);
        $processingRevenue = $this->getRevenueByDateAndStatus($userId, 'Đang xử lý', $startDate, $endDate);
        $shipRevenue = $this->getRevenueByDateAndStatus($userId, 'Đang giao hàng', $startDate, $endDate);
        $cancelRevenue = $this->getRevenueByDateAndStatus($userId, 'Đã hủy', $startDate, $endDate);
        $refundRevenue = $this->filterDate($this->model->where('user_id', $userId)->where('is_refund', 1), $startDate, $endDate)->sum('total_amount');


        return [
            'countAllDetail' => $allCount,
            'countSuccessDetail' => $successCount,
            'countProcessingDetail' => $processingCount,
            'countCancelDetail' => $cancelCount,
            'countRefundDetail' => $refundCount,
            'countShipDetail' => $shipCount,

            'revenueSuccessDetail' => $successRevenue,
            'revenueProcessingDetail' => $processingRevenue,
            'revenueCancelDetail' => $cancelRevenue,
            'revenueRefundDetail' => $refundRevenue,
            'revenueShipDetail' => $shipRevenue,
        ];
    }

    // B2: hàm chung đếm đơn hàng theo trạng thái truyền vào, điều kiện lọc theo date
    public function countOrdersByDateAndStatus($userId, $status, $startDate, $endDate)
    {
        $query = $this->model->where('user_id', $userId);

        // Thêm điều kiện is_refund = 0 chỉ khi trạng thái là 'Hoàn thành'
        if ($status === 'Hoàn thành') {
            $query->where('is_refund', 0);
        }

        $query->whereHas('orderStatuses', function ($q) use ($status) {
            $q->where('name', $status);
        });

        return $this->filterDate(
            $query,
            $startDate,
            $endDate
        )->count();
    }

    // B1: hàm lọc ngày
    public function filterDate($query, $startDate = null, $endDate = null)
    {
        if ($startDate && $endDate) {
            $query
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate);
        } else if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } else if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        return $query;
    }





    // employee - detail

    // Lấy phương thức thanh toán các đơn hàng mà nhân viên đã xử lý
    public function getPaymentMethodForEmployee($employeeId, $startDate = null, $endDate = null)
    {
        return $this->filterDate(
            $this->model->whereHas('orderStatuses', function ($query) use ($employeeId) {
                $query->where('order_order_status.modified_by', $employeeId);
            }),
            $startDate,
            $endDate
        )
            ->with('payment', function ($q) {
                $q->select(['id', 'name']);
            })
            ->get()
            ->groupBy('payment.name')
            ->map(function ($orders, $paymentName) {
                return [
                    'payment_method' => $paymentName,
                    'order_count' => $orders->count(),
                    'total_revenue' => $orders->sum('total_amount'),
                ];
            })->values();
    }

    // B3 hàm chung gọi ra từng trạng thái cho nhân viên
    public function countOrderDetailForEmployee($employeeId, $startDate, $endDate)
    {
        // số lượng đơn
        $allCount = $this->filterDate(
            $this->model->where(function ($query) use ($employeeId) {
                $query->whereHas('orderStatuses', function ($q) use ($employeeId) {
                    $q->where('order_order_status.modified_by', $employeeId);
                })->orWhere(function ($q) use ($employeeId) {
                    $q->where('is_refund', 1)
                        ->whereHas('orderStatuses', function ($q2) use ($employeeId) {
                            $q2->where('order_order_status.modified_by', $employeeId);
                        });
                });
            }),
            $startDate,
            $endDate
        )->count();

        $successCount = $this->countOrdersByDateAndStatusForEmployee($employeeId, 'Hoàn thành', $startDate, $endDate);
        $processingCount = $this->countOrdersByDateAndStatusForEmployee($employeeId, 'Đang xử lý', $startDate, $endDate);
        $cancelCount = $this->countOrdersByDateAndStatusForEmployee($employeeId, 'Đã hủy', $startDate, $endDate);
        $shipCount = $this->countOrdersByDateAndStatusForEmployee($employeeId, 'Đang giao hàng', $startDate, $endDate);
        $refundCount = $this->filterDate(
            $this->model->where('is_refund', 1)
                ->whereHas('orderStatuses', function ($q) use ($employeeId) {
                    $q->where('order_order_status.modified_by', $employeeId);
                }),
            $startDate,
            $endDate
        )->count();

        // tiền
        $successRevenue = $this->getRevenueByDateAndStatusForEmployee($employeeId, 'Hoàn thành', $startDate, $endDate);
        $processingRevenue = $this->getRevenueByDateAndStatusForEmployee($employeeId, 'Đang xử lý', $startDate, $endDate);
        $cancelRevenue = $this->getRevenueByDateAndStatusForEmployee($employeeId, 'Đã hủy', $startDate, $endDate);
        $shipRevenue = $this->getRevenueByDateAndStatusForEmployee($employeeId, 'Đang giao hàng', $startDate, $endDate);
        $refundRevenue = $this->filterDate(
            $this->model->where('is_refund', 1)
                ->whereHas('orderStatuses', function ($q) use ($employeeId) {
                    $q->where('order_order_status.modified_by', $employeeId);
                }),
            $startDate,
            $endDate
        )->sum('total_amount');



        return [
            'countAllDetail' => $allCount,
            'countSuccessDetail' => $successCount,
            'countProcessingDetail' => $processingCount,
            'countCancelDetail' => $cancelCount,
            'countRefundDetail' => $refundCount,
            'countShipDetail' => $shipCount,

            'revenueSuccessDetail' => $successRevenue,
            'revenueProcessingDetail' => $processingRevenue,
            'revenueCancelDetail' => $cancelRevenue,
            'revenueRefundDetail' => $refundRevenue,
            'revenueShipDetail' => $shipRevenue,
        ];
    }

    // B2: hàm chung đếm đơn hàng theo trạng thái truyền vào, điều kiện lọc theo date cho nhân viên
    public function countOrdersByDateAndStatusForEmployee($employeeId, $status, $startDate, $endDate)
    {
        return $this->filterDate(
            $this->model->whereHas('orderStatuses', function ($q) use ($status, $employeeId) {
                $q->where('name', $status)
                    ->where('order_order_status.modified_by', $employeeId);
            }),
            $startDate,
            $endDate
        )->count();
    }

    // Hàm lấy doanh thu theo status và date cho nhân viên xử lý
    public function getRevenueByDateAndStatusForEmployee($employeeId, $status, $startDate, $endDate)
    {
        return $this->filterDate(
            $this->model->whereHas('orderStatuses', function ($q) use ($status, $employeeId) {
                $q->where('name', $status)
                    ->where('order_order_status.modified_by', $employeeId);
            }),
            $startDate,
            $endDate
        )->sum('total_amount');
    }

    // lấy tổng doanh thu 
    public function getTotalRevenueForEmployee($employeeId, $startDate, $endDate)
    {
        return $this->filterDate(
            $this->model->whereHas('orderStatuses', function ($q) use ($employeeId) {

                $q->where('order_order_status.modified_by', $employeeId);
            }),
            $startDate,
            $endDate
        )->sum('total_amount');
    }



    // Đếm toàn bộ số lượng đơn đã xử lý theo 3 trạng thái cơ bản tổng, success, cancel
    public function countOrderByEmployeeId($employeeId)
    {
        // $employee = Auth::user();
        // if (!$employee || $employee->role != 1) {
        //     return null;
        // }
        // $employeeId = $employee->id;
        $allCount = $this->model->whereHas('orderStatuses', function ($query) use ($employeeId) {
            $query->where('order_order_status.modified_by', $employeeId);
        })->count(); // tất cả các đơn mà nhẫn viên đã xử lý
        $successCount = $this->model->whereHas('orderStatuses', function ($q) use ($employeeId) {
            $q->where('order_status_id', 6) //hoàn thành
                ->where('order_order_status.modified_by', $employeeId);
        })->count();

        $cancelCount = $this->model->whereHas('orderStatuses', function ($q) use ($employeeId) {
            $q->where('order_status_id', 7) //hủy
                ->where('order_order_status.modified_by', $employeeId);
        })->count();
        $refundCount = $this->model->whereHas('orderStatuses', function ($q) use ($employeeId) {
            $q->where('is_refund', 1) //hoàn thành
                ->where('order_order_status.modified_by', $employeeId);
        })->count();
        //hoàn hàng
        // $refundCount = $this->model->where('user_id', $userId)->whereHas('orderStatuses', function ($q) {
        //     $q->where('is_refund', 1);
        // })->count();
        return [
            'allCount' => $allCount,
            'successCount' => $successCount,
            'cancelCount' => $cancelCount,
            'refundCount' => $refundCount
        ];
    }

    
}
