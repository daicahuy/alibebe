<?php

namespace App\Repositories;

use App\Models\AttributeValue;
use App\Models\Attribute;
use App\Models\Category;

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
    
    // listcategory lọc giá trị thuộc tính
    public function getVariantAttributesWithCounts($category = null)
    {
        $query = $this->model->query();
    
        // 1. Lọc CHỈ LẤY GIÁ TRỊ THUỘC TÍNH BIẾN THỂ (is_variant = 1)
        $query->whereHas('attribute', function ($q) {
            $q->where('is_variant', 1); // Lọc attribute theo is_variant = 1
        });
    
        // 2. Lọc theo ID Danh Mục (nếu có)
        $categoryIds = [];
        if ($category) {
            $parentID = $category;
            $childCateIds = Category::where('parent_id', $parentID)
                ->pluck('id')
                ->toArray();
            $categoryIds = array_merge([$parentID], $childCateIds);
    
            $query->whereHas('productVariants', function ($q) use ($categoryIds) {
                $q->whereHas('product', function ($q2) use ($categoryIds) {
                    $q2->whereHas('categories', function ($q3) use ($categoryIds) {
                        $q3->whereIn('categories.id', $categoryIds); // Sản phẩm thuộc danh mục cha hoặc con
                    });
                });
            });
        }
    
        // 3. Đếm số lượng sản phẩm biến thể (ĐÃ ĐIỀU CHỈNH ĐỂ ĐẾM CHÍNH XÁC THEO DANH MỤC)
        $query->withCount(['productVariants' => function ($q) use ($categoryIds, $category) {
            if ($category) { // CHỈ ÁP DỤNG ĐIỀU KIỆN DANH MỤC KHI $category CÓ GIÁ TRỊ
                $q->whereHas('product', function ($q2) use ($categoryIds) {
                    $q2->whereHas('categories', function ($q3) use ($categoryIds) {
                        $q3->whereIn('categories.id', $categoryIds); // Đếm sản phẩm biến thể thuộc danh mục đã chọn
                    });
                });
            }
        }])->with('attribute');
    
        return $query->get();
    }

}
