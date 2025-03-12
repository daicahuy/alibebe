<?php

namespace App\Services\Web\Client;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeService
{
    protected CategoryRepository $categoryRepo;
    protected ProductRepository $productRepository;

    // Khởi tạo
    public function __construct(CategoryRepository $categoryRepo, ProductRepository $productRepository)
    {
        $this->categoryRepo = $categoryRepo;
        $this->productRepository = $productRepository;
    }


    public function listCategory()
    {
        return $this->categoryRepo->listCategory();
    }
    public function getTrendingProduct()
    {
        $trendingProducts = $this->productRepository->getTrendingProducts();

        if ($trendingProducts->isEmpty()) {
            return DB::table('products')
            ->leftJoin('reviews', function ($join) {
                $join->on('reviews.product_id', '=', 'products.id')
                    ->where('reviews.is_active', 1); // Chỉ lấy đánh giá đã được duyệt
            })
            ->select(
                'products.id',
                'products.name',
                'products.thumbnail',
                'products.views',
                'products.price',
                DB::raw('COALESCE(NULLIF(products.sale_price, 0), products.price) as sale_price'),
                DB::raw('COALESCE(AVG(reviews.rating), 0) as average_rating'), // Lấy điểm trung bình đánh giá
                DB::raw('COUNT(reviews.id) as total_reviews'), // Đếm số lượng đánh giá đã duyệt
                'products.views as views_count'
            )
            ->groupBy(
                'products.id',
                'products.name',
                'products.thumbnail',
                'products.views',
                'products.price',
                'products.sale_price'
            )
            ->orderByDesc('products.created_at')
            ->limit(12)
            ->get();



        }

        return $trendingProducts;
    }
    public function getBestSellerProductsToday()
    {
        return $this->productRepository->getBestSellerProductsToday();
    }

    public function topCategoriesInWeek()
    {
        return $this->categoryRepo->topCategoryInWeek();
    }

    public function getBestSellingProduct()
    {
        return $this->productRepository->getBestSellingProducts();
    }
    public function getAIFakeSuggest($userId)
    {
        return $this->productRepository->getUserRecommendations($userId);
    }
    public function detailModal($id)
    {
        try {
            $product = $this->productRepository->detailModal($id);

            if (!$product) {
                throw new ModelNotFoundException('Không tìm thấy sản phẩm.');
            }
            // dd($product);
            $productVariants = $product->productVariants->map(function ($variant) { //sản phẩm biến thể
                return [
                    // 'sku' => $variant->sku,
                    'id' => $variant->id, // id biến thể
                    'price' => $variant->price,
                    'sale_price' => $variant->sale_price,
                    'thumbnail' => Storage::url($variant->thumbnail),
                    'attribute_values' => $variant->attributeValues->map(function ($attributeValue) { //bảng attribute_values (giá trị thuộc tính, xanh 4GB..)
                        return [
                            'id' => $attributeValue->id, //id giá trị thuộc tính
                            // 'attribute_id' => $attributeValue->attribute_id,//id liên kết thuộc tính
                            'attribute_value' => $attributeValue->value,            //Giá trị thuộc tính 
                            'attributes_name' => $attributeValue->attribute->name, //tên thuộc tính (table attributes)
                        ];
                    }),


                ];
            });
            // dd($productVariants);

            return [
                'id' => $product->id, //id sản phẩm
                'name' => $product->name,
                'price' => $product->price,
                'thumbnail' => Storage::url($product->thumbnail),
                'short_description' => $product->short_description,
                'categories' => $product->categories->pluck('name')->implode(', '),
                'brand' => $product->brand ? $product->brand->name : null,
                'sold_count' => $product->sold_count, // số lượng đã bán
                'stock_quantity' => $product->stock_quantity, // số lượng tồn kho
                'productVariants' => $productVariants,
            ];
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function getAllCategories()
    {
        return $this->categoryRepo->getAllCategories();
    }



}
;