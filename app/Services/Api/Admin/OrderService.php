<?php

namespace App\Services\Api\Admin;

use App\Repositories\OrderHistoryStatusRepository;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderOrderStatusRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;

class OrderService
{
    protected $orderRepository;
    protected $orderItemRepository;
    protected $orderOrderStatusRepository;
    protected $orderHistoryStatusRepository;

    public function __construct(OrderRepository $orderRepository, OrderItemRepository $orderItemRepository, OrderOrderStatusRepository $orderOrderStatusRepository, OrderHistoryStatusRepository $orderHistoryStatusRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->orderOrderStatusRepository = $orderOrderStatusRepository;
        $this->orderHistoryStatusRepository = $orderHistoryStatusRepository;
    }

    public function getOrders(array $filters, int $page, int $limit): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->orderRepository->filterOrders($filters, $page, $limit);
    }

    public function getOrdersByUser(array $filters, int $page, int $limit, $user_id): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->orderRepository->filterOrdersByUser($filters, $page, $limit, $user_id);
    }

    public function getOrderDetail(int $idOrder)
    {
        return $this->orderItemRepository->getOrderDetail($idOrder);
    }

    public function changeStatusOrder($idOrder, int $idStatus)
    {
        return $this->orderOrderStatusRepository->changeStatusOrder($idOrder, $idStatus);
    }

    public function updateOrderStatusWithUserCheck($idOrder, $idStatus, $customerCheck)
    {
        return $this->orderOrderStatusRepository->changeStatusOrderWithUserCheck($idOrder, $idStatus, $customerCheck);

    }

    public function changeNoteStatusOrder($idOrder, $note)
    {
        return $this->orderOrderStatusRepository->changeNoteStatusOrder($idOrder, $note);
    }

    public function getOrdersByStatus(int $activeTab)
    {
        return $this->orderRepository->getOrdersByStatus($activeTab);
    }

    public function getOrdersByID(array $idOrders)
    {
        return $this->orderRepository->getOrdersByID($idOrders);
    }

    public function countOrdersByStatus(array $filters): \Illuminate\Database\Eloquent\Collection
    {
        return $this->orderRepository->countOrdersByStatus($filters);
    }

    public function getOrderOrderStatusByID($idOrder)
    {
        return $this->orderOrderStatusRepository->getOrderOrderStatus($idOrder);

    }

    public function getListStatusHistory($idOrder)
    {
        return $this->orderHistoryStatusRepository->getListStatusHistory($idOrder);
    }

    public function updateConfirmCustomer($note, $employee_evidence, $idOrder)
    {
        return $this->orderOrderStatusRepository->updateConfirmCustomer($note, $employee_evidence, $idOrder);

    }

}
