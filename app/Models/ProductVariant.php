<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'sale_price',
        'thumbnail',
        'is_active',
    ];



    /////////////////////////////////////////////////////
    // RELATIONS

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productStock()
    {
        return $this->hasOne(ProductStock::class);
    }

    public function productMovement()
    {
        return $this->hasMany(StockMovement::class);
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


}
