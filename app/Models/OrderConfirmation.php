<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderConfirmation extends Model
{
    use HasFactory;

    const STATUS_RESOLVED = 'resolved';
    const STATUS_DISPUTED = 'disputed';

    protected $fillables = [
        'order_id',
        'employee_evidence',
        'customer_confirmation',
        'confirmation_status',
    ];

    public function isStatusResolved()
    {
        return $this->status === self::STATUS_RESOLVED;
    }

    public function isStatusDisputed()
    {
        return $this->status === self::STATUS_DISPUTED;
    }



    /////////////////////////////////////////////////////
    // RELATIONS
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }
    

}
