<?php

namespace App\Services\Web\Admin;

use App\Repositories\OrderItemRepository;

class OrderItemService
{
    protected OrderItemRepository $orderItemRepos;
    public function __construct(OrderItemRepository $orderItemRepos)
    {
        $this->orderItemRepos = $orderItemRepos;
    }


}
