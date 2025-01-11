<?php

namespace App\Models;

use App\Enums\CouponDiscountType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'code',
        'title',
        'description',
        'discount_type',
        'discount_value',
        'usage_limit',
        'usage_count',
        'user_group',
        'is_expired',
        'is_active',
        'start_date',
        'end_date',
    ];

    public function isFixAmount()
    {
        return $this->discount_type === CouponDiscountType::FIX_AMOUNT;
    }

    public function isPercent()
    {
        return $this->discount_type === CouponDiscountType::PERCENT;
    }


    /////////////////////////////////////////////////////
    // RELATIONS

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('created_at', 'updated_at');
    }

}
