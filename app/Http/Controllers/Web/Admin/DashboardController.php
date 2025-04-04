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
        // Chỉ validate khi có start_date hoặc end_date trong request (người dùng nhấn lọc)
        if ($request->has('start_date') || $request->has('end_date')) {
            $validated = $request->validate([
                'start_date' => 'required|date|before_or_equal:today',
                'end_date'   => 'required|date|after_or_equal:start_date|before_or_equal:today',
            ], [
                'start_date.required' => 'Vui lòng chọn ngày bắt đầu!',
                'start_date.date' => 'Ngày bắt đầu không hợp lệ!',
                'start_date.before_or_equal' => 'Ngày bắt đầu không thể là ngày trong tương lai!',

                'end_date.required' => 'Vui lòng chọn ngày kết thúc!',
                'end_date.date' => 'Ngày kết thúc không hợp lệ!',
                'end_date.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu!',
                'end_date.before_or_equal' => 'Ngày kết thúc không thể là ngày trong tương lai!',
            ]);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $validated = $request->validate([
                'start_date' => 'required|date|before_or_equal:end_date',
                'end_date'   => 'required|date|after_or_equal:start_date',
            ]);
        }

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $IdEmployee = $request->input('is_employee');

        $revenue = $this->dashboardService->revenue($start_date, $end_date, $IdEmployee);
        $countProduct = $this->dashboardService->countProduct();
        $countUser = $this->dashboardService->countUser();
        $newCountUser = $this->dashboardService->newCountUser($start_date, $end_date);
        $countOrder = $this->dashboardService->countOrder($start_date, $end_date, $IdEmployee);
        $chartData = $this->dashboardService->getRevenueAndOrdersByHour($start_date, $end_date, $IdEmployee);
        $order_status = $this->dashboardService->getOrderStatusByHour($start_date, $end_date, $IdEmployee);
        $topProduct = $this->dashboardService->topProduct();
        $topUser = $this->dashboardService->topUser();
        $employee = $this->dashboardService->employee();
        // Kiểm tra nếu hàm trả về RedirectResponse thì return luôn
        if ($chartData instanceof \Illuminate\Http\RedirectResponse) {
            return $chartData;
        }

        // Nếu hợp lệ, tiếp tục xử lý dữ liệu
        $chartData['revenues'] = array_map('floatval', $chartData['revenues']);
        // dd($IdEmployee);
        //  dd($employee);

        return view(
            'admin.pages.index',
            compact(
                'revenue',
                'countProduct',
                'countUser',
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
    $end_date = $request->input('end_date');
    $IdEmployee = $request->input('is_employee', 0); // Nếu có filter theo nhân viên
    // dd($start_date, $end_date, $IdEmployee); 
    // Xuất dữ liệu ra file Excel
    // dump($row);
    return Excel::download(new DashboardExport($dashboardRepository,$start_date, $end_date, $IdEmployee), 'dashboard_data.xlsx');
}




    public function indexNhanVien(Request $request)
    {
        // Chỉ validate khi có start_date hoặc end_date trong request (người dùng nhấn lọc)
        if ($request->has('start_date') || $request->has('end_date')) {
            $validated = $request->validate([
                'start_date' => 'required|date|before_or_equal:today',
                'end_date'   => 'required|date|after_or_equal:start_date|before_or_equal:today',
            ], [
                'start_date.required' => 'Vui lòng chọn ngày bắt đầu!',
                'start_date.date' => 'Ngày bắt đầu không hợp lệ!',
                'start_date.before_or_equal' => 'Ngày bắt đầu không thể là ngày trong tương lai!',

                'end_date.required' => 'Vui lòng chọn ngày kết thúc!',
                'end_date.date' => 'Ngày kết thúc không hợp lệ!',
                'end_date.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu!',
                'end_date.before_or_equal' => 'Ngày kết thúc không thể là ngày trong tương lai!',
            ]);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $validated = $request->validate([
                'start_date' => 'required|date|before_or_equal:end_date',
                'end_date'   => 'required|date|after_or_equal:start_date',
            ]);
        }

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $IdEmployee = $request->input('is_employee');

        $revenue = $this->dashboardService->revenueEmployee($start_date, $end_date);
        $countOrderPending = $this->dashboardService->countOrderPendingEmployee();
        $countOrderDelivery = $this->dashboardService->countOrderDeliveryEmployee();

        $countUser = $this->dashboardService->countUserEmployee();
        $newCountUser = $this->dashboardService->newCountUserEmployee($start_date, $end_date);
        $countOrder = $this->dashboardService->countOrderEmployee($start_date, $end_date);
        $chartData = $this->dashboardService->getRevenueAndOrdersByHourEmployee($start_date, $end_date);
        $order_status = $this->dashboardService->getOrderStatusByHourEmployee($start_date, $end_date);
        $topProduct = $this->dashboardService->topProduct();
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
            'admin.pages.indexNhanVien',
            compact(
                'revenue',
                'countOrderPending','countOrderDelivery',
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
