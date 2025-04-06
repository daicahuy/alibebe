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
    
    public function topProduct()
    {
        return $this->dashboardRepository->topProduct();
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
    





    













    public function revenueEmployee($start_date = null, $end_date = null)
    {
        return $this->dashboardRepository->revenueEmployee($start_date, $end_date);
    }
    public function countOrderPendingEmployee()
    {
        return $this->dashboardRepository->countOrderPendingEmployee();
    }
    public function countOrderDeliveryEmployee()
    {
        return $this->dashboardRepository->countOrderDeliveryEmployee();
    }
    public function countUserEmployee()
    {
        return $this->dashboardRepository->countUserEmployee();
    }
    public function newCountUserEmployee($start_date = null, $end_date = null)
    {
        return $this->dashboardRepository->newCountUserEmployee($start_date, $end_date);
    }
    public function countOrderEmployee($start_date = null, $end_date = null)
    {
        return $this->dashboardRepository->countOrderEmployee($start_date, $end_date);
    }

    public function getRevenueAndOrdersByHourEmployee($start_date = null,$end_date = null)
    {
        return $this->dashboardRepository->getRevenueAndOrdersByHourEmployee($start_date,$end_date);
    }
    public function getOrderStatusByHourEmployee($start_date = null,$end_date = null)
    {
        return $this->dashboardRepository->getOrderStatusByHourEmployee($start_date,$end_date);
    }
    public function topProductEmployee()
    {
        return $this->dashboardRepository->topProduct();
    }

}
