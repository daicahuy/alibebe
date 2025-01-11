<?php

namespace App\Repositories;

use App\Models\ProductGallery;

class ProductGalleryRepository extends BaseRepository {
    
    public function getModel()
    {
        return ProductGallery::class;
    }
    
}