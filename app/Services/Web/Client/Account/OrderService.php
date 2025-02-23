<?php

namespace App\Services\Web\Client\Account;

use App\Enums\OrderStatusType;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;

class OrderService
{
    protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index() {
        $orderStatuses = array_map('strtolower', OrderStatusType::asSelectArray());
        
        return [
            'orderStatuses' => $orderStatuses,
        ];
    }
}
