<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'total_amount',
        'bank_account',
        'phone_number',
        'bank_name',
        'user_bank_name',
        'reason',
        'reason_image',
        'admin_reason',
        'status',
        'fail_reason',
        'img_fail_or_completed',
        'bank_account_status',
        'is_send_money',
        'user_handle',
        'confirm_order_with_admin'
    ];

    public function refundItems()
    {
        return $this->hasMany(RefundItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'refund_id');
    }

    public function handleUser()
    {
        return $this->belongsTo(User::class, 'user_handle', 'id');
    }
}
