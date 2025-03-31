<?php

namespace App\Models;

use App\Enums\CouponDiscountType;
use App\Enums\NotificationType;
use App\Events\CouponExpired;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

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

    protected static function booted()
    {
        static::updated(function ($coupon) {

            if (!$coupon->is_active) {
                return;
            }
            
            $message = '';

            if ($coupon->isExpired()) {
                $message = "Mã giảm giá {$coupon->code} đã hết hạn.";
            } elseif ($coupon->isUsedUp()) {
                $message = "Mã giảm giá {$coupon->code} đã sử dụng hết.";
            } else {
                return;
            }

            // Lấy tất cả admin và nhân viên từ bảng users 
            $admins = User::where('role', 2)->orWhere('role', 1)->get();

            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'message' => $message,
                    'read'    => false,
                    'type'    => NotificationType::Coupon,
                    'coupon_id' => $coupon->id
                ]);
            }

            // Phát event thông báo realtime nếu tích hợp Laravel Echo/Pusher
            event(new CouponExpired($coupon, $message));
        });
    }

    public function isExpired()
    {
        // Nếu coupon không có thời hạn hết hạn
        if ($this->is_expired == 0) {
            return false;
        }

        // Ngược lại, kiểm tra end_date so với thời gian hiện tại
        return $this->end_date < now();
    }


    // Kiểm tra xem mã giảm giá đã sử dụng hết chưa
    public function isUsedUp()
    {
        return $this->usage_count == $this->usage_limit;
    }

    public function isFixAmount()
    {
        return $this->discount_type === CouponDiscountType::FIX_AMOUNT;
    }

    public function isPercent()
    {
        return $this->discount_type === CouponDiscountType::PERCENT;
    }

    public $attributes = [
        'is_active' => 0,
        'is_expired' => 0
    ];


    /////////////////////////////////////////////////////
    // RELATIONS

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'coupon_users', 'coupon_id', 'user_id')->withPivot('created_at', 'updated_at');
    }

    public function restriction()
    {
        return $this->hasOne(CouponRestriction::class);
    }
}
