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
    public function getAllProductCate($category = null, $perpage = 5, $sortBy = 'default', $filters = [])
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
        // filters
        if (!empty($filters)) {
            \Log::info('Applying filters in ProductRepository: ' . json_encode($filters)); // Log bộ lọc nhận được
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
            case 'sellWell':
                $query->orderByDesc(function ($query) {
                    $query->selectRaw('COALESCE(SUM(order_items.quantity),0)')
                        ->from('order_items')
                        ->join('orders', 'order_items.order_id', '=', 'orders.id')
                        ->join('order_order_status', 'orders.id', '=', 'order_order_status.order_id')
                        ->join('order_statuses', 'order_order_status.order_status_id', '=', 'order_statuses.id')
                        ->whereColumn('order_items.product_id', 'products.id')
                        ->where('order_statuses.name', '=', 'Hoàn thành');
                });
                break;
            case 'manyViews':
                $query->orderBy('views', 'DESC');
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

        $query->select('id', 'name', 'thumbnail', 'price', 'sale_price', 'short_description', 'views')->with('categories:id,name')->with('reviews');
        $products = $query->paginate($perpage)->appends(['sort_by' => $sortBy]); // Lưu  $products

        return $products;
    }



    public function detailModal($id)
    {
        return $this->model->with(['categories', 'brand', 'productVariants.attributeValues.attribute'])->find($id);
    }
}