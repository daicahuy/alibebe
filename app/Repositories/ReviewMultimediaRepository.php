<?php

namespace App\Repositories;

use App\Models\ReviewMultimedia;

class ReviewMultimediaRepository extends BaseRepository {
    
    public function getModel()
    {
        return ReviewMultimedia::class;
    }
    
}