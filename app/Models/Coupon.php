<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    const DISCOUNT_TYPE_PERCENT = 'percent';
    const DISCOUNT_TYPE_FIX_AMOUNT = 'fix_amount';

    const USER_GROUP_ALL = 'all';
    const USER_GROUP_NEWBIE = 'newbie';
    const USER_GROUP_IRON = 'iron';
    const USER_GROUP_BRONZE = 'bronze';
    const USER_GROUP_SILVER = 'silver';
    const USER_GROUP_GOLD = 'gold';
    const USER_GROUP_PLATINUM = 'platinum';
    const USER_GROUP_DIAMOND = 'diamond';

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

    public function isTypePercent()
    {
        return $this->discount_type === self::DISCOUNT_TYPE_PERCENT;
    }

    public function isTypeFixAmount()
    {
        return $this->discount_type === self::DISCOUNT_TYPE_FIX_AMOUNT;
    }



    /////////////////////////////////////////////////////
    // RELATIONS

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
