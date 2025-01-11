<?php

namespace App\Repositories;

use App\Models\StockMovement;

class StockMovementRepository extends BaseRepository {
    
    public function getModel()
    {
        return StockMovement::class;
    }
    
}