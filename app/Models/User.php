<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserGenderType;
use App\Enums\UserRoleType;
use App\Enums\UserStatusType;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const STATUS_INACTIVE = 'inactive';
    const STATUS_ACTIVE = 'active';
    const STATUS_LOCK = 'lock';

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
        'code_verified_at'
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

    public function isInactive()
    {
        return $this->status === UserStatusType::INACTIVE;
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
        return $this->belongsToMany(Coupon::class)->withPivot('created_at', 'updated_at');
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
