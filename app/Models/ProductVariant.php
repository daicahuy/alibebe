<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillables = [
        'product_id',
        'sku',
        'price',
        'sale_price',
        'stock',
        'thumbnail',
    ];



    /////////////////////////////////////////////////////
    // RELATIONS

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
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
