<?php

namespace App\Repositories;

use App\Models\StockMovementDetail;

class StockMovementDetailRepository extends BaseRepository {
    
    public function getModel()
    {
        return StockMovementDetail::class;
    }
    
}