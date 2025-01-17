<?php

namespace App\Repositories;

use App\Models\Attribute;
use App\Models\Product;

class AttributeRepository extends BaseRepository
{

    public function getModel()
    {
        return Attribute::class;
    }
    public function getAllAttributeRepository($perpage = 15, $filter = null)
    {
        if ($filter !== null) {
            $attributes = Attribute::with('attributeValues')
                ->where('is_variant', $filter)
                ->orderBy('id', 'desc')
                ->paginate($perpage);
        } else {
            $attributes = Attribute::with('attributeValues')
                ->orderBy('id', 'desc')
                ->paginate($perpage);
        }
        return $attributes;
    }

    // public function AttributeHasProduct()
    // {
    //    $attributeHasProduct = Product::con
    // }
}
