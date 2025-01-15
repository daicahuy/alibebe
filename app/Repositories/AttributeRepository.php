<?php

namespace App\Repositories;

use App\Models\Attribute;

class AttributeRepository extends BaseRepository {
    
    public function getModel()
    {
        return Attribute::class;
    }
    public function getAllAttributeRepository()
    {
        $attributes = Attribute::with('attributeValues')
        ->orderBy('id', 'desc')
        ->paginate(5);
        
        // Sử dụng map() khi không phân trang và transform khi phân trang
        // map() không thay đổi Collection ban đầu mà trả về một Collection mới.
        // transform() thay đổi trực tiếp Conllection.
        // $attributes->getCollection()->transform(function ($attribute) {
        //     $attribute->attributeValues = $attribute->attributeValues->toArray();
        //     return $attribute;
        // });

        return $attributes;

    }
}