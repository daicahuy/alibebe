<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryOrderStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'order_status_id',
    ];


    public function order()
    {
        return $this->belongsToMany(Order::class);
    }


}
