<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'message',
        'read',
        'order_id',
        'coupon_id',
    ];

    protected $casts = [
        'read' => 'boolean',
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với Order (nếu có)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Quan hệ với Coupon (nếu có)
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    // Scopes hữu ích
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }
}
