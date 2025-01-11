<?php

namespace App\Repositories;

use App\Models\ProductStock;

class ProductStockRepository extends BaseRepository {
    
    public function getModel()
    {
        return ProductStock::class;
    }
    
}