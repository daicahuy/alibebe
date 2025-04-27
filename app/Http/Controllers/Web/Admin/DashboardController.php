<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\DashboardRepository;
use Illuminate\Http\Request;
use App\Charts\Analysis;
use App\Services\Web\Admin\DashboardService;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DashboardExport;

class DashboardController extends Controller
{
    protected $dashboardService;
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        $start_date = $request->input('start_date', 0);
        $IdEmployee = $request->input('is_employee');
    
        // Xử lý start_date như là một Carbon instance, không cần chuyển thành timestamp
        // if ($start_date == 1) {
        //     // 7 ngày qua
        //     $start_date = now()->subDays(7)->startOfDay();
        // } elseif ($start_date == 2) {
        //     // 30 ngày qua
        //     $start_date = now()->subDays(30)->startOfDay();
        // } elseif ($start_date == 3) {
        //     // 1 năm qua
        //     $start_date = now()->subYear()->startOfDay();
        // } else {
        //     // Hôm nay
        //     $start_date = now()->startOfDay();
        // }
        // dd($start_date);
    
        $revenue = $this->dashboardService->revenue($start_date, $IdEmployee);
        $countUser = $this->dashboardService->countUser();
        $newCountUser = $this->dashboardService->newCountUser($start_date);
        $countOrder = $this->dashboardService->countOrder($start_date, $IdEmployee);
        $chartData = $this->dashboardService->getRevenueAndOrdersByHour($start_date, $IdEmployee);
        $order_status = $this->dashboardService->getOrderStatusByHour($start_date, $IdEmployee);
        $topProduct = $this->dashboardService->topProduct($start_date);
        $topUser = $this->dashboardService->topUser();
        $employee = $this->dashboardService->employee();
        $countOrderPending = $this->dashboardService->countOrderPending();
        $countOrderDelivery = $this->dashboardService->countOrderDelivery($start_date, $IdEmployee);
        $countOrderComplete = $this->dashboardService->countOrderComplete($start_date, $IdEmployee);
        $countOrderReturns = $this->dashboardService->countOrderReturns($start_date, $IdEmployee);
        $countOrderFailed = $this->dashboardService->countOrderFailed($start_date, $IdEmployee);
        $countOrderProcessing = $this->dashboardService->countOrderProcessing($start_date, $IdEmployee);
    
        if ($chartData instanceof \Illuminate\Http\RedirectResponse) {
            return $chartData;
        }
    
        $chartData['revenues'] = array_map('floatval', $chartData['revenues']);
    
        return view(
            'admin.pages.index',
            compact(
                'revenue',
                'countUser',
                'countOrderPending',
                'countOrderDelivery',
                'countOrderReturns',
                'countOrderProcessing',
                'countOrderComplete',
                'countOrderFailed',
                'countOrder',
                'chartData',
                'order_status',
                'topProduct',
                'topUser',
                'newCountUser',
                'employee'
            )
        )->with('dashboardService', $this->dashboardService);
    }
    
   
    public function exportDashboardData(Request $request,DashboardRepository $dashboardRepository)
{
    // Lấy dữ liệu từ request
    $start_date = $request->input('start_date');
    $IdEmployee = $request->input('is_employee', 0); // Nếu có filter theo nhân viên
    // dd($start_date, $end_date, $IdEmployee); 
    // Xuất dữ liệu ra file Excel
    // dump($row);
    return Excel::download(new DashboardExport($dashboardRepository,$start_date,  $IdEmployee), 'dashboard_data.xlsx');
}















    public function indexEmployee(Request $request)
    {
      
        $start_date = $request->input('start_date');
        $IdEmployee = $request->input('is_employee');

        $revenue = $this->dashboardService->revenueEmployee($start_date);
        $countOrderPending = $this->dashboardService->countOrderPendingEmployee();
        $countOrderDelivery = $this->dashboardService->countOrderDeliveryEmployee($start_date);
        $countOrderComplete = $this->dashboardService->countOrderCompleteEmployee($start_date);
        $countOrderReturns = $this->dashboardService->countOrderReturnsEmployee($start_date);
        $countOrderFailed = $this->dashboardService->countOrderFailedEmployee($start_date);
        $countOrderProcessing = $this->dashboardService->countOrderProcessingEmployee($start_date);

        $countUser = $this->dashboardService->countUserEmployee();
        $newCountUser = $this->dashboardService->newCountUserEmployee($start_date);
        $countOrder = $this->dashboardService->countOrderEmployee($start_date);
        $chartData = $this->dashboardService->getRevenueAndOrdersByHourEmployee($start_date);
        $order_status = $this->dashboardService->getOrderStatusByHourEmployee($start_date);
        $topProduct = $this->dashboardService->topProductEmployee($start_date);
        $topUser = $this->dashboardService->topUser();
        // Kiểm tra nếu hàm trả về RedirectResponse thì return luôn
        if ($chartData instanceof \Illuminate\Http\RedirectResponse) {
            return $chartData;
        }

        // Nếu hợp lệ, tiếp tục xử lý dữ liệu
        $chartData['revenues'] = array_map('floatval', $chartData['revenues']);
        // dd($IdEmployee);
        //  dd($employee);

        return view(
            'admin.pages.index-employee',
            compact(
                'revenue',
                'countOrderPending','countOrderDelivery',
                'countOrderReturns',
                'countOrderProcessing',
                'countOrderComplete',
                'countOrderFailed',
                'countUser',
                'countOrder',
                'chartData',
                'order_status',
                'topProduct',
                'topUser',
                'newCountUser'

            )
        )->with('dashboardService', $this->dashboardService);
    }
}
