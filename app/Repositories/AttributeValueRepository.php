<?php

namespace App\Repositories;

use App\Models\AttributeValue;
use App\Models\Attribute;

class AttributeValueRepository extends BaseRepository
{

    public function getModel()
    {
        return AttributeValue::class;
    }

    public function getAllAttributeValueFindById($attribute, $perpage = 15, $keyword = null, $sortColumn = null, $sortDirection = 'desc')
    {
        $attributeShow = Attribute::find($attribute);

        if (!$attributeShow) {
            return [
                'attribute' => null,
                'attributeValues' => [],
            ];
        }

        $attributeValues = $attributeShow->attributeValues(); // Query builder từ quan hệ

        if ($keyword) {
            $attributeValues->where('value', 'LIKE', "%$keyword%");
        }
        // Áp dụng sắp xếp nếu có
        if ($sortColumn) {
            $attributeValues->orderBy($sortColumn, $sortDirection);
        } else {
            $attributeValues->orderBy('id', 'desc'); // Mặc định sắp xếp theo id giảm dần
        }
        return [
            'attribute' => $attributeShow,
            'attributeValues' => $attributeValues->paginate($perpage),
        ];
    }


    public function delete(int $id)
    {
        $attributeValue = $this->findById($id);

        // Kiểm tra liên kết trong bảng attribute_values
        if ($attributeValue->products()->exists() || $attributeValue->productVariants()->exists()) {
            throw new \Exception('Không thể xóa vì giá trị thuộc tính đang được sử dụng.');
        }
        return $attributeValue->forceDelete();
    }

    // public function deleteAll(array $ids)
    // {
    //     $attributes = Attribute::whereIn('id', $ids)->get();
    //     $attributeIds = [];

    //     // Kiểm tra các thuộc tính bị ràng buộc
    //     foreach ($attributes as $attribute) {
    //         // Kiểm tra liên kết trong bảng attribute_values
    //         if ($attribute->attributeValues()->exists()) {
    //             $attributeIds[] = $attribute->id;
    //         }
    //     }
    //     // Loại bỏ các giá trị trùng lặp
    //     $attributeIds = array_unique($attributeIds);

    //     // Nếu có thuộc tính không thể xóa, tạo thông báo lỗi
    //     if (!empty($attributeIds)) {
    //         $attributeIdsList = implode(', ', $attributeIds);
    //         throw new \Exception("Không thể xóa thuộc tính {$attributeIdsList} vì giá trị thuộc tính đang được sử dụng.");
    //     }

    //     return Attribute::whereIn('id', $ids)->forceDelete();
    // }


}
