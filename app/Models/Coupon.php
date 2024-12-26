<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    const TYPE_PERCENT = 'percent';
    const TYPE_FIX_AMOUNT = 'fix_amount';

    public $timestamps = false;

    protected $fillables = [
        'code',
        'name',
        'description',
        'quantity',
        'min_order',
        'max_coupon_value',
        'percent_decrease',
        'value',
        'type',
        'is_active',
        'start_date',
        'end_date',
    ];

    public function isTypePercent()
    {
        return $this->type === self::TYPE_PERCENT;
    }

    public function isTypeFixAmount()
    {
        return $this->type === self::TYPE_FIX_AMOUNT;
    }



    /////////////////////////////////////////////////////
    // RELATIONS
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('quantity');
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

}
