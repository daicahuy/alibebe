<?php

namespace App\Models;

use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use SoftDeletes;

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

    public function isSingle()
    {
        return $this->type = ProductType::SINGLE;
    }

    public function isVatiant()
    {
        return $this->type = ProductType::VARIANT;
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
        return $this->hasOne(ProductStock::class);
    }

    public function productMovement()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function scopeTrending($query)
    {
        return $query->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('reviews', 'reviews.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                'products.thumbnail',
                'products.price',
                'products.sale_price',
                'products.created_at',
                DB::raw('COALESCE(AVG(reviews.rating), 0) as average_rating'),
                DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->groupBy('products.id', 'products.name', 'products.thumbnail', 'products.price', 'products.sale_price')
            ->orderByDesc('total_sold');
    }
}
