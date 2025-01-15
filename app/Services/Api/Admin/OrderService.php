<?php

namespace App\Services\Api\Admin;

use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;

class OrderService
{
    protected $orderRepository;
    protected $orderItemRepository;

    public function __construct(OrderRepository $orderRepository, OrderItemRepository $orderItemRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
    }

    public function getOrders(array $filters, int $page, int $limit): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->orderRepository->filterOrders($filters, $page, $limit);
    }

    public function countOrdersByStatus(array $filters): \Illuminate\Database\Eloquent\Collection
    {
        return $this->orderRepository->countOrdersByStatus($filters);
    }

    public function getOrderDetail(int $idOrder)
    {
        return $this->orderItemRepository->getOrderDetail($idOrder);
    }


}
