<?php

namespace App\Repositories;

use App\Models\OrderOrderStatus;

class OrderOrderStatusRepository extends BaseRepository {
    
    public function getModel()
    {
        return OrderOrderStatus::class;
    }
    
}