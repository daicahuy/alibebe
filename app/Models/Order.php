<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPING = 'shipping';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_FAILED_DELIVERY = 'failed_delivery';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCEL = 'cancel';

    protected $fillables = [
        'code',
        'coupon_id',
        'user_id',
        'payment_id',
        'fullname',
        'address',
        'phone_number',
        'total_amount',
        'status',
        'note',
        'is_paid',
    ];

    public function isStatusPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isStatusProcessing()
    {
        return $this->status === self::STATUS_PROCESSING;
    }

    public function isStatusShipping()
    {
        return $this->status === self::STATUS_SHIPPING;
    }

    public function isStatusDelivered()
    {
        return $this->status === self::STATUS_DELIVERED;
    }

    public function isStatusFailedDelivery()
    {
        return $this->status === self::STATUS_FAILED_DELIVERY;
    }

    public function isStatusCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isStatusCancel()
    {
        return $this->status === self::STATUS_CANCEL;
    }



    /////////////////////////////////////////////////////
    // RELATIONS

    public function orderConfirmation()
    {
        return $this->hasOne(OrderConfirmation::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    
}
