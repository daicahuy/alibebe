<?php

namespace App\Repositories;

use App\Models\OrderItem;

class OrderItemRepository extends BaseRepository
{

    public function getModel()
    {
        return OrderItem::class;
    }

    public function getOrderDetail(int $idOrder)
    {
        $query = OrderItem::query()->with([
            'order' => function ($query) {
                $query->with('payment'); // Giả sử bạn đã define relationship 'payment' trong model Order
            }
        ])->where("order_id", $idOrder)->with("product");

        return $query->get();

    }

}