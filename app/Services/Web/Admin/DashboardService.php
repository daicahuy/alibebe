<?php

namespace App\Services\Web\Admin;

use App\Repositories\DashboardRepository;

class DashboardService
{
    protected $dashboardRepository;
    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }
    public function revenue()
    {
        return $this->dashboardRepository->revenue();
    }
    public function countProduct()
    {
        return $this->dashboardRepository->countProduct();
    }
    public function countUser()
    {
        return $this->dashboardRepository->countUser();
    }
    public function countOrder()
    {
        return $this->dashboardRepository->countOrder();
    }

    public function getRevenueAndOrdersByHour()
    {
        return $this->dashboardRepository->getRevenueAndOrdersByHour();
    }
    public function getOrderStatusByHour()
    {
        return $this->dashboardRepository->getOrderStatusByHour();
    }
    public function topProduct()
    {
        return $this->dashboardRepository->topProduct();
    }
    public function topUser()
    {
        return $this->dashboardRepository->topUser();
    }
}
