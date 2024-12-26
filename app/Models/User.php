<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    const GENDER_OTHER = 'other';

    const ROLE_ADMIN = 'admin';
    const ROLE_EMPLOYEE = 'employee';
    const ROLE_CUSTOMER = 'cusmoter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'google_id',
        'full_name',
        'email',
        'phone_number',
        'verified_at',
        'password',
        'avatar',
        'gender',
        'birthday',
        'role',
        'is_active',
        'expense',
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
    ];

    public function isGenderMale() {
        return $this->gender === self::GENDER_MALE;
    }

    public function isGenderFemale() {
        return $this->gender === self::GENDER_FEMALE;
    }

    public function isGenderOther() {
        return $this->gender === self::GENDER_OTHER;
    }

    public function isRoleAdmin() {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isRoleEmployee() {
        return $this->role === self::ROLE_EMPLOYEE;
    }

    public function isRoleCustomer() {
        return $this->role === self::ROLE_CUSTOMER;
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

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class)->withPivot('quantity');
    }

    public function userAddresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function senderNotices()
    {
        return $this->hasMany(Notice::class, 'sender_id');
    }

    public function receiverNotices()
    {
        return $this->hasMany(Notice::class, 'receiver_id');
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

}
