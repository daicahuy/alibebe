<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'order_id',
        'user_id',
        'rating',
        'review_text',
        'reason',
        'is_active',
    ];



    /////////////////////////////////////////////////////
    // RELATIONS

    public function reviewMultimedia()
    {
        return $this->hasMany(ReviewMultimedia::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
