<?php

namespace App\Services\Web\Admin;

use App\Repositories\DashboardRepository;
use App\Repositories\DetailDashboardRepository;

class DetailDashboardService
{
    protected $detailDashboardRepository;
    public function __construct(DetailDashboardRepository $detailDashboardRepository)
    {
        $this->detailDashboardRepository = $detailDashboardRepository;
    }
    public function employee(){
        return $this->detailDashboardRepository->employee();
    }
    public function revenue($start_date = null, $end_date = null,$IdEmployee = '')
    {
        return $this->detailDashboardRepository->revenue($start_date, $end_date,$IdEmployee);
    }
    public function countProduct()
    {
        return $this->detailDashboardRepository->countProduct();
    }
    public function countUser()
    {
        return $this->detailDashboardRepository->countUser();
    }
    public function newCountUser($start_date = null, $end_date = null)
    {
        return $this->detailDashboardRepository->newCountUser($start_date, $end_date);
    }
    public function countOrder($start_date = null, $end_date = null,$IdEmployee = '')
    {
        return $this->detailDashboardRepository->countOrder($start_date, $end_date,$IdEmployee);
    }

    public function getRevenueAndOrdersByHour($start_date = null,$end_date = null,$IdEmployee='')
    {
        return $this->detailDashboardRepository->getRevenueAndOrdersByHour($start_date,$end_date,$IdEmployee);
    }
    public function getOrderStatusByHour($start_date = null,$end_date = null,$IdEmployee = '')
    {
        return $this->detailDashboardRepository->getOrderStatusByHour($start_date,$end_date,$IdEmployee);
    }
    public function topProduct()
    {
        return $this->detailDashboardRepository->topProduct();
    }
    public function topUser()
    {
        return $this->detailDashboardRepository->topUser();
    }

    public function getUserRank($loyaltyPoints = null)
    {
        return $this->detailDashboardRepository->getUserRank($loyaltyPoints);
    }
    public function countOrderPending()
    {
        return $this->detailDashboardRepository->countOrderPending();
    }
    
    public function countOrderDelivery($start_date = null, $end_date = null,$IdEmployee = '')
    {
        return $this->detailDashboardRepository->countOrderDelivery($start_date,$end_date, $IdEmployee);
    }
    public function countOrderComplete($start_date = null, $end_date = null, $IdEmployee = '')
    {
        return $this->detailDashboardRepository->countOrderComplete($start_date,$end_date, $IdEmployee);
    }
    
    public function countOrderFailed($start_date = null, $end_date = null, $IdEmployee = '')
    {
        return $this->detailDashboardRepository->countOrderFailed($start_date,$end_date, $IdEmployee);
    }
    
    public function countOrderReturns($start_date = null, $end_date = null, $IdEmployee = '')
    {
        return $this->detailDashboardRepository->countOrderReturns($start_date,$end_date, $IdEmployee);
    }
    public function countOrderProcessing($start_date = null, $end_date = null, $IdEmployee = '')
    {
        return $this->detailDashboardRepository->countOrderProcessing($start_date,$end_date, $IdEmployee);
    }





    













    public function revenueEmployee($start_date = null, $end_date = null)
    {
        return $this->detailDashboardRepository->revenueEmployee($start_date, $end_date);
    }
    public function countOrderPendingEmployee()
    {
        return $this->detailDashboardRepository->countOrderPendingEmployee();
    }
    public function countOrderDeliveryEmployee($start_date = null, $end_date = null)
    {
        return $this->detailDashboardRepository->countOrderDeliveryEmployee($start_date, $end_date);
    }
    public function countOrderCompleteEmployee($start_date = null, $end_date = null)
    {
        return $this->detailDashboardRepository->countOrderCompleteEmployee($start_date, $end_date);
    }
    
    public function countOrderFailedEmployee($start_date = null, $end_date = null)
    {
        return $this->detailDashboardRepository->countOrderFailedEmployee($start_date, $end_date);
    }
    
    public function countOrderReturnsEmployee($start_date = null, $end_date = null)
    {
        return $this->detailDashboardRepository->countOrderReturnsEmployee($start_date, $end_date);
    }
    public function countOrderProcessingEmployee($start_date = null, $end_date = null)
    {
        return $this->detailDashboardRepository->countOrderProcessingEmployee($start_date, $end_date);
    }
    public function countUserEmployee()
    {
        return $this->detailDashboardRepository->countUserEmployee();
    }
    public function newCountUserEmployee($start_date = null, $end_date = null)
    {
        return $this->detailDashboardRepository->newCountUserEmployee($start_date, $end_date);
    }
    public function countOrderEmployee($start_date = null, $end_date = null)
    {
        return $this->detailDashboardRepository->countOrderEmployee($start_date, $end_date);
    }

    public function getRevenueAndOrdersByHourEmployee($start_date = null,$end_date = null)
    {
        return $this->detailDashboardRepository->getRevenueAndOrdersByHourEmployee($start_date,$end_date);
    }
    public function getOrderStatusByHourEmployee($start_date = null,$end_date = null)
    {
        return $this->detailDashboardRepository->getOrderStatusByHourEmployee($start_date,$end_date);
    }
    public function topProductEmployee()
    {
        return $this->detailDashboardRepository->topProduct();
    }

}