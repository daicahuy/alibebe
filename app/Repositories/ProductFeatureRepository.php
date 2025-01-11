<?php

namespace App\Repositories;

use App\Models\ProductFeature;

class ProductFeatureRepository extends BaseRepository {
    
    public function getModel()
    {
        return ProductFeature::class;
    }
    
}