<?php

namespace App\Models;

use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'brand_id',
        'name',
        'name_link',
        'slug',
        'video',
        'views',
        'content',
        'thumbnail',
        'sku',
        'price',
        'sale_price',
        'sale_price_start_at',
        'sale_price_end_at',
        'type',
        'is_active',
        'start_at'
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

    public function productFeatures()
    {
        return $this->hasMany(Product::class);
    }

    public function productAccessories()
    {
        return $this->belongsToMany(Product::class, 'product_accessory', 'product_id', 'product_accessory_id');
    }

    public function productLinks()
    {
        return $this->belongsToMany(Product::class, 'product_link', 'product_id', 'product_link_id');
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

}
