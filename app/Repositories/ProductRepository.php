<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository
{

    public function getModel()
    {
        return Product::class;
    }

    public function getTrendingProducts()
    {
        return $this->model->trending()->latest()->get();
    }

    public function getBestSellerProductsToday()
    {
        $today = Carbon::today();
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('reviews', function ($join) {
                $join->on('reviews.product_id', '=', 'products.id')
                    ->where('reviews.is_active', 1);
            })
            ->leftJoin(DB::raw('(SELECT product_id, SUM(stock) as total_stock FROM product_stocks GROUP BY product_id) as ps'), function ($join) {
                $join->on('ps.product_id', '=', 'products.id');
            })
            ->whereDate('orders.created_at', $today)
            ->where('products.is_active', 1)
            ->select(
                'products.id',
                DB::raw('GROUP_CONCAT(DISTINCT products.name ORDER BY order_items.product_variant_id DESC SEPARATOR " | ") as product_names'),
                'products.slug',
                'products.price',
                'products.sale_price',
                'products.thumbnail',
                'products.is_active',
                DB::raw('SUM(order_items.quantity + COALESCE(order_items.quantity_variant, 0)) as total_sold'),
                DB::raw('ROUND(COALESCE(AVG(reviews.rating), 0), 1) as average_rating'),
                DB::raw('COUNT(DISTINCT reviews.id) as total_reviews'),
                DB::raw('COALESCE(ps.total_stock, 0) as stock_quantity')
            )
            ->groupBy(
                'products.id',
                'products.slug',
                'products.price',
                'products.sale_price',
                'products.thumbnail',
                'products.is_active',
                'ps.total_stock'
            )
            ->orderByDesc('total_sold')
            ->get();
    }

    public function getBestSellingProducts()
    {
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('product_variants', 'order_items.product_variant_id', '=', 'product_variants.id')
            ->select(
                DB::raw('products.name as product_name'),
                DB::raw('COALESCE(
                CASE 
                    WHEN product_variants.thumbnail LIKE "http%" THEN product_variants.thumbnail
                    ELSE CONCAT("/storage/", product_variants.thumbnail) 
                END,
                CASE 
                    WHEN products.thumbnail LIKE "http%" THEN products.thumbnail
                    ELSE CONCAT("/storage/", products.thumbnail) 
                END
            ) as thumbnail'),
                DB::raw('COALESCE(product_variants.price, products.price) as price'),
                DB::raw('COALESCE(product_variants.id, products.id) as product_id'),
                DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->groupBy(
                'products.id',
                'products.name',
                'product_variants.thumbnail',
                'products.thumbnail',
                'product_variants.price',
                'products.price',
                'product_variants.id'
            )
            ->orderByDesc('total_sold')
            ->get();
    }

    public function getPopularProducts()
    {
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('reviews', 'reviews.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name as product_names',
                'products.thumbnail',
                'products.price',
                'products.sale_price',
                DB::raw('COALESCE(AVG(reviews.rating), 0) as average_rating'),
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('products.stock_quantity')
            )
            ->groupBy('products.id', 'products.name', 'products.thumbnail', 'products.price', 'products.sale_price', 'products.stock_quantity')
            ->orderByDesc('total_sold')
            ->limit(8)
            ->get();
    }

    public function getUserRecommendations($userId)
    {
        // Lấy danh sách sản phẩm người dùng đã mua
        $purchasedProducts = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.user_id', $userId)
            ->pluck('order_items.product_id')
            ->toArray();

        // Nếu chưa mua sản phẩm nào => gợi ý sản phẩm phổ biến
        if (empty($purchasedProducts)) {
            return $this->getPopularProducts();
        }

        // Truy vấn sản phẩm gợi ý dựa trên lịch sử mua hàng
        $suggestedProducts = DB::table('order_items as oi1')
            ->join('order_items as oi2', function ($join) use ($purchasedProducts) {
                $join->on('oi1.order_id', '=', 'oi2.order_id')
                    ->whereIn('oi1.product_id', $purchasedProducts)
                    ->whereColumn('oi1.product_id', '!=', 'oi2.product_id');
            })
            ->join('products', 'products.id', '=', 'oi2.product_id')
            ->leftJoin('reviews', 'reviews.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name as product_names',
                'products.thumbnail',
                'products.price',
                'products.sale_price',
                DB::raw('COALESCE(AVG(reviews.rating), 0) as average_rating'),
                DB::raw('COUNT(oi2.product_id) as frequency'),
                'products.stock_quantity'
            )
            ->groupBy('products.id', 'products.name', 'products.thumbnail', 'products.price', 'products.sale_price', 'products.stock_quantity')
            ->orderByDesc('frequency')
            ->limit(8)
            ->get();

        // Nếu không tìm thấy sản phẩm => gợi ý sản phẩm phổ biến
        return $suggestedProducts->isNotEmpty() ? $suggestedProducts : $this->getPopularProducts();
    }

    public function detailModal($id)
    {
        return $this->model->with(['categories', 'brand', 'productVariants.attributeValues.attribute'])->find($id);
    }

}