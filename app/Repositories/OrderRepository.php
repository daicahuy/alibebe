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
        $listOrders = $this->model->where('user_id', $userId) // Lọc theo user_id
            ->with(['payment', 'orderStatuses']) // Eager loading payment và orderStatuses
            ->select('id', 'code', 'user_id', 'payment_id', 'is_refund', 'total_amount', 'created_at') // Chỉ chọn các cột cần
            ->orderByDesc('created_at'); // Sắp xếp theo ngày tạo mới nhất


        $listOrders->with(['refund']);


        if ($filterStatus) {
            if ($filterStatus == 'refunded') {
                // Lọc tất cả đơn hàng có is_refund = true
                $listOrders->where('is_refund', true);
            } elseif ($filterStatus == 'Hoàn thành') {
                // BỘ LỌC CHO 'Hoàn thành' (Doanh số user): Đơn Hoàn thành không hoàn tiền HOẶC Đơn Hoàn tiền (trạng thái KHÁC completed)
                $listOrders->where(function ($query) {
                    // Phần 1: Đơn hàng có trạng thái HIỆN TAI là 'Hoàn thành' (ID 5) VÀ is_refund = 0
                    $query->where('is_refund', 0)
                          ->whereHas('orderStatuses', function ($q) {
                              $q->where('order_order_status.is_current', 1);
                              $q->where('name', 'Hoàn thành'); // Lọc theo tên
                          });
                    // Phần 2: HOẶC Đơn hàng có is_refund = 1 VÀ trạng thái hoàn tiền KHÁC 'completed'
                    $query->orWhere(function ($q) {
                        $q->where('is_refund', 1);
                        $q->whereHas('refund', function ($r) {
                              $r->where('refunds.status', '!=', 'completed');
                          });
                    });
                });
            } else {
                // Lọc theo trạng thái HIỆN TAI có tên đó
                 $listOrders->whereHas('orderStatuses', function ($q) use ($filterStatus) {
                           $q->where('order_order_status.is_current', 1);
                           $q->where('name', $filterStatus); // Lọc theo tên
                       });
            }
        }

        // Đã bỏ lọc ngày tại đây

        return $listOrders->paginate(5, ['*'], 'order_page'); // Phân trang kết quả
    }
    public function countUserOrderById($userId)
    {

        $user = User::with('orders')->findOrFail($userId);

        return $user->orders->count();
    }

    // phương thức thanh toán
    public function getPaymentMethod($userId, $startDate = null, $endDate = null)
    {

        $query = $this->model->where('user_id', $userId); // Tập hợp ban đầu là đơn hàng của user


        $query = $this->filterDate($query, $startDate, $endDate);
        $query->whereDoesntHave('orderStatuses', function ($q) {
            $q->where('order_order_status.is_current', 1)
                ->where('order_status_id', 6); // Sử dụng hằng số ID 6
        });


        $query->whereDoesntHave('orderStatuses', function ($q) {
            $q->where('order_order_status.is_current', 1)
                ->where('order_status_id', 4); // Sử dụng hằng số ID 4
        });


        $query->where(function ($q) {
            $q->where('is_refund', 0); 
            $q->orWhere(function ($q2) { 
                $q2->where('is_refund', 1);
                $q2->whereDoesntHave('refund', function ($r) {
                    $r->where('refunds.status', 'completed');
                });
            });
        });



        // Tiếp tục xử lý trên tập hợp đơn hàng ĐÃ LỌC (những đơn đủ điều kiện tính vào Tổng doanh số)
        return $query
            ->with('payment', function ($q) { 
                $q->select(['id', 'name']);
            })
            ->get() 
            ->groupBy('payment.name') // Gom nhóm theo tên phương thức thanh toá
            ->map(function ($orders, $paymentName) {
               
                return [
                    'payment_method' => $paymentName,
                    'order_count' => $orders->count(), 
                    'total_revenue' => $orders->sum('total_amount', ) 
                ];
            })->values(); 
    }


    // đếm đơn hàng theo status
    public function countOrderByUserId($userId)
    {
        // Tổng số đơn hàng của user (không lọc ngày)
        $allCount = $this->model->where('user_id', $userId)->count();
        $completedNonRefundedCount = $this->model
            ->where('user_id', $userId)
            ->where('is_refund', 0)
            ->whereHas('orderStatuses', function ($q) {
                $q->where('order_order_status.is_current', 1)
                    ->where('order_status_id', 5);
            })->count();


        $nonCompletedRefundCount = $this->model
            ->where('user_id', $userId)
            ->where('is_refund', 1)
            ->whereHas('refund', function ($q) {

                $q->where('refunds.status', '!=', 'completed');
            })->count();

        $successCount = $completedNonRefundedCount + $nonCompletedRefundCount;

        $cancelCount = $this->model
            ->where('user_id', $userId)
            ->whereHas('orderStatuses', function ($q) {
                $q->where('order_order_status.is_current', 1)
                    ->where('order_status_id', 6);
            })->count();

        $refundCount = $this->model
            ->where('user_id', $userId)
            ->where('is_refund', 1)
            ->count();
        return [
            'allCount' => $allCount,
            'successCount' => $successCount,
            'cancelCount' => $cancelCount,
            'refundCount' => $refundCount
        ];
    }

    // chi tiết các đơn hàng




    // B3 hàm chung gọi ra từng trạng thái 
    public function countOrderDetail($userId, $status, $startDate, $endDate)
    {
        // số lượng đơn
        $allCount = $this->filterDate($this->model->where('user_id', $userId), $startDate, $endDate)->count();
        $successCount = $this->countOrdersByDateAndStatus($userId, 5, $startDate, $endDate);
        $falseCount = $this->countOrdersByDateAndStatus($userId, 4, $startDate, $endDate);
        $processingCount = $this->countOrdersByDateAndStatus($userId, 2, $startDate, $endDate);
        $shipCount = $this->countOrdersByDateAndStatus($userId, 3, $startDate, $endDate);
        $cancelCount = $this->countOrdersByDateAndStatus($userId, 6, $startDate, $endDate);
        $refundCount = $this->filterDate($this->model->where('user_id', $userId)->where('is_refund', 1)->whereHas('refund', function ($q) { // Giả định mối quan hệ là 'refund'
            $q->where('refunds.status', 'completed'); 
        }), $startDate, $endDate)->count();
        $refundFalse = $this->countRefundFalse($userId, $startDate, $endDate);

        // tiền
        $successRevenue = $this->getRevenueByDateAndStatus($userId, 5, $startDate, $endDate);
        $falseRevenue = $this->getRevenueByDateAndStatus($userId, 4, $startDate, $endDate);
        $processingRevenue = $this->getRevenueByDateAndStatus($userId, 2, $startDate, $endDate);
        $shipRevenue = $this->getRevenueByDateAndStatus($userId, 3, $startDate, $endDate);
        $cancelRevenue = $this->getRevenueByDateAndStatus($userId, 6, $startDate, $endDate);
        $refundRevenue = $this->filterDate($this->model->where('user_id', $userId)->where('is_refund', 1)->whereHas('refund', function ($q) { // Giả định mối quan hệ là 'refund'
            $q->where('refunds.status', 'completed'); 
        }), $startDate, $endDate)->sum('total_amount');
        $refundFalseRevenue = $this->getRevenueRefundFalse($userId, $startDate, $endDate);

        return [
            'countAllDetail' => $allCount,
            'countSuccessDetail' => $successCount + $refundFalse,
            'countProcessingDetail' => $processingCount,
            'countCancelDetail' => $cancelCount,
            'countRefundDetail' => $refundCount,
            'countShipDetail' => $shipCount,
            'countFalseDetail' => $falseCount,

            'revenueSuccessDetail' => $successRevenue + $refundFalseRevenue,
            'revenueProcessingDetail' => $processingRevenue,
            'revenueCancelDetail' => $cancelRevenue,
            'revenueRefundDetail' => $refundRevenue,
            'revenueShipDetail' => $shipRevenue,
            'revenueFalseDetail' => $falseRevenue,
        ];
    }

    // đếm  hoàn ko thành công
    public function countRefundFalse($userId, $startDate, $endDate)
    {
        $query = $this->model
            ->where('user_id', $userId) 
            ->where('is_refund', 1) 
            ->whereHas('refund', function ($q) { 
                $q->where('refunds.status', '!=', 'completed'); 
            });
        return $this->filterDate($query, $startDate, $endDate)->count();
    }

    // doanh số hoàn ko thành công
    public function getRevenueRefundFalse($userId, $startDate, $endDate)
    {
        $query = $this->model
            ->where('user_id', $userId) 
            ->where('is_refund', 1) 
            ->whereHas('refund', function ($q) { 
                $q->where('refunds.status', '!=', 'completed'); 
            });

        return $this->filterDate($query, $startDate, $endDate)->sum('total_amount');
    }

    // B2: hàm chung đếm đơn hàng theo trạng thái truyền vào, điều kiện lọc theo date
    public function countOrdersByDateAndStatus($userId, $statusId, $startDate, $endDate)
    {
        $query = $this->model->where('user_id', $userId);

        $query->whereHas('orderStatuses', function ($q) use ($statusId) {
            $q->where('order_order_status.is_current', 1);
            $q->where('order_status_id', $statusId);
        });

        if ($statusId === 5) {
            $query->where('is_refund', 0);
        }

        return $this->filterDate(
            $query,
            $startDate,
            $endDate
        )->count();
    }


    // Hàm lấy doanh số theo status và date
    public function getRevenueByDateAndStatus($userId, $statusId, $startDate, $endDate) 
    {
        $query = $this->model->where('user_id', $userId); 

        
        $query->whereHas('orderStatuses', function ($q) use ($statusId) {
            $q->where('order_order_status.is_current', 1); 
            $q->where('order_status_id', $statusId); 
        });

    
        if ($statusId === 5) { 
            $query->where('is_refund', 0);
        }

       
        return $this->filterDate(
            $query,
            $startDate,
            $endDate
        )->sum('total_amount');
    }


    // lấy tổng doanh SỐ (bán được bao nhiêu), bao gồm tổng đơn bán được trong hoảng thời gian cụ thể (doanh thu = thu dc bnhieu)
    public function getTotalRevenue($userId, $startDate, $endDate)
    {
        // 1. Bắt đầu với TẤT CẢ đơn hàng của user trong khoảng thời gian
        $query = $this->model->where('user_id', $userId); 

       
        $query = $this->filterDate($query, $startDate, $endDate);

        // 2. Loại trừ những đơn hàng mà trạng thái HIỆN TAI là "Đã hủy" 
        $query->whereDoesntHave('orderStatuses', function ($q) {
            $q->where('order_order_status.is_current', 1)
                ->where('order_status_id', 6);
        });

        // 3. Loại trừ những đơn hàng mà trạng thái HIỆN TAI là "Giao hàng thất bại" 
        $query->whereDoesntHave('orderStatuses', function ($q) {
            $q->where('order_order_status.is_current', 1)
                ->where('order_status_id', 4);
        });

        // 4. Loại trừ những đơn hàng có is_refund=1 VÀ HOÀN HÀNG THÀNH CÔNG (status='completed') (bất kể ai xử lý)
        $query->where(function ($q) {
            $q->where('is_refund', 0); 
            $q->orWhere(function ($q2) { 
                $q2->where('is_refund', 1);
                $q2->whereDoesntHave('refund', function ($r) {
                    $r->where('refunds.status', 'completed');
                });
            });
        });


        // 5. Tính tổng total_amount của các đơn hàng còn lại sau khi lọc
        return $query->sum('total_amount');
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







    // employee - detail - NHÂN VIÊN

    // Lấy phương thức thanh toán các đơn hàng mà nhân viên đã xử lý
    public function getPaymentMethodForEmployee($employeeId, $startDate = null, $endDate = null)
    {
        // 1. orderStatus
        $query = $this->model->whereHas('orderStatuses', function ($query) use ($employeeId) {
            $query->where('order_order_status.modified_by', $employeeId);
        });



        // 2. Hủy
        $query->whereDoesntHave('orderStatuses', function ($q) use ($employeeId) {
            $q->where('order_order_status.is_current', 1)
                ->where('order_status_id', 6)
                ->where('order_order_status.modified_by', $employeeId);
        });
        // thất bại
        $query->whereDoesntHave('orderStatuses', function ($q) use ($employeeId) {
            $q->where('order_order_status.is_current', 1)
                ->where('order_status_id', 4)
                ->where('order_order_status.modified_by', $employeeId);
        });

        // 3.hoàn thành công

        $query->whereDoesntHave('refund', function ($q) {
            $q->where('refunds.status', 'completed');
        });


        // 4.date
        $query = $this->filterDate($query, $startDate, $endDate);

        // 5. Lấy dữ liệu, gom nhóm và tính tổng/đếm trên TẬP HỢP ĐƠN HÀNG ĐÃ LỌC
        return $query
            ->with('payment', function ($q) {
                $q->select(['id', 'name']);
            })
            ->get()
            ->groupBy('payment.name')
            ->map(function ($orders, $paymentName) {
                return [
                    'payment_method' => $paymentName, // Tên phương thức thanh toán
                    'order_count' => $orders->count(), // Số lượng đơn hàng trong nhóm này
                    'total_revenue' => $orders->sum('total_amount'), //  Tính tổng total_amount cho các đơn hàng trong nhóm ĐÃ LỌC
                ];
            })
            ->values();
    }


    // B3 hàm chung gọi ra từng trạng thái cho nhân viên
    public function countOrderDetailForEmployee($employeeId, $startDate, $endDate)
    {
        // số lượng đơn
        $allCountQuery = $this->model->where(function ($query) use ($employeeId) {

            $query->whereHas('orderStatuses', function ($q) use ($employeeId) {
                $q->where('order_order_status.modified_by', $employeeId);
            });

            $query->orWhereHas('refund', function ($q) use ($employeeId) {
                $q->where('refunds.user_handle', $employeeId);
            });
        });
        $allCount = $this->filterDate($allCountQuery, $startDate, $endDate)->count();

        // đếm
        $successCount = $this->countOrdersByDateAndStatusForEmployee($employeeId, 5, $startDate, $endDate);
        $refoundFalseCount = $this->countRefoundFalse($employeeId, $startDate, $endDate);
        $falseCount = $this->countOrdersByDateAndStatusForEmployee($employeeId, 4, $startDate, $endDate);
        $processingCount = $this->countOrdersByDateAndStatusForEmployee($employeeId, 2, $startDate, $endDate);
        $cancelCount = $this->countOrdersByDateAndStatusForEmployee($employeeId, 6, $startDate, $endDate);
        $shipCount = $this->countOrdersByDateAndStatusForEmployee($employeeId, 3, $startDate, $endDate);
        $refundCount = $this->countRefundedByEmployee($employeeId, $startDate, $endDate);

        // tiền
        $successRevenue = $this->getRevenueByDateAndStatusForEmployee($employeeId, 5, $startDate, $endDate);
        $refoundFalseRevenue = $this->getRevenuedRefoundFalse($employeeId, $startDate, $endDate);
        $falseRevenue = $this->getRevenueByDateAndStatusForEmployee($employeeId, 4, $startDate, $endDate);
        $processingRevenue = $this->getRevenueByDateAndStatusForEmployee($employeeId, 2, $startDate, $endDate);
        $cancelRevenue = $this->getRevenueByDateAndStatusForEmployee($employeeId, 6, $startDate, $endDate);
        $shipRevenue = $this->getRevenueByDateAndStatusForEmployee($employeeId, 3, $startDate, $endDate);
        $refundRevenue = $this->getRevenueRefundByEmployee($employeeId, $startDate, $endDate);



        return [
            'countAllDetail' => $allCount,
            'countSuccessDetail' => $successCount + $refoundFalseCount,
            'countFalseDetail' => $falseCount,
            'countProcessingDetail' => $processingCount,
            'countCancelDetail' => $cancelCount,
            'countRefundDetail' => $refundCount,
            'countShipDetail' => $shipCount,

            'revenueSuccessDetail' => $successRevenue + $refoundFalseRevenue,
            'revenueFalseDetail' => $falseRevenue,
            'revenueProcessingDetail' => $processingRevenue,
            'revenueCancelDetail' => $cancelRevenue,
            'revenueRefundDetail' => $refundRevenue,
            'revenueShipDetail' => $shipRevenue,
        ];
    }

    // B2: hàm chung đếm đơn hàng theo trạng thái truyền vào, điều kiện lọc theo date cho nhân viên
    public function countOrdersByDateAndStatusForEmployee($employeeId, $statusId, $startDate, $endDate)
    {
        $query = $this->model
            ->where('is_refund', 0) // <<< Chỉ đếm đơn không hoàn tiền cho các trạng thái này
            ->whereHas('orderStatuses', function ($q) use ($employeeId, $statusId) {
                $q->where('order_order_status.is_current', 1) // <<< Dựa vào cột is_current = 1
                    ->where('order_status_id', $statusId) // <<< Lọc theo ID trạng thái
                    ->where('order_order_status.modified_by', $employeeId); // <<< Nhân viên đã đặt trạng thái HIỆN TẠI này
            });

        // Áp dụng lọc ngày tạo đơn hàng chính (orders.created_at)
        return $this->filterDate($query, $startDate, $endDate)->count();
    }

    // Hàm lấy doanh số theo status và date do nhân viên xử lý
    public function getRevenueByDateAndStatusForEmployee($employeeId, $statusId, $startDate, $endDate)
    {
        $query = $this->model
            ->where('is_refund', 0) // <<< Chỉ tính doanh số cho đơn không hoàn tiền
            ->whereHas('orderStatuses', function ($q) use ($employeeId, $statusId) {
                $q->where('order_order_status.is_current', 1) // <<< Dựa vào cột is_current = 1
                    ->where('order_status_id', $statusId) // <<< Lọc theo ID trạng thái
                    ->where('order_order_status.modified_by', $employeeId); // <<< Nhân viên đã đặt trạng thái HIỆN TẠI này
            });
        return $this->filterDate($query, $startDate, $endDate)->sum('total_amount');
    }

    //  đếm số đơn hàng HOÀN HÀNG THẤT BẠI
    public function countRefoundFalse($employeeId, $startDate, $endDate)
    {
        $query = $this->model
            ->where('is_refund', 1)
            ->whereHas('refund', function ($q) use ($employeeId) {
                $q->where('refunds.user_handle', $employeeId);
                // CHỈ bao gồm yêu cầu hoàn tiền ở trạng thái 'failed'
                $q->where('refunds.status', '!=', 'completed');
            });

        return $this->filterDate($query, $startDate, $endDate)->count();
    }

    // doanh số cho đơn hàng HOÀN HÀNG THẤT BẠI
    public function getRevenuedRefoundFalse($employeeId, $startDate, $endDate)
    {
        $query = $this->model
            ->where('is_refund', 1)
            ->whereHas('refund', function ($q) use ($employeeId) {
                $q->where('refunds.user_handle', $employeeId);

                $q->where('refunds.status', '!=', 'completed');
            });
        return $this->filterDate($query, $startDate, $endDate)->sum('total_amount');
    }



    // đếm đơn hoàn hàng 
    public function countRefundedByEmployee($employeeId, $startDate, $endDate)
    {
        $query = $this->model
            ->where('is_refund', 1)
            ->whereHas('refund', function ($q) use ($employeeId) {
                $q->where('refunds.user_handle', $employeeId);
                $q->where('refunds.status', 'completed');
            });
        return $this->filterDate($query, $startDate, $endDate)->count();
    }

    // doanh số đơn hoàn 
    public function getRevenueRefundByEmployee($employeeId, $startDate, $endDate)
    {
        $query = $this->model
            ->where('is_refund', 1)
            ->whereHas('refund', function ($q) use ($employeeId) {
                $q->where('refunds.user_handle', $employeeId);
                $q->where('refunds.status', 'completed');
            });

        return $this->filterDate($query, $startDate, $endDate)->sum('total_amount');
    }

    // lấy tổng doanh số 
    public function getTotalRevenueForEmployee($employeeId, $startDate, $endDate)
    {
        // 1. Bắt đầu với tập hợp đơn hàng mà nhân viên đã xử lý (tương tác trạng thái HOẶC xử lý quy trình hoàn tiền) - Định nghĩa 2
        $query = $this->model->where(function ($query) use ($employeeId) {
            $query->whereHas('orderStatuses', function ($q) use ($employeeId) {
                $q->where('order_order_status.modified_by', $employeeId);
            });
            $query->orWhereHas('refund', function ($q) use ($employeeId) { // Giả định mối quan hệ là 'refund'
                $q->where('refunds.user_handle', $employeeId);
            });
        });

        // 2. Loại trừ những đơn hàng mà trạng thái HIỆN TAI là "Đã hủy" (ID 6) (bất kể ai hủy)
        $query->whereDoesntHave('orderStatuses', function ($q) {
            $q->where('order_order_status.is_current', 1)
                ->where('order_status_id', 6);
        });

        // 3. Loại trừ những đơn hàng mà trạng thái HIỆN TAI là "Giao hàng thất bại" (ID 4) (bất kể ai đặt)
        $query->whereDoesntHave('orderStatuses', function ($q) {
            $q->where('order_order_status.is_current', 1)
                ->where('order_status_id', 4);
        });

        // 4. Loại trừ những đơn hàng có is_refund=1 VÀ HOÀN HÀNG THÀNH CÔNG (status='completed') (bất kể ai xử lý)

        $completedRefundOrderIds = $this->model
            ->where('is_refund', 1) // Phải là đơn hàng có đánh dấu hoàn tiền
            ->whereHas('refund', function ($q) { // Phải có bản ghi refund liên kết
                $q->where('refunds.status', 'completed'); // Và status của refund là 'completed'
            })
            ->select('id');


        $query->whereNotIn('id', $completedRefundOrderIds);


        // 5. Áp dụng lọc ngày tạo đơn hàng chính (orders.created_at) và tính tổng total_amount
        return $this->filterDate($query, $startDate, $endDate)->sum('total_amount');
    }




    // Đếm toàn bộ số lượng đơn đã xử lý theo 3 trạng thái cơ bản tổng, success, cancel
    public function countOrderByEmployeeId($employeeId)
    {

        $allCountQuery = $this->model->where(function ($query) use ($employeeId) {
            // Đơn hàng mà nhân viên đã tương tác trạng thái (bất kỳ trạng thái nào, bất kỳ lúc nào)
            $query->whereHas('orderStatuses', function ($q) use ($employeeId) {
                $q->where('order_order_status.modified_by', $employeeId);
            });
            //  (qua bảng refunds)

            $query->orWhereHas('refund', function ($q) use ($employeeId) {
                $q->where('refunds.user_handle', $employeeId);
            });
        });
        $allCount = $allCountQuery->count();


        //  Hoàn thành
        $successCount = $this->model
            ->where('is_refund', 0)
            ->whereHas('orderStatuses', function ($q) use ($employeeId) {
                $q->where('order_order_status.is_current', 1)
                    ->where('order_status_id', 5) //
                    ->where('order_order_status.modified_by', $employeeId);
            })->count();

        //    hủy
        $cancelCount = $this->model
            ->where('is_refund', 0)
            ->whereHas('orderStatuses', function ($q) use ($employeeId) {
                $q->where('order_order_status.is_current', 1)
                    ->where('order_status_id', 6)
                    ->where('order_order_status.modified_by', $employeeId);
            })->count();

        //    hoàn
        $refundCount = $this->model
            ->where('is_refund', 1)
            ->whereHas('refund', function ($q) use ($employeeId) {

                $q->where('refunds.user_handle', $employeeId);

            })->count();


        return [
            'allCount' => $allCount, // Tổng số đơn nhân viên đã xử lý (Định nghĩa 2)
            'successCount' => $successCount, // Đơn Hoàn thành HIỆN TẠI (không hoàn tiền) do nhân viên đặt
            'cancelCount' => $cancelCount, // Đơn Đã hủy HIỆN TẠI (không hoàn tiền) do nhân viên đặt
            'refundCount' => $refundCount // Đơn Hoàn hàng (is_refund=1) do nhân viên xử lý quy trình hoàn tiền
        ];
    }


}
