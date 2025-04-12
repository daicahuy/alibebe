<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardRepository extends BaseRepository
{
    public function getModel()
    {
        return Order::class;
    }
    public function employee()
    {
        $employee = DB::table('users')->where('role', 1)->get();
        return $employee;
    }
    public function revenue($start_date = null, $IdEmployee = '')
    {
        $sevenDaysAgo = now()->subDays(7)->startOfDay();
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }
        // dd($IdEmployee); 
        if ( $IdEmployee == 0) {
            $query = Order::whereHas('orderStatuses', function ($query) use ($sevenDaysAgo) {
                $query->where('order_status_id', 6)
                    ->where('updated_at', '<=', $sevenDaysAgo);
            })->whereBetween('created_at', [$start, $end]);
        } elseif ( $IdEmployee != 0) {
            $query = Order::whereHas('orderStatuses', function ($query) use ($IdEmployee, $sevenDaysAgo) {
                $query->where('order_status_id', 6)
                    ->where('modified_by', $IdEmployee)
                    ->where('updated_at', '<=', $sevenDaysAgo);
            })->whereBetween('created_at', [$start, $end]);
        } else {
            $query = Order::whereHas('orderStatuses', function ($query) use ($sevenDaysAgo) {
                $query->where('order_status_id', 6)
                    ->where('updated_at', '<=', $sevenDaysAgo);
            })->whereDate('created_at', now()->toDateString());
        }

        return $query->sum('total_amount');
    }

    public function countOrderPending()
    {
        $employee = Auth::id();
        $countProduct = Order::whereHas('orderStatuses', function ($query) {
            $query->where('order_status_id', 1);
        })->whereDate('created_at', now()->toDateString())->count();
        return $countProduct;
    }
    public function countOrderDelivery($start_date = null, $IdEmployee = '')
    {
        $statusIds = [3, 4, 5, 6, 8];
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }
        // dd($IdEmployee);
        if ($IdEmployee == 0) {
            $countOrderDelivery = Order::whereHas('orderStatuses', function ($query) use ($statusIds) {
                $query->whereIn('order_status_id', $statusIds);
            })->whereBetween('created_at', [$start, $end])->count();
        } else if ($IdEmployee != 0) {
            $countOrderDelivery = Order::whereHas('orderStatuses', function ($query) use ($IdEmployee, $statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $IdEmployee);
            })->whereBetween('created_at', [$start, $end])->count();
        } else {
            $countOrderDelivery = Order::whereHas('orderStatuses', function ($query) use ($statusIds) {
                $query->whereIn('order_status_id', $statusIds);
            })->whereDate('created_at', now()->toDateString())->count();
        }
        // dd($countOrderDelivery);
        return $countOrderDelivery;
    }
    public function countOrderComplete($start_date = null, $IdEmployee = '')
    {
        $statusIds = [6];
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }
        // dd($IdEmployee);
        if ($IdEmployee == 0) {
            $countOrderComplete = Order::whereHas('orderStatuses', function ($query) use ($statusIds) {
                $query->whereIn('order_status_id', $statusIds);
            })->whereBetween('created_at', [$start, $end])->count();
        } else if ($IdEmployee != 0) {
            $countOrderComplete = Order::whereHas('orderStatuses', function ($query) use ($IdEmployee, $statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $IdEmployee);
            })->whereBetween('created_at', [$start, $end])->count();
        } else {
            $countOrderComplete = Order::whereHas('orderStatuses', function ($query) use ($statusIds) {
                $query->whereIn('order_status_id', $statusIds);
            })->whereDate('created_at', now()->toDateString())->count();
        }
        // dd($countOrderComplete);
        return $countOrderComplete;
    }
    public function countOrderReturns($start_date = null, $IdEmployee = '')
    {
        $statusIds = [8];
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }
        // dd($IdEmployee);
        if ($IdEmployee == 0) {
            $countOrderReturns = Order::whereHas('orderStatuses', function ($query) use ($statusIds) {
                $query->whereIn('order_status_id', $statusIds);
            })->whereBetween('created_at', [$start, $end])->count();
        } else if ($IdEmployee != 0) {
            $countOrderReturns = Order::whereHas('orderStatuses', function ($query) use ($IdEmployee, $statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $IdEmployee);
            })->whereBetween('created_at', [$start, $end])->count();
        } else {
            $countOrderReturns = Order::whereHas('orderStatuses', function ($query) use ($statusIds) {
                $query->whereIn('order_status_id', $statusIds);
            })->whereDate('created_at', now()->toDateString())->count();
        }
        // dd($countOrderReturns);
        return $countOrderReturns;
    }
    public function countOrderFailed($start_date = null, $IdEmployee = '')
    {
        $statusIds = [5];
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }
        // dd($IdEmployee);
        if ($IdEmployee == 0) {
            $countOrderFailed = Order::whereHas('orderStatuses', function ($query) use ($statusIds) {
                $query->whereIn('order_status_id', $statusIds);
            })->whereBetween('created_at', [$start, $end])->count();
        } else if ($IdEmployee != 0) {
            $countOrderFailed = Order::whereHas('orderStatuses', function ($query) use ($IdEmployee, $statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $IdEmployee);
            })->whereBetween('created_at', [$start, $end])->count();
        } else {
            $countOrderFailed = Order::whereHas('orderStatuses', function ($query) use ($statusIds) {
                $query->whereIn('order_status_id', $statusIds);
            })->whereDate('created_at', now()->toDateString())->count();
        }
        // dd($countOrderFailed);
        return $countOrderFailed;
    }
    public function countOrderProcessing($start_date = null, $IdEmployee = '')
    {
        $statusIds = [2];
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }
        // dd($IdEmployee);
        if ($IdEmployee == 0) {
            $countOrderProcessing = Order::whereHas('orderStatuses', function ($query) use ($statusIds) {
                $query->whereIn('order_status_id', $statusIds);
            })->whereBetween('created_at', [$start, $end])->count();
        } else if ($IdEmployee != 0) {
            $countOrderProcessing = Order::whereHas('orderStatuses', function ($query) use ($IdEmployee, $statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $IdEmployee);
            })->whereBetween('created_at', [$start, $end])->count();
        } else {
            $countOrderProcessing = Order::whereHas('orderStatuses', function ($query) use ($statusIds) {
                $query->whereIn('order_status_id', $statusIds);
            })->whereDate('created_at', now()->toDateString())->count();
        }
        // dd($countOrderProcessing);
        return $countOrderProcessing;
    }

    public function countUser()
    {
        $countUser = DB::table('users')->count();
        return $countUser;
    }
    public function newCountUser($start_date = null)
    {
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }
        if ($start && $end) {
            $newCountUser = DB::table('users')->whereBetween('created_at', [$start, $end])->count();
        } else {
            $newCountUser = DB::table('users')->whereDate('created_at', now()->toDateString())->count();
        }
        // dd($newCountUser);
        return $newCountUser;
    }
    public function countOrder($start_date = null, $IdEmployee = '')
    {
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }
        if ($IdEmployee == 0) {
           
            $countOrder = Order::whereBetween('created_at', [$start, $end])->count();
        } else if ( $IdEmployee != 0) {
        
            $countOrder = Order::whereHas('orderStatuses', function ($query) use ($IdEmployee) {
                $query->where('modified_by', $IdEmployee);
            })->whereBetween('created_at', [$start, $end])->count();
        } else {
            $countOrder = DB::table('orders')->whereDate('created_at', now()->toDateString())->count();
        }

        return $countOrder;
    }
    public function topProduct()
    {
        $topProduct = DB::table('order_items as ot')
            ->join('products as p', 'p.id', '=', 'ot.product_id')
            ->join('orders as o', 'ot.order_id', '=', 'o.id')
            ->join('order_order_status as oos', 'o.id', '=', 'oos.order_id')
            ->join('order_statuses as os', 'oos.order_status_id', '=', 'os.id')
            ->where('os.id', '=', 6) // Chỉ lấy các đơn hàng có trạng thái "Hoàn thành"
            ->select(
                'ot.product_id',
                'p.name',
                'p.thumbnail',
                DB::raw('SUM(COALESCE(ot.quantity, 0) + COALESCE(ot.quantity_variant, 0)) as total_sold')
            )
            ->groupBy('ot.product_id', 'p.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return $topProduct;
    }
    public function topUser()
    {

        $topUser = DB::table('orders as o')
            ->join('users as u', 'u.id', '=', 'o.user_id')
            ->join('order_order_status as oos', 'o.id', '=', 'oos.order_id')
            ->join('order_statuses as os', 'oos.order_status_id', '=', 'os.id')
            ->where('os.id', '=', 6) // Chỉ lấy đơn hàng "Hoàn thành"

            ->select(
                'o.user_id',
                'u.fullname',
                'u.id',
                'loyalty_points',
                DB::raw('COUNT(o.id) as total_order'), // Số lượng đơn hoàn thành
                DB::raw('SUM(o.total_amount) as total_revenue') // Tổng tiền từ các đơn
            )
            ->groupBy('o.user_id', 'u.fullname')
            ->orderByDesc('u.loyalty_points') // Sắp xếp theo số đơn hàng
            ->limit(5)
            ->get();
        return $topUser;
    }
    public function getUserRank($loyaltyPoints)
    {
        $ranks = [
            'Newbie'   => [0, 100],
            'Iron'     => [101, 300],
            'Bronze'   => [301, 500],
            'Silver'   => [501, 700],
            'Gold'     => [701, 850],
            'Platinum' => [851, 999],
            'Diamond'  => [1000, PHP_INT_MAX],
        ];

        foreach ($ranks as $rank => [$min, $max]) {
            if ($loyaltyPoints >= $min && $loyaltyPoints <= $max) {
                return $rank;
            }
        }

        return 'Newbie';
    }

    public function getRevenueAndOrdersByHour($start_date = null, $IdEmployee = 0)
    {

        $sevenDaysAgo = now()->subDays(7)->startOfDay();
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }


        // Debug các giá trị start và end
        // dd($start, $end);

        // 🧠 Xác định khoảng cách thời gian
        $diffInDays = $start->diffInDays($end);
        $diffInMonths = $start->diffInMonths($end);

        // 🧩 Cách nhóm theo thời gian
        if ($diffInDays == 0) {
            $groupBy = 'FLOOR(HOUR(created_at) / 2) * 2';
            $selectFormat = 'FLOOR(HOUR(created_at) / 2) * 2 as time_label';
            $interval = '2 hours';
        } elseif ($diffInDays < 30) {
            $groupBy = 'DATE(created_at)';
            $selectFormat = 'DATE(created_at) as time_label';
            $interval = '1 day';
        } elseif ($diffInMonths < 12) {
            $groupBy = 'DATE_FORMAT(created_at, "%Y-%m")';
            $selectFormat = 'DATE_FORMAT(created_at, "%Y-%m") as time_label';
            $interval = '1 month';
        } else {
            $groupBy = 'YEAR(created_at)';
            $selectFormat = 'YEAR(created_at) as time_label';
            $interval = '1 year';
        }

        // Kiểm tra xem có chọn nhân viên không
        if ($IdEmployee == 0) {
            // Truy vấn dữ liệu cho tất cả nhân viên
            $data = Order::with('orderStatuses')
                ->whereHas('orderStatuses', function ($query) use ($sevenDaysAgo) {
                    $query->where('order_status_id', 6)
                        ->where('updated_at', '<=', $sevenDaysAgo);
                })
                ->whereBetween('created_at', [$start, $end]) // Lọc dữ liệu theo $start và $end
                ->selectRaw("$selectFormat, SUM(total_amount) as revenue, COUNT(id) as orders")
                ->groupBy(DB::raw($groupBy))
                ->orderBy(DB::raw($groupBy))
                ->get()
                ->keyBy('time_label');
        }
        // Kiểm tra nếu có nhân viên được chọn
        else if ($IdEmployee != 0) {
            // Truy vấn dữ liệu cho nhân viên cụ thể
            $data = Order::with('orderStatuses')
                ->whereHas('orderStatuses', function ($query) use ($IdEmployee, $sevenDaysAgo) {
                    $query->where('order_status_id', 6)
                        ->where('modified_by', $IdEmployee)
                        ->where('updated_at', '<=', $sevenDaysAgo);
                })
                ->whereBetween('created_at', [$start, $end]) // Lọc dữ liệu theo $start và $end
                ->selectRaw("$selectFormat, SUM(total_amount) as revenue, COUNT(id) as orders")
                ->groupBy(DB::raw($groupBy))
                ->orderBy(DB::raw($groupBy))
                ->get()
                ->keyBy('time_label');
        }
        // Nếu không có lựa chọn nào, mặc định là hôm nay
        else {
            $start = now()->startOfDay();
            $end = now()->endOfDay();
            $interval = '2 hours';

            $data = Order::with('orderStatuses')
                ->whereHas('orderStatuses', function ($query) use ($sevenDaysAgo) {
                    $query->where('order_status_id', 6)
                        ->where('updated_at', '<=', $sevenDaysAgo);
                })
                ->whereDate('created_at', now()->toDateString())
                ->selectRaw('FLOOR(HOUR(created_at) / 2) * 2 as time_label, SUM(total_amount) as revenue, COUNT(id) as orders')
                ->groupBy('time_label')
                ->orderBy('time_label')
                ->get()
                ->keyBy('time_label');
        }

        // 🏷️ Tạo labels
        $period = new CarbonPeriod($start, $interval, $end);
        $labels = [];
        foreach ($period as $date) {
            if ($diffInDays == 0) {
                $hour = $date->format('G');
                if ($hour % 2 == 0) {
                    $labels[] = $date->format('G:00');
                }
            } elseif ($diffInDays < 30) {
                $labels[] = $date->format('Y-m-d');
            } elseif ($diffInMonths < 12) {
                $labels[] = $date->format('Y-m');
            } else {
                $labels[] = $date->format('Y');
            }
        }

        // 📊 Gán doanh thu và số đơn
        $revenues = [];
        $orders = [];
        foreach ($labels as $label) {
            $key = ($diffInDays == 0) ? (int) explode(':', $label)[0] : $label;
            $revenues[] = $data[$key]->revenue ?? 0;
            $orders[] = $data[$key]->orders ?? 0;
        }

        return [
            'labels' => $labels,
            'revenues' => $revenues,
            'orders' => $orders,
        ];
    }


    public function getOrderStatusByHour($start_date = null, $IdEmployee = '')
    {
        $orderStatuses = OrderStatus::pluck('name', 'id')->toArray();

        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }
        $diffInDays = $start->diffInDays($end);
        $diffInMonths = $start->diffInMonths($end);
        if ($IdEmployee == 0) {
            $diffInDays = $start->diffInDays($end);
        $diffInMonths = $start->diffInMonths($end);
            if ($diffInDays == 0) {
                $groupBy = 'FLOOR(HOUR(orders.created_at) / 2) * 2';
                $selectFormat = 'FLOOR(HOUR(orders.created_at) / 2) * 2 as time_label';
                $interval = '2 hours';
            } elseif ($diffInDays < 30) {
                $groupBy = 'DATE(orders.created_at)';
                $selectFormat = 'DATE(orders.created_at) as time_label';
                $interval = '1 day';
            } elseif ($diffInMonths < 12) {
                $groupBy = 'DATE_FORMAT(orders.created_at, "%Y-%m")';
                $selectFormat = 'DATE_FORMAT(orders.created_at, "%Y-%m") as time_label';
                $interval = '1 month';
            } else {
                $groupBy = 'YEAR(orders.created_at)';
                $selectFormat = 'YEAR(orders.created_at) as time_label';
                $interval = '1 year';
            }

            $data = Order::join('order_order_status', 'orders.id', '=', 'order_order_status.order_id')
                ->join('order_statuses', 'order_order_status.order_status_id', '=', 'order_statuses.id')

                ->whereBetween('orders.created_at', [$start, $end])
                ->selectRaw("$selectFormat, order_statuses.id as order_status_id, COUNT(orders.id) as total_orders")
                ->groupBy(DB::raw($groupBy), 'order_status_id')
                ->orderBy(DB::raw($groupBy))
                ->get();
        } else if ($IdEmployee != 0) {
            if ($diffInDays == 0) {
                $groupBy = 'FLOOR(HOUR(orders.created_at) / 2) * 2';
                $selectFormat = 'FLOOR(HOUR(orders.created_at) / 2) * 2 as time_label';
                $interval = '2 hours';
            } elseif ($diffInDays < 30) {
                $groupBy = 'DATE(orders.created_at)';
                $selectFormat = 'DATE(orders.created_at) as time_label';
                $interval = '1 day';
            } elseif ($diffInMonths < 12) {
                $groupBy = 'DATE_FORMAT(orders.created_at, "%Y-%m")';
                $selectFormat = 'DATE_FORMAT(orders.created_at, "%Y-%m") as time_label';
                $interval = '1 month';
            } else {
                $groupBy = 'YEAR(orders.created_at)';
                $selectFormat = 'YEAR(orders.created_at) as time_label';
                $interval = '1 year';
            }

            $data = Order::join('order_order_status', 'orders.id', '=', 'order_order_status.order_id')
                ->join('order_statuses', 'order_order_status.order_status_id', '=', 'order_statuses.id')
                ->whereHas('orderStatuses', function ($query) use ($IdEmployee) {
                    $query->where('modified_by', $IdEmployee);
                })
                ->whereBetween('orders.created_at', [$start, $end])
                ->selectRaw("$selectFormat, order_statuses.id as order_status_id, COUNT(orders.id) as total_orders")
                ->groupBy(DB::raw($groupBy), 'order_status_id')
                ->orderBy(DB::raw($groupBy))
                ->get();
        } else {

            $interval = '2 hours';

            $data = Order::join('order_order_status', 'orders.id', '=', 'order_order_status.order_id')
                ->join('order_statuses', 'order_order_status.order_status_id', '=', 'order_statuses.id')
                ->whereDate('orders.created_at', now()->toDateString())
                ->selectRaw('FLOOR(HOUR(orders.created_at) / 2) * 2 as time_label, order_statuses.id as order_status_id, COUNT(orders.id) as total_orders')
                ->groupBy('time_label', 'order_status_id')
                ->orderBy('time_label')
                ->get();
        }

        $period = new CarbonPeriod($start, $interval, $end);
        $labels = [];
        $ordersByStatus = [];

        foreach ($period as $date) {
            if ($diffInDays == 0) {
                $hour = $date->format('G');
                if ($hour % 2 == 0) {
                    $labels[] = $date->format('G:00');
                }
            } elseif ($diffInDays < 30) {
                $labels[] = $date->format('Y-m-d');
            } elseif ($diffInMonths < 12) {
                $labels[] = $date->format('Y-m');
            } else {
                $labels[] = $date->format('Y');
            }
        }

        foreach ($labels as $label) {
            $key = ($diffInDays == 0) ? (int) explode(':', $label)[0] : $label;
            foreach ($orderStatuses as $statusId => $statusName) {
                $ordersByStatus[$statusName][$key] = 0;
            }
        }

        foreach ($data as $order) {
            $key = ($diffInDays == 0) ? (int) $order->time_label : $order->time_label;
            if (isset($orderStatuses[$order->order_status_id])) {
                $ordersByStatus[$orderStatuses[$order->order_status_id]][$key] = $order->total_orders;
            }
        }

        return [
            'labels' => $labels,
            'orders' => $ordersByStatus
        ];
    }






























    public function revenueEmployee($start_date = null)
    {
        $employee = Auth::id();
        $sevenDaysAgo = now()->subDays(7)->startOfDay();
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }
        if ($start_date) {
          
            $query = Order::whereHas('orderStatuses', function ($query) use ($employee,$sevenDaysAgo) {
                $query->where('order_status_id', 6)->where('updated_at', '<=', $sevenDaysAgo)->where('modified_by', $employee);
            })->whereBetween('created_at', [$start, $end]);
        } else {
            $query = Order::whereHas('orderStatuses', function ($query) use ($employee,$sevenDaysAgo) {
                $query->where('order_status_id', 6)->where('updated_at', '<=', $sevenDaysAgo)->where('modified_by', $employee);
            })->whereDate('created_at', now()->toDateString());
        }
        // dd($query->sum('total_amount'));
        return $query->sum('total_amount');
    }

    public function countOrderPendingEmployee()
    {
        $employee = Auth::id();
        $countProduct = Order::whereHas('orderStatuses', function ($query) use ($employee) {
            $query->where('order_status_id', 1)->where('modified_by', $employee);
        })->whereDate('created_at', now()->toDateString())->count();
        return $countProduct;
    }
    public function countOrderDeliveryEmployee($start_date = null)
    {
        $employee = Auth::id();
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }
        $statusIds = [3, 4, 5, 6,8];
        if ($start_date ) {
          
            $countOrderDelivery = Order::whereHas('orderStatuses', function ($query) use ($employee,$statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $employee);
            })->whereBetween('created_at', [$start, $end])->count();
        } else if ($start_date ) {
            
            $countOrderDelivery = Order::whereHas('orderStatuses', function ($query) use ($employee,$statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $employee);
            })->whereBetween('created_at', [$start, $end])->count();
        } else {
            $countOrderDelivery = Order::whereHas('orderStatuses', function ($query) use ($employee,$statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $employee);
            })->whereDate('created_at', now()->toDateString())->count();
        }
        // dd($countOrderDelivery);
        return $countOrderDelivery;
    }
    public function countOrderCompleteEmployee($start_date = null)
    {
        $statusIds = [6];
        $employee = Auth::id();
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }
        if ($start_date ) {
            
            $countOrderComplete = Order::whereHas('orderStatuses', function ($query) use ($employee,$statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $employee);
            })->whereBetween('created_at', [$start, $end])->count();
        } else if ($start_date) {
           
            $countOrderComplete = Order::whereHas('orderStatuses', function ($query) use ($employee,$statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $employee);
            })->whereBetween('created_at', [$start, $end])->count();
        } else {
            $countOrderComplete = Order::whereHas('orderStatuses', function ($query)use ($employee,$statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $employee);
            })->whereDate('created_at', now()->toDateString())->count();
        }
        // dd($countOrderComplete);
        return $countOrderComplete;
    }
    public function countOrderReturnsEmployee($start_date = null)
    {
        $statusIds = [8];
        $employee = Auth::id();
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }
        if ($start_date ) {
           
            $countOrderReturns = Order::whereHas('orderStatuses', function ($query) use ($employee,$statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $employee);
            })->whereBetween('created_at', [$start, $end])->count();
        } else if ($start_date ) {
          
            $countOrderReturns = Order::whereHas('orderStatuses', function ($query) use ($employee,$statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $employee);
            })->whereBetween('created_at', [$start, $end])->count();
        } else {
            $countOrderReturns = Order::whereHas('orderStatuses', function ($query) use ($employee,$statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $employee);
            })->whereDate('created_at', now()->toDateString())->count();
        }
        // dd($countOrderReturns);
        return $countOrderReturns;
    }
    public function countOrderFailedEmployee($start_date = null)
    {
        $statusIds = [5];
        $employee = Auth::id();
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }
        if ($start_date ) {
          
            $countOrderFailed = Order::whereHas('orderStatuses', function ($query) use ($employee,$statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $employee);
            })->whereBetween('created_at', [$start, $end])->count();
        } else if ($start_date ) {
           
            $countOrderFailed = Order::whereHas('orderStatuses', function ($query) use ($employee,$statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $employee);
            })->whereBetween('created_at', [$start, $end])->count();
        } else {
            $countOrderFailed = Order::whereHas('orderStatuses', function ($query) use ($employee,$statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $employee);
            })->whereDate('created_at', now()->toDateString())->count();
        }
        // dd($countOrderFailed);
        return $countOrderFailed;
    }
    public function countOrderProcessingEmployee($start_date = null)
    {
        $statusIds = [2];
        $employee = Auth::id();
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }
        if ($start_date ) {
         
            $countOrderProcessing = Order::whereHas('orderStatuses', function ($query) use ($employee,$statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $employee);
            })->whereBetween('created_at', [$start, $end])->count();
        } else if ($start_date ) {
            
            $countOrderProcessing = Order::whereHas('orderStatuses', function ($query) use ($employee,$statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $employee);
            })->whereBetween('created_at', [$start, $end])->count();
        } else {
            $countOrderProcessing = Order::whereHas('orderStatuses', function ($query) use ($employee,$statusIds) {
                $query->whereIn('order_status_id', $statusIds)->where('modified_by', $employee);
            })->whereDate('created_at', now()->toDateString())->count();
        }
        // dd($countOrderProcessing);
        return $countOrderProcessing;
    }
    public function countUserEmployee()
    {

        $countUser = DB::table('users')->count();
        return $countUser;
    }
    public function newCountUserEmployee($start_date = null)
    {
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }
        if ($start_date) {
         
            $newCountUser = DB::table('users')->whereBetween('created_at', [$start, $end])->count();
        } else {
            $newCountUser = DB::table('users')->whereDate('created_at', now()->toDateString())->count();
        }
        // dd($newCountUser);
        return $newCountUser;
    }
    public function countOrderEmployee($start_date = null, $IdEmployee = '')
    {
        $employee = Auth::id();
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }
        if ($start_date) {
       
            $countOrder = Order::whereHas('orderStatuses', function ($query) use ($employee) {
                $query->where('modified_by', $employee);
            })->whereBetween('created_at', [$start, $end])->count();
        } else {
            $countOrder = Order::whereHas('orderStatuses', function ($query) use ($employee) {
                $query->where('modified_by', $employee);
            })->whereDate('created_at', now()->toDateString())->count();
        }

        return $countOrder;
    }
    public function topProductEmployee()
    {
        $topProduct = DB::table('order_items as ot')
            ->join('products as p', 'p.id', '=', 'ot.product_id')
            ->join('orders as o', 'ot.order_id', '=', 'o.id')
            ->join('order_order_status as oos', 'o.id', '=', 'oos.order_id')
            ->join('order_statuses as os', 'oos.order_status_id', '=', 'os.id')
            ->where('os.id', '=', 6) // Chỉ lấy các đơn hàng có trạng thái "Hoàn thành"
            ->select(
                'ot.product_id',
                'p.name',
                'p.thumbnail',
                DB::raw('SUM(COALESCE(ot.quantity, 0) + COALESCE(ot.quantity_variant, 0)) as total_sold')
            )
            ->groupBy('ot.product_id', 'p.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return $topProduct;
    }

    public function getRevenueAndOrdersByHourEmployee($start_date = null)
    {
        $employee = Auth::id();
        $diffInDays = 0;
        $diffInMonths = 0;
        $interval = '1 day'; // Mặc định khoảng cách là 1 ngày
        $sevenDaysAgo = now()->subDays(7)->startOfDay();
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }


        // Debug các giá trị start và end
        // dd($start, $end);

        // 🧠 Xác định khoảng cách thời gian
        $diffInDays = $start->diffInDays($end);
        $diffInMonths = $start->diffInMonths($end);
        if ($start_date) {

            if ($diffInDays == 0) {
                $groupBy = 'FLOOR(HOUR(created_at) / 2) * 2';
                $selectFormat = 'FLOOR(HOUR(created_at) / 2) * 2 as time_label';
                $interval = '2 hours'; // Mỗi 3 giờ một điểm
            } elseif ($diffInDays < 30) {
                $groupBy = 'DATE(created_at)';
                $selectFormat = 'DATE(created_at) as time_label';
                $interval = '1 day';
            } elseif ($diffInMonths < 12) {
                $groupBy = 'DATE_FORMAT(created_at, "%Y-%m")';
                $selectFormat = 'DATE_FORMAT(created_at, "%Y-%m") as time_label';
                $interval = '1 month';
            } else {
                $groupBy = 'YEAR(created_at)';
                $selectFormat = 'YEAR(created_at) as time_label';
                $interval = '1 year';
            }

            $data = Order::with('orderStatuses')
                ->whereHas('orderStatuses', function ($query) use ($employee,$sevenDaysAgo) {
                    $query->where('order_status_id', 6)->where('updated_at', '<=', $sevenDaysAgo)->where('modified_by', $employee);
                })
                ->whereBetween('created_at', [$start, $end])
                ->selectRaw("$selectFormat, SUM(total_amount) as revenue, COUNT(id) as orders")
                ->groupBy(DB::raw($groupBy)) // ✅ Chỉ nhóm theo `groupBy`, không thêm `created_at`
                ->orderBy(DB::raw($groupBy))
                ->get()
                ->keyBy('time_label');
        } else {
            // Nếu không có ngày chọn → lấy dữ liệu hôm nay theo giờ (3 tiếng 1 lần)
            $start = now()->startOfDay();
            $end = now()->endOfDay();
            $interval = '2 hours';

            $data = Order::with('orderStatuses')
                ->whereHas('orderStatuses', function ($query) use ($employee,$sevenDaysAgo) {
                    $query->where('order_status_id', 6)->where('updated_at', '<=', $sevenDaysAgo)->where('modified_by', $employee);
                })
                ->whereDate('created_at', now()->toDateString())
                ->selectRaw('FLOOR(HOUR(created_at) / 2) * 2 as time_label, SUM(total_amount) as revenue, COUNT(id) as orders')
                ->groupBy('time_label')
                ->orderBy('time_label')
                ->get()
                ->keyBy('time_label');
        }

        // Tạo danh sách `labels` theo khoảng thời gian phù hợp
        $period = new CarbonPeriod($start, $interval, $end);
        $labels = [];
        foreach ($period as $date) {
            if ($diffInDays == 0) {
                $hour = $date->format('G'); // Lấy giờ (0, 3, 6,...)
                if ($hour % 2 == 0) { // Chỉ lấy giờ chia hết cho 3
                    $labels[] = $date->format('G:00'); // Format thành "0:00", "3:00",...
                }
            } elseif ($diffInDays < 30) {
                $labels[] = $date->format('Y-m-d'); // Hiển thị ngày
            } elseif ($diffInMonths < 12) {
                $labels[] = $date->format('Y-m'); // Hiển thị tháng
            } else {
                $labels[] = $date->format('Y'); // Hiển thị năm
            }
        }

        // Gán doanh thu và số đơn hàng với dữ liệu mặc định = 0 nếu không có dữ liệu
        $revenues = [];
        $orders = [];
        foreach ($labels as $label) {
            $key = ($diffInDays == 0) ? (int) explode(':', $label)[0] : $label;
            $revenues[] = $data[$key]->revenue ?? 0;
            $orders[] = $data[$key]->orders ?? 0;
        }

        return [
            'labels' => $labels,
            'revenues' => $revenues,
            'orders' => $orders
        ];
    }

    public function getOrderStatusByHourEmployee($start_date = null)
    {
        $employee = Auth::id();
        $orderStatuses = OrderStatus::pluck('name', 'id')->toArray();

        $diffInDays = 0;
        $diffInMonths = 0;
        $interval = '1 day';
        switch ($start_date) {
            case 0: // Hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
            case 1: // 7 ngày qua
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 2: // 30 ngày qua
                $start = now()->subDays(29)->startOfDay();
                $end = now()->endOfDay();

                break;
            case 3: // 1 năm qua
                $start = now()->subYear()->startOfDay();
                $end = now()->endOfDay();

                break;
            default:
                // Nếu không có giá trị phù hợp, mặc định là hôm nay
                $start = now()->startOfDay();
                $end = now()->endOfDay();

                break;
        }


        // Debug các giá trị start và end
        // dd($start, $end);

        // 🧠 Xác định khoảng cách thời gian
        $diffInDays = $start->diffInDays($end);
        $diffInMonths = $start->diffInMonths($end);
        if ($start_date) {
        
            $diffInDays = $start->diffInDays($end);
            $diffInMonths = $start->diffInMonths($end);

            if ($diffInDays == 0) {
                $groupBy = 'FLOOR(HOUR(orders.created_at) / 2) * 2';
                $selectFormat = 'FLOOR(HOUR(orders.created_at) / 2) * 2 as time_label';
                $interval = '2 hours';
            } elseif ($diffInDays < 30) {
                $groupBy = 'DATE(orders.created_at)';
                $selectFormat = 'DATE(orders.created_at) as time_label';
                $interval = '1 day';
            } elseif ($diffInMonths < 12) {
                $groupBy = 'DATE_FORMAT(orders.created_at, "%Y-%m")';
                $selectFormat = 'DATE_FORMAT(orders.created_at, "%Y-%m") as time_label';
                $interval = '1 month';
            } else {
                $groupBy = 'YEAR(orders.created_at)';
                $selectFormat = 'YEAR(orders.created_at) as time_label';
                $interval = '1 year';
            }

            $data = Order::join('order_order_status', 'orders.id', '=', 'order_order_status.order_id')
                ->join('order_statuses', 'order_order_status.order_status_id', '=', 'order_statuses.id')
                ->whereHas('orderStatuses', function ($query) use ($employee) {
                    $query->where('modified_by', $employee);
                })
                ->whereBetween('orders.created_at', [$start, $end])
                ->selectRaw("$selectFormat, order_statuses.id as order_status_id, COUNT(orders.id) as total_orders")
                ->groupBy(DB::raw($groupBy), 'order_status_id')
                ->orderBy(DB::raw($groupBy))
                ->get();
        } else {
            $start = now()->startOfDay();
            $end = now()->endOfDay();
            $interval = '2 hours';

            $data = Order::join('order_order_status', 'orders.id', '=', 'order_order_status.order_id')
                ->join('order_statuses', 'order_order_status.order_status_id', '=', 'order_statuses.id')
                ->whereHas('orderStatuses', function ($query) use ($employee) {
                    $query->where('modified_by', $employee);
                })
                ->whereDate('orders.created_at', now()->toDateString())
                ->selectRaw('FLOOR(HOUR(orders.created_at) / 2) * 2 as time_label, order_statuses.id as order_status_id, COUNT(orders.id) as total_orders')
                ->groupBy('time_label', 'order_status_id')
                ->orderBy('time_label')
                ->get();
        }

        $period = new CarbonPeriod($start, $interval, $end);
        $labels = [];
        $ordersByStatus = [];

        foreach ($period as $date) {
            if ($diffInDays == 0) {
                $hour = $date->format('G');
                if ($hour % 2 == 0) {
                    $labels[] = $date->format('G:00');
                }
            } elseif ($diffInDays < 30) {
                $labels[] = $date->format('Y-m-d');
            } elseif ($diffInMonths < 12) {
                $labels[] = $date->format('Y-m');
            } else {
                $labels[] = $date->format('Y');
            }
        }

        foreach ($labels as $label) {
            $key = ($diffInDays == 0) ? (int) explode(':', $label)[0] : $label;
            foreach ($orderStatuses as $statusId => $statusName) {
                $ordersByStatus[$statusName][$key] = 0;
            }
        }

        foreach ($data as $order) {
            $key = ($diffInDays == 0) ? (int) $order->time_label : $order->time_label;
            if (isset($orderStatuses[$order->order_status_id])) {
                $ordersByStatus[$orderStatuses[$order->order_status_id]][$key] = $order->total_orders;
            }
        }

        return [
            'labels' => $labels,
            'orders' => $ordersByStatus
        ];
    }
}
