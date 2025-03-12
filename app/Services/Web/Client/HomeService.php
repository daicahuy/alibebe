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

        $avgRating = $product->reviews->avg('rating');

        // 🟢 Lấy tồn kho của sản phẩm thường
        $stockQuantity = optional($product->productStock)->stock ?? 0;

        // 🟢 Lấy số lượng đã bán của sản phẩm thường (không phải biến thể)
        $productSoldCount = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('order_order_status', 'orders.id', '=', 'order_order_status.order_id')
            ->join('order_statuses', 'order_order_status.order_status_id', '=', 'order_statuses.id')
            ->where('order_items.product_id', $product->id) // 🟢 Lọc theo product_id
            ->whereNull('order_items.product_variant_id') // 🟢 Chỉ lấy sản phẩm thường (không có biến thể)
            ->where('order_statuses.name', 'Hoàn thành')
            ->sum('order_items.quantity');

        // 🟢 Xử lý sold_count cho từng biến thể trong Service
        $productVariants = $product->productVariants->map(function ($variant) {
            // Tính số lượng đã bán của biến thể
            $soldCount = DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('order_order_status', 'orders.id', '=', 'order_order_status.order_id')
                ->join('order_statuses', 'order_order_status.order_status_id', '=', 'order_statuses.id')
                ->where('order_items.product_variant_id', $variant->id)  // Lọc theo product_variant_id
                ->where('order_statuses.name', 'Hoàn thành') // Kiểm tra trạng thái 'Hoàn thành'
                ->sum('order_items.quantity');

            return [
                'id' => $variant->id,
                'price' => $variant->price,
                'sale_price' => $variant->sale_price,
                'display_price' => $variant->display_price,
                'thumbnail' => Storage::url($variant->thumbnail),
                'attribute_values' => $variant->attributeValues->map(function ($attributeValue) {
                    return [
                        'id' => $attributeValue->id,
                        'attribute_value' => $attributeValue->value,
                        'attributes_name' => $attributeValue->attribute->name,
                    ];
                }),
                'product_stock' => $variant->productStock ? [
                    'stock' => $variant->productStock->stock,
                ] : ['stock' => 0],
                'sold_count' => $soldCount,  // 🟢 Đã sửa để lấy số lượng đã bán của biến thể
            ];
        });

        return [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'display_price' => $product->display_price,
            'original_price' => $product->original_price,
            'thumbnail' => Storage::url($product->thumbnail),
            'short_description' => $product->short_description,
            'categories' => $product->categories->pluck('name')->implode(', '),
            'brand' => $product->brand ? $product->brand->name : null,
            'avgRating' => $avgRating,
            'productVariants' => $productVariants,
            'sold_count' => $productSoldCount, // 🟢 Số lượng đã bán của sản phẩm thường (không tính biến thể)
            'is_sale' => $product->is_sale,
            'stock_quantity' => $stockQuantity, // 🟢 Trả về tồn kho sản phẩm thường
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