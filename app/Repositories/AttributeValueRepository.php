<?php

namespace App\Repositories;

use App\Models\AttributeValue;

class AttributeValueRepository extends BaseRepository {
    
    public function getModel()
    {
        return AttributeValue::class;
    }
    
}