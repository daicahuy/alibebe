<?php

namespace App\Repositories;

use App\Models\OrderStatus;

class OrderStatusRepository extends BaseRepository {
    
    public function getModel()
    {
        return OrderStatus::class;
    }

    public function getNameStatus(){
        return $this->model->get();
    }
    
}