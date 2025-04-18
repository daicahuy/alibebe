<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserGenderType;
use App\Enums\UserGroupType;
use App\Enums\UserRoleType;
use App\Enums\UserStatusType;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'google_id',
        'facebook_id',
        'phone_number',
        'email',
        'password',
        'fullname',
        'avatar',
        'gender',
        'birthday',
        'loyalty_points',
        'role',
        'status',
        'email_verified_at',
        'code_verified_email',
        'code_verified_at',
        'is_change_password',
        'bank_name',
        'user_bank_name',
        'bank_account',
        'reason_lock',
        'order_blocked_until',
        'time_block_order'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            // Người dùng Google: is_change_password = 0 (chưa đổi mật khẩu)
            // Người dùng thường: is_change_password = 1 (đã có mật khẩu)
            $user->is_change_password = !empty($user->google_id) ? 0 : 1;
        });

        // Khi user mới được tạo
        static::created(function ($user) {
            // Lấy tất cả coupon áp dụng cho Newbie và ALL
            $applicableCoupons = Coupon::whereIn('user_group', [
                UserGroupType::NEWBIE,
                UserGroupType::ALL
            ])->get();

            // Gán từng coupon cho user
            foreach ($applicableCoupons as $coupon) {
                $coupon->users()->syncWithoutDetaching([
                    $user->id => ['amount' => 1]
                ]);
            }
        });

        static::updated(function ($user) {
            if ($user->isDirty('loyalty_points')) {
                $repository = app()->make(UserRepository::class);

                // Lấy điểm cũ và mới
                $oldPoints = $user->getOriginal('loyalty_points');
                $newPoints = $user->loyalty_points;

                // Tính toán group
                $oldGroup = $repository->getUserGroupId($oldPoints);
                $newGroup = $repository->getUserGroupId($newPoints);

                if ($oldGroup !== $newGroup) {
                    $coupons = Coupon::where('user_group', $newGroup)->get();

                    foreach ($coupons as $coupon) {
                        $coupon->users()->syncWithoutDetaching([
                            $user->id => ['amount' => 1]
                        ]);
                    }
                }
            }
        });
    }

    public function isMale()
    {
        return $this->gender === UserGenderType::MALE;
    }

    public function isFemale()
    {
        return $this->gender === UserGenderType::FEMALE;
    }

    public function isOther()
    {
        return $this->gender === UserGenderType::OTHER;
    }

    public function isAdmin()
    {
        return $this->role === UserRoleType::ADMIN;
    }

    public function isEmployee()
    {
        return $this->role === UserRoleType::EMPLOYEE;
    }

    public function isCustomer()
    {
        return $this->role === UserRoleType::CUSTOMER;
    }

    public function isActive()
    {
        return $this->status === UserStatusType::ACTIVE;
    }

    public function isLock()
    {
        return $this->status === UserStatusType::LOCK;
    }


    /////////////////////////////////////////////////////
    // RELATIONS

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentReplies()
    {
        return $this->hasMany(CommentReply::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_users', 'user_id', 'coupon_id')->withPivot('created_at', 'updated_at');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }
}
