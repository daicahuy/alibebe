<?php

namespace App\Models;

use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Log;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'brand_id',
        'name',
        'slug',
        'views',
        'short_description',
        'description',
        'thumbnail',
        'type',
        'sku',
        'price',
        'sale_price',
        'sale_price_start_at',
        'sale_price_end_at',
        'is_sale',
        'is_featured',
        'is_trending',
        'is_active',
    ];

    protected $attributes = [
        'is_sale' => 0,
        'is_featured' => 0,
        'is_trending' => 0,
        'is_active' => 0,
    ];

    protected $casts = [
        'sale_price_start_at' => 'datetime',
        'sale_price_end_at' => 'datetime',
    ];

    public function isSingle()
    {
        return $this->type === ProductType::SINGLE;
    }

    public function isVariant()
    {
        return $this->type === ProductType::VARIANT;
    }



    /////////////////////////////////////////////////////
    // RELATIONS

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function productAccessories()
    {
        return $this->belongsToMany(Product::class, 'product_accessory', 'product_id', 'product_accessory_id');
    }

    public function productGallery()
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class);
    }

    public function productStock()
    {
        return $this->hasOne(ProductStock::class, 'product_id', 'id');
    }


    public function productMovement()
    {
        return $this->hasMany(StockMovement::class);
    }

    // 
    public function stockMovementDetails()
    {
        return $this->hasMany(StockMovementDetail::class, 'product_id');
    }
    
    public function scopeTrending($query)
    {
        return $query
            ->leftJoin('product_variants', 'product_variants.product_id', '=', 'products.id')
            ->where('products.is_active', 1)
            ->where('products.is_trending', 1)
            ->select([
                'products.name',
                'products.thumbnail',
                'products.views',
                'products.slug',

                // ✅ Tính display_price
                DB::raw('(CASE
                    WHEN products.type = 1 THEN (
                        SELECT CASE 
                            WHEN products.is_sale = 1 THEN 
                                CASE 
                                    WHEN MIN(product_variants.sale_price) > 0 THEN MIN(product_variants.sale_price) 
                                    ELSE MIN(product_variants.price) 
                                END
                            ELSE MIN(product_variants.price) 
                        END 
                        FROM product_variants 
                        WHERE product_variants.product_id = products.id 
                              AND product_variants.is_active = 1 
                              AND product_variants.price > 0
                    )
                    ELSE (
                        CASE 
                            WHEN products.is_sale = 1 AND products.sale_price > 0 THEN products.sale_price
                            ELSE products.price 
                        END
                    )
                END) as display_price'),
            ])
            ->groupBy(
                'products.id',
                'products.name',
                'products.thumbnail',
                'products.views'
            )
            ->orderByDesc('products.Views')
            ->limit(10);
    }



    public function getTotalStockQuantityAttribute()
    {
        // Kiểm tra loại sản phẩm (type)
        if ($this->type == 1) { // Nếu là sản phẩm biến thể (type = 1)
            $totalStock = 0;
            // Đảm bảo relation 'productVariants.productStock' đã được load (eager loading)
            if ($this->relationLoaded('productVariants')) {
                foreach ($this->productVariants as $variant) {
                    $variantStock = $variant->productStock ? $variant->productStock->stock : 0;
                    $totalStock += $variantStock;
                }
            } else {
                return 0; // Hoặc null
            }
            return $totalStock;
        } else { // Nếu là sản phẩm đơn (type khác 1)
            // Đảm bảo relation 'productStock' đã được load (eager loading)
            if ($this->relationLoaded('productStock') && $this->productStock) {
                return $this->productStock->stock;
            } else {
                return 0; // Hoặc null
            }
        }
    }

    // đếm sản phẩm đã bán 
    public function getSoldQuantity()
    {
        // $product_id_debug = 89; // <--- Product ID bạn muốn debug (KHAI BÁO BIẾN NGAY ĐẦU FUNCTION)

        // Chỉ log/dd() nếu là product_id cần debug
        // if ($this->id == $product_id_debug) {
        //     Log::info("[getSoldQuantity] [DEBUG PRODUCT 89] Function START. Product ID: " . $this->id . ", Type: " . ($this->isVariant() ? 'Variant Product' : 'Single Product'));
        //     Log::info("[getSoldQuantity] [DEBUG PRODUCT 89] --- START getSoldQuantity ---, Product ID: " . $this->id . ", Product Type: " . ($this->isVariant() ? 'Variant Product' : 'Single Product'));
        //     if (!$this->isVariant()) {
        //         Log::info("[getSoldQuantity] [DEBUG PRODUCT 89] Processing as Single Product.");
        //     } else {
        //         Log::info("[getSoldQuantity] [DEBUG PRODUCT 89] Processing as Variant Product.");
        //         $variants = $this->productVariants()->with('orderItems')->get();
        //         Log::info("[getSoldQuantity] [DEBUG PRODUCT 89] Product Variants Count: " . $variants->count());
        //         $totalSoldQuantity = $variants->sum(function ($variant) {
        //             Log::info("[getSoldQuantity] [DEBUG PRODUCT 89] Processing Variant ID: " . $variant->id);
        //             $variantSoldQuantity = $variant->orderItems()
        //                 ->whereHas('order', function ($query) {
        //                     $query->whereHas('orderStatuses', function ($subQuery) {
        //                         $subQuery->where('name', 'Hoàn thành');
        //                     });
        //                 })
        //                 ->sum('quantity_variant');
        //             Log::info("[getSoldQuantity] [DEBUG PRODUCT 89] Variant Sold Quantity: " . $variantSoldQuantity);
        //             return $variantSoldQuantity;
        //         });
        //         Log::info("[getSoldQuantity] [DEBUG PRODUCT 89] Total Sold Quantity for Variant Product: " . $totalSoldQuantity);
        //     }
        //     Log::info("[getSoldQuantity] [DEBUG PRODUCT 89] Function END. Product ID: " . $this->id . ", Total Sold Quantity: " . $totalSoldQuantity);
        //     Log::info("[getSoldQuantity] [DEBUG PRODUCT 89] --- END getSoldQuantity ---, Total Sold Quantity: " . $totalSoldQuantity);
        // }


        // Logic đếm số lượng bán (KHÔNG ĐỔI - vẫn dùng quantity_variant cho biến thể, quantity cho đơn)
        if (!$this->isVariant()) {
            return $this->orderItems()
                ->whereHas('order', function ($query) {
                    $query->whereHas('orderStatuses', function ($subQuery) {
                        $subQuery->where('name', 'Hoàn thành');
                    });
                })
                ->sum('quantity');
        } else {
            $variants = $this->productVariants()->with('orderItems')->get();
            return $variants->sum(function ($variant) {
                return $variant->orderItems()
                    ->whereHas('order', function ($query) {
                        $query->whereHas('orderStatuses', function ($subQuery) {
                            $subQuery->where('name', 'Hoàn thành');
                        });
                    })
                    ->sum('quantity_variant');
            });
        }
    }
    // sort bán chạy
    public function getSoldQuantitySubQuery()
    {
        $orderStatusesHoanThanhCondition = "order_statuses.name = 'Hoàn thành'";

        return '(SELECT COALESCE(SUM(CASE WHEN order_items.product_variant_id IS NOT NULL THEN order_items.quantity_variant ELSE order_items.quantity END), 0)
                FROM order_items
                JOIN orders ON order_items.order_id = orders.id
                JOIN order_order_status ON orders.id = order_order_status.order_id
                JOIN order_statuses ON order_order_status.order_status_id = order_statuses.id
                WHERE order_items.product_id = products.id
                AND ' . $orderStatusesHoanThanhCondition . ')';
    }


}
