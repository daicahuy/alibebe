<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'user_id',
        'payment_id',
        'phone_number',
        'email',
        'fullname',
        'address',
        'note',
        'total_amount',
        'is_paid',
        'coupon_id',
        'coupon_code',
        'coupon_description',
        'coupon_discount_type',
        'coupon_discount_value',
    ];


    /////////////////////////////////////////////////////
    // RELATIONS

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderStatuses()
    {
        return $this->belongsToMany(OrderStatus::class, 'order_order_status', 'order_id', 'order_status_id')
            ->withPivot('modified_by', 'note', 'employee_evidence', 'customer_confirmation', 'created_at', 'updated_at');
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

    public function historyOrderStatuses()
    {
        return $this->belongsToMany(HistoryOrderStatus::class);
    }
}
