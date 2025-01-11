<?php

namespace App\Repositories;

use App\Models\ProductVariant;

class ProductVariantRepository extends BaseRepository {
    
    public function getModel()
    {
        return ProductVariant::class;
    }
    
}