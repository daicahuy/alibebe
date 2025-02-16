<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;

class ProductRepository extends BaseRepository
{

    public function getModel()
    {
        return Product::class;
    }

    // Lấy danh sách sản phẩm theo category
    public function getAllProductCate($category = null, $perpage = 5, $sortBy)
    {
        $query = $this->model->query();

        if ($category) {
            $parentID = $category; //Id cate cha
            $childCateIds = Category::where('parent_id', $parentID)  //lấy id con 
                ->pluck('id')
                ->toArray();
            // Gộp id cha và con vào 1 
            $categoryIds = array_merge([$parentID], $childCateIds);
            // dd($categoryIds);

            // lọc

            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds)->where('is_active', 1);
            });
        } else {
            $query->whereHas('categories', function ($q) {
                $q->where('is_active', 1);
            });
        }

        // sort by
        switch ($sortBy) {
            case 'low':
                $query->orderBy('price', 'ASC');
                break;
            case 'high':
                $query->orderBy('price', 'DESC');
                break;
            case 'aToz':
                $query->orderBy('name', 'ASC');
                break;
            case 'zToa':
                $query->orderBy('name', 'DESC');
                break;
            case 'rating':
                $query->orderByDesc(function ($query) {
                    $query->selectRaw('COALESCE(AVG(reviews.rating),0)')
                        ->from('reviews')
                        ->whereColumn('reviews.product_id', 'products.id');
                });
                // dd("Đang sắp xếp rating", $query->toSql(), $query->getBindings());
                break;
            default:
                $query->orderBy('updated_at', 'DESC');
                

        }

        $query->select('id', 'name', 'thumbnail', 'price', 'sale_price', 'short_description')->with('categories:id,name')->with('reviews');
        $products = $query->paginate($perpage)->appends(['sort_by' => $sortBy]); // Lưu  $products

        return $products;
    }



    public function detailModal($id)
    {
        return $this->model->with(['categories', 'brand', 'productVariants.attributeValues.attribute'])->find($id);
    }
}