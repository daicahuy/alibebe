<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ordinal',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_order_status', 'order_status_id', 'order_id');
    }
}
