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

        $attributeValues = $attributeShow->attributeValues()->where('is_active', 1); // Query builder từ quan hệ

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

    public function hidden($attribute, $perpage = 15, $keyword = null, $sortColumn = null, $sortDirection = 'desc')
    {
        $attributeShow = Attribute::find($attribute);

        if (!$attributeShow) {
            return [
                'attribute' => null,
                'attributeValues' => [],
            ];
        }

        $attributeValues = $attributeShow->attributeValues()->where('is_active', 0); // Query builder từ quan hệ

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

    public function deleteAll(array $ids)
    {
        // Lấy danh sách giá trị thuộc tính cần xóa
        $attribute_values = AttributeValue::whereIn('id', $ids)->get();
        $attribute_value_Ids = [];
    
        // Kiểm tra các giá trị thuộc tính bị ràng buộc
        foreach ($attribute_values as $attribute_value) {
            if ($attribute_value->products()->exists() || $attribute_value->productVariants()->exists()) {
                $attribute_value_Ids[] = $attribute_value->id;
            }
        }
    
        // Loại bỏ các giá trị trùng lặp
        $attribute_value_Ids = array_unique($attribute_value_Ids);
    
        // Nếu có giá trị thuộc tính không thể xóa, tạo thông báo lỗi
        if (!empty($attribute_value_Ids)) {
            $attribute_value_Ids_List = implode(', ', $attribute_value_Ids);
            throw new \Exception("Không thể xóa thuộc tính {$attribute_value_Ids_List} vì giá trị thuộc tính đang được sử dụng.");
        }
    
        // Thực hiện xóa dữ liệu
        return AttributeValue::whereIn('id', $ids)->forceDelete();
    }
    

}
