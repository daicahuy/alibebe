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
    public function employee(){
        return $this->dashboardRepository->employee();
    }
    public function revenue($start_date = null, $IdEmployee = '')
    {
        return $this->dashboardRepository->revenue($start_date, $IdEmployee);
    }
    
    public function countUser()
    {
        return $this->dashboardRepository->countUser();
    }
    
    public function newCountUser($start_date = null)
    {
        return $this->dashboardRepository->newCountUser($start_date);
    }
    
    public function countOrder($start_date = null, $IdEmployee = '')
    {
        return $this->dashboardRepository->countOrder($start_date, $IdEmployee);
    }
    
    public function getRevenueAndOrdersByHour($start_date = null, $IdEmployee = '')
    {
        // dd($start_date);
        return $this->dashboardRepository->getRevenueAndOrdersByHour($start_date, $IdEmployee);
    }
    
    public function getOrderStatusByHour($start_date = null, $IdEmployee = '')
    {
        return $this->dashboardRepository->getOrderStatusByHour($start_date, $IdEmployee);
    }
    
    public function topProduct($start_date = null)
    {
        return $this->dashboardRepository->topProduct($start_date);
    }
    
    public function topUser()
    {
        return $this->dashboardRepository->topUser();
    }
    
    public function getUserRank($loyaltyPoints = null)
    {
        return $this->dashboardRepository->getUserRank($loyaltyPoints);
    }
    
    public function countOrderPending()
    {
        return $this->dashboardRepository->countOrderPending();
    }
    
    public function countOrderDelivery($start_date = null, $IdEmployee = '')
    {
        return $this->dashboardRepository->countOrderDelivery($start_date, $IdEmployee);
    }
    public function countOrderComplete($start_date = null, $IdEmployee = '')
    {
        return $this->dashboardRepository->countOrderComplete($start_date, $IdEmployee);
    }
    
    public function countOrderFailed($start_date = null, $IdEmployee = '')
    {
        return $this->dashboardRepository->countOrderFailed($start_date, $IdEmployee);
    }
    
    public function countOrderReturns($start_date = null, $IdEmployee = '')
    {
        return $this->dashboardRepository->countOrderReturns($start_date, $IdEmployee);
    }
    public function countOrderProcessing($start_date = null, $IdEmployee = '')
    {
        return $this->dashboardRepository->countOrderProcessing($start_date, $IdEmployee);
    }
    
    





    













    public function revenueEmployee($start_date = null)
    {
        return $this->dashboardRepository->revenueEmployee($start_date);
    }
    public function countOrderPendingEmployee()
    {
        return $this->dashboardRepository->countOrderPendingEmployee();
    }
    public function countOrderDeliveryEmployee($start_date = null)
    {
        return $this->dashboardRepository->countOrderDeliveryEmployee($start_date);
    }
    public function countOrderCompleteEmployee($start_date = null)
    {
        return $this->dashboardRepository->countOrderCompleteEmployee($start_date);
    }
    
    public function countOrderFailedEmployee($start_date = null)
    {
        return $this->dashboardRepository->countOrderFailedEmployee($start_date);
    }
    
    public function countOrderReturnsEmployee($start_date = null)
    {
        return $this->dashboardRepository->countOrderReturnsEmployee($start_date);
    }
    public function countOrderProcessingEmployee($start_date = null)
    {
        return $this->dashboardRepository->countOrderProcessingEmployee($start_date);
    }
    public function countUserEmployee()
    {
        return $this->dashboardRepository->countUserEmployee();
    }
    public function newCountUserEmployee($start_date = null)
    {
        return $this->dashboardRepository->newCountUserEmployee($start_date);
    }
    public function countOrderEmployee($start_date = null)
    {
        return $this->dashboardRepository->countOrderEmployee($start_date);
    }

    public function getRevenueAndOrdersByHourEmployee($start_date = null)
    {
        return $this->dashboardRepository->getRevenueAndOrdersByHourEmployee($start_date);
    }
    public function getOrderStatusByHourEmployee($start_date = null)
    {
        return $this->dashboardRepository->getOrderStatusByHourEmployee($start_date);
    }
    public function topProductEmployee($start_date = null)
    {
        return $this->dashboardRepository->topProductEmployee($start_date);
    }

}
