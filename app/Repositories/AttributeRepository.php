<?php

namespace App\Repositories;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AttributeRepository extends BaseRepository
{

    public function getModel()
    {
        return Attribute::class;
    }
    public function getAllAttributeRepository($perpage = 15, $filter = null, $keyword = null, $sortColumn = null, $sortDirection = 'desc')
    {
        // Khởi tạo query
        $attributes = Attribute::with('attributeValues')->where('is_active', 1);
    
        // Áp dụng bộ lọc nếu có
        if ($filter !== null) {
            $attributes->where('is_variant', $filter);
        }
    
        // Áp dụng tìm kiếm nếu có từ khóa
        if ($keyword) {
            $attributes->where('name', 'LIKE', "%$keyword%");
        }
    
        // Áp dụng sắp xếp nếu có
        if ($sortColumn) {
            $attributes->orderBy($sortColumn, $sortDirection);
        } else {
            $attributes->orderBy('id', 'desc'); // Mặc định sắp xếp theo id giảm dần
        }
    
        // Phân trang
        return $attributes->paginate($perpage);
    }

    public function hidden($perpage = 15, $filter = null, $keyword = null, $sortColumn = null, $sortDirection = 'desc')
    {
        // Khởi tạo query
        $attributes = Attribute::with('attributeValues')->where('is_active', 0);
    
        // Áp dụng bộ lọc nếu có
        if ($filter !== null) {
            $attributes->where('is_variant', $filter);
        }
    
        // Áp dụng tìm kiếm nếu có từ khóa
        if ($keyword) {
            $attributes->where('name', 'LIKE', "%$keyword%");
        }
    
        // Áp dụng sắp xếp nếu có
        if ($sortColumn) {
            $attributes->orderBy($sortColumn, $sortDirection);
        } else {
            $attributes->orderBy('id', 'desc'); // Mặc định sắp xếp theo id giảm dần
        }
    
        // Phân trang
        return $attributes->paginate($perpage);
    }
    

    public function delete(int $id)
    {
        $attribute = $this->findById($id);

        // Kiểm tra liên kết trong bảng attribute_values
        if ($attribute->attributeValues()->exists()) {
            throw new \Exception('Không thể vì thuộc tính đang có giá trị.');
        }
        return $attribute->forceDelete();
    }
    
    public function deleteAll(array $ids)
    {
        $attributes = Attribute::whereIn('id', $ids)->get();
        $attributeIds = [];

        // Kiểm tra các thuộc tính bị ràng buộc
        foreach ($attributes as $attribute) {
            // Kiểm tra liên kết trong bảng attribute_values
            if ($attribute->attributeValues()->exists()) {
                $attributeIds[] = $attribute->id;
            }
        }
        // Loại bỏ các giá trị trùng lặp
        $attributeIds = array_unique($attributeIds);

        // Nếu có thuộc tính không thể xóa, tạo thông báo lỗi
        if (!empty($attributeIds)) {
            $attributeIdsList = implode(', ', $attributeIds);
            throw new \Exception("Không thể xóa thuộc tính {$attributeIdsList} vì giá trị thuộc tính đang được sử dụng.");
        }

        return Attribute::whereIn('id', $ids)->forceDelete();
    }

}
