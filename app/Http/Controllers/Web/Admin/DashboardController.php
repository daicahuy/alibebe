<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Charts\Analysis;
use App\Services\Web\Admin\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }
    public function index()
    {
        $revenue = $this->dashboardService->revenue();
        $countProduct = $this->dashboardService->countProduct();
        $countUser = $this->dashboardService->countUser();
        $countOrder = $this->dashboardService->countOrder();
        $chartData = $this->dashboardService->getRevenueAndOrdersByHour();
        $order_status = $this->dashboardService->getOrderStatusByHour();
        $chartData['revenues'] = array_map('floatval', $chartData['revenues']);


        $topProduct = $this->dashboardService->topProduct();
        $topUser = $this->dashboardService->topUser();



        // dd($topUser);

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

            )
        );
    }

    public function indexNhanVien()
    {
        return view('admin.pages.indexNhanVien');
    }
}
