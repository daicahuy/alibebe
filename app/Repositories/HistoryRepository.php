<?php

namespace App\Repositories;

use App\Models\History;

class HistoryRepository extends BaseRepository {
    
    public function getModel()
    {
        return History::class;
    }
    
}