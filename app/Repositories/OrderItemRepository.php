<?php

namespace App\Repositories;
use App\Enums\OrderStatusType;
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
            'order' => function ($query) use ($idOrder) {
                $query->with('payment')->with("orderStatuses")->with([
                    "coupon" => function ($query1) {
                        $query1->with('restriction');
                    }
                ]);
            }
        ])->where("order_id", $idOrder)->with("product");

        return $query->get();

    }

    public function isProductInOrderItems($productId)
    {
        return $this->model->where('product_id', $productId)->exists();
    }



}