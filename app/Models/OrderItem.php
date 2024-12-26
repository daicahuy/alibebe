<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillables = [
        'order_id',
        'product_id',
        'product_variant_id',
        'name_order_time',
        'price_order_time',
        'quantity',
    ];



    /////////////////////////////////////////////////////
    // RELATIONS

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }


}
