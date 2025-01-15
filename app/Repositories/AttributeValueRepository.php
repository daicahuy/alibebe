<?php

namespace App\Repositories;

use App\Models\AttributeValue;
use App\Models\Attribute;

class AttributeValueRepository extends BaseRepository {
    
    public function getModel()
    {
        return AttributeValue::class;
    }

    public function getAllAttributeValueFindById($attribute)
    {
        $attributeShow = Attribute::with('attributeValues')
        ->where('id', $attribute)
        ->first();

        return [
            'attribute' => $attributeShow,
            'attributeValues' => $attributeShow->attributeValues,
        ];

    }
    
}