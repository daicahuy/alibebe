<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const TYPE_SINGLE = 'single';
    const TYPE_VARIANT = 'variant';

    protected $fillables = [
        'brand_id',
        'promotion_id',
        'name',
        'slug',
        'outstanding_features',
        'video',
        'content',
        'thumbnail',
        'sku',
        'price',
        'sale_price',
        'stock',
        'type',
        'is_active',
    ];

    public function isTypeSingle()
    {
        return $this->type = self::TYPE_SINGLE;
    }

    public function isTypeVatiant()
    {
        return $this->type = self::TYPE_VARIANT;
    }



    /////////////////////////////////////////////////////
    // RELATIONS

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

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

    public function categoryTypes()
    {
        return $this->belongsToMany(CategoryType::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function productAccessories()
    {
        return $this->belongsToMany(Product::class, 'product_accessory', 'product_id', 'product_accessory_id');
    }

    public function productLinks()
    {
        return $this->belongsToMany(Product::class, 'product_link', 'product_id', 'product_link_id');
    }

    public function productCollections()
    {
        return $this->hasMany(ProductCollection::class);
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class);
    }
    
    public function histories()
    {
        return $this->hasMany(History::class);
    }
    

}
