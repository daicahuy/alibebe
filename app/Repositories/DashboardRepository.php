<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardRepository extends BaseRepository
{
    public function getModel()
    {
        return Order::class;
    }
    public function revenue()
    {
        $revenue = Order::with('orderStatuses')
            ->whereHas('orderStatuses', function ($query) {
                $query->where('order_status_id', 6);
            })->whereDate('created_at', now()->toDateString())
            ->sum('total_amount');
        return $revenue;
    }

    public function countProduct()
    {
        $countProduct = DB::table('products')->count();
        return $countProduct;
    }
    public function countUser()
    {
        $countUser = DB::table('users')->count();
        return $countUser;
    }
    public function countOrder()
    {
        $countOrder = DB::table('orders')->count();
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
                DB::raw('COUNT(o.id) as total_order'), // Số lượng đơn hoàn thành
                DB::raw('SUM(o.total_amount) as total_revenue') // Tổng tiền từ các đơn
            )
            ->groupBy('o.user_id', 'u.fullname')
            ->orderByDesc('total_order') // Sắp xếp theo số đơn hàng
            ->limit(5)
            ->get();

        return $topUser;
    }










    public function getRevenueAndOrdersByHour($start_date = null, $end_date = null)
    {
        $diffInDays = 0;
        $diffInMonths = 0;
        $interval = '1 day'; // Mặc định khoảng cách là 1 ngày
    
        if ($start_date && $end_date) {
            // Xác định thời gian lọc
            $start = Carbon::parse($start_date)->startOfDay();
            $end = Carbon::parse($end_date)->endOfDay();
            $diffInDays = $start->diffInDays($end);
            $diffInMonths = $start->diffInMonths($end);
    
            // Xác định cách nhóm dữ liệu
            if ($diffInDays == 0) {
                $groupBy = 'HOUR(created_at)';
                $selectFormat = 'HOUR(created_at) as time_label';
                $interval = '1 hour';
            } elseif ($diffInDays < 30) {
                $groupBy = 'DATE(created_at)';
                $selectFormat = 'DATE(created_at) as time_label';
                $interval = '1 day';
            } elseif ($diffInMonths < 12) {
                $groupBy = 'MONTH(created_at)';
                $selectFormat = 'DATE_FORMAT(created_at, "%Y-%m") as time_label';
                $interval = '1 month';
            } else {
                $groupBy = 'YEAR(created_at)';
                $selectFormat = 'YEAR(created_at) as time_label';
                $interval = '1 year';
            }
    
            $data = Order::with('orderStatuses')
                ->whereHas('orderStatuses', function ($query) {
                    $query->where('order_status_id', 6);
                })
                ->whereBetween('created_at', [$start, $end])
                ->selectRaw("$selectFormat, SUM(total_amount) as revenue, COUNT(id) as orders")
                ->groupBy(DB::raw($groupBy))
                ->orderBy(DB::raw($groupBy))
                ->get()
                ->keyBy('time_label');
        } else {
            // Nếu không có ngày chọn → lấy dữ liệu hôm nay theo giờ
            $start = now()->startOfDay();
            $end = now()->endOfDay();
            $interval = '1 hour';
    
            $data = Order::with('orderStatuses')
                ->whereHas('orderStatuses', function ($query) {
                    $query->where('order_status_id', 6);
                })
                ->whereDate('created_at', now()->toDateString())
                ->selectRaw('HOUR(created_at) as time_label, SUM(total_amount) as revenue, COUNT(id) as orders')
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
                $labels[] = $date->format('G:00'); // Hiển thị giờ dạng "0:00", "1:00", ...
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
    
    public function getOrderStatusByHour()
    {
        // Lấy danh sách trạng thái đơn hàng từ DB
        $orderStatuses = OrderStatus::pluck('name', 'id')->toArray();

        $data = Order::join('order_order_status', 'orders.id', '=', 'order_order_status.order_id')
            ->join('order_statuses', 'order_order_status.order_status_id', '=', 'order_statuses.id')
            ->whereDate('orders.created_at', now()->toDateString())
            ->selectRaw('FLOOR(HOUR(orders.created_at) / 3) * 3 as hour, order_statuses.id as order_status_id, COUNT(orders.id) as total_orders')
            ->groupBy('hour', 'order_status_id') // Đảm bảo group theo cả hour và order_status_id
            ->orderBy('hour')
            ->get();



        // Khởi tạo dữ liệu mặc định với các trạng thái đơn hàng
        $labels = [];
        $ordersByStatus = [];

        // Khởi tạo dữ liệu rỗng theo từng mốc giờ
        for ($i = 0; $i < 24; $i += 3) {
            $labels[] = "$i:00";
            foreach ($orderStatuses as $statusId => $statusName) {
                $ordersByStatus[$statusName][] = 0; // Mặc định là 0 đơn
            }
        }

        // Cập nhật số lượng đơn hàng từ dữ liệu truy vấn
        foreach ($data as $order) {
            $hourIndex = $order->hour / 3; // Xác định vị trí trong mảng

            if (isset($orderStatuses[$order->order_status_id])) {
                // Đảm bảo mỗi trạng thái đơn hàng có đầy đủ 8 mốc giờ (0:00 - 21:00)
                if (!isset($ordersByStatus[$orderStatuses[$order->order_status_id]])) {
                    $ordersByStatus[$orderStatuses[$order->order_status_id]] = array_fill(0, 8, 0);
                }

                $ordersByStatus[$orderStatuses[$order->order_status_id]][$hourIndex] = $order->total_orders;
            }
        }

        return [
            'labels' => $labels,
            'orders' => $ordersByStatus
        ];
    }
}
