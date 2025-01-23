<?php

namespace App\Repositories;

use App\Models\Brand;
use Illuminate\Support\Facades\DB;

class BrandRepository extends BaseRepository
{

    public function getModel()
    {
        return Brand::class;
    }
    public function pagination15BrandAsc(int $perPage, ?string $keyWord = null)
    {
        $query = Brand::query();

        if ($keyWord) {
            $query->where('name', 'like', '%' . $keyWord . '%'); // Tìm kiếm theo tên
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();
    }


    public function delete(int $id)
    {
        $brand = $this->findById($id);

        // Kiểm tra liên kết trong bảng attribute_values
        if ($brand->products()->exists()) {
            throw new \Exception('Không thể xóa vì thuộc tính đang có giá trị.');
        }
        return $brand->forceDelete();
    }
    public function deleteAll(array $ids)
    {
        $Brands = Brand::whereIn('id', $ids)->get();
        $BrandIdsWithProducts = [];
    
        // Kiểm tra tất cả các thương hiệu có liên kết với sản phẩm
        foreach ($Brands as $Brand) {
            if ($Brand->products()->exists()) {
                $BrandIdsWithProducts[] = $Brand->id;
            }
        }
    
        if (!empty($BrandIdsWithProducts)) {
            $BrandIdsList = implode(', ', $BrandIdsWithProducts);
            throw new \Exception("Không thể xóa vì các thương hiệu sau đang liên kết với sản phẩm: {$BrandIdsList}.");
        }
    
        // Nếu không có thương hiệu nào liên kết, tiến hành xóa
        return Brand::whereIn('id', $ids)->delete();
    }


}