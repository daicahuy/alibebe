<?php

namespace App\Repositories;

use App\Models\OrderItem;

class OrderItemRepository extends BaseRepository {
    
    public function getModel()
    {
        return OrderItem::class;
    }
    
}