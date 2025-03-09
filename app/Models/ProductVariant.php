<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'sale_price',
        'thumbnail',
        'is_active',
    ];

    protected $attributes = [
        'is_active' => 0,
    ];



    /////////////////////////////////////////////////////
    // RELATIONS

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productStock()
    {
        return $this->hasOne(ProductStock::class, 'product_variant_id', 'id');
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

    public function getSoldQuantity()
    {
        return $this->orderItems()
            ->whereHas('order', function ($query) {
                $query->whereHas('orderStatuses', function ($subQuery) {
                    $subQuery->where('name', 'Hoàn thành');
                });
            })
            ->sum('quantity_variant'); // **Quan trọng: Sử dụng 'quantity_variant' và không cần CASE WHEN vì đây là function của ProductVariant, chắc chắn là biến thể**
    }

}
