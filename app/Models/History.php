<?php

namespace App\Models;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillables = [
        'category_id',
        'attribute_id',
        'attribute_value_id',
        'product_id',
        'product_variant_id',
        'payment_id',
        'order_id',
        'order_confirmation_id',
        'review_id',
        'promotion_id',
        'coupon_id',
        'user_id',
        'action',
    ];



    /////////////////////////////////////////////////////
    // RELATIONS

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderConfirmation()
    {
        return $this->belongsTo(OrderConfirmation::class);
    }

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
