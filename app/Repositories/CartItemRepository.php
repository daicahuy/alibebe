<?php

namespace App\Repositories;

use App\Models\CartItem;

class CartItemRepository extends BaseRepository {
    
    public function getModel()
    {
        return CartItem::class;
    }
    
}