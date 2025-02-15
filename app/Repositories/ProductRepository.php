<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository {
    
    public function getModel()
    {
        return Product::class;
    }
    
    public function getTrendingProducts()  {
        return $this->model->trending()->latest()->get();
    }
    
    public function getBestSellerProductsToday(){
        $today = Carbon::today();
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('reviews', function($join) {
                $join->on('reviews.product_id', '=', 'products.id')
                     ->where('reviews.is_active', 1);
            })
            ->leftJoin(DB::raw('(SELECT product_id, SUM(stock) as total_stock 
                     FROM product_stocks 
                     GROUP BY product_id) as ps'), 
           function($join) {
               $join->on('ps.product_id', '=', 'products.id');
           })
            ->whereDate('orders.created_at', $today)
            ->select(
                'order_items.product_id', 
                'order_items.product_variant_id',
                DB::raw('SUM(order_items.quantity + COALESCE(order_items.quantity_variant, 0)) as total_sold'),
                'products.id', 
                'products.name', 
                'products.slug', 
                'products.price', 
                'products.sale_price', 
                'products.thumbnail', 
                'products.is_active',
                DB::raw('COALESCE(AVG(reviews.rating), 0) as average_rating'),
                DB::raw('COUNT(reviews.id) as total_reviews'),
                DB::raw('COALESCE(ps.total_stock, 0) as stock_quantity'),
            )
            ->groupBy(
                'order_items.product_id', 
                'order_items.product_variant_id',
                'products.id', 
                'products.name', 
                'products.slug', 
                'products.price', 
                'products.sale_price', 
                'products.thumbnail', 
                'products.is_active',
                DB::raw('ps.total_stock')
            )
            ->orderByDesc('total_sold')
            ->get();
    }

    public function getBestSellingProducts()  {
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
        ->groupBy('products.id',
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
}