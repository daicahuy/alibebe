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

    public function brandHasProducts(int $brandId)
    {
        return Brand::join('products', 'products.brand_id', '=', 'brands.id')
            ->where('brands.id', $brandId)
            ->count('products.id') > 0;
    }

}