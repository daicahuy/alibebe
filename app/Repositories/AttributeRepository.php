<?php

namespace App\Repositories;

use App\Models\Attribute;

class AttributeRepository extends BaseRepository {
    
    public function getModel()
    {
        return Attribute::class;
    }
    
}