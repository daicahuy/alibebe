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
        'name',
        'email',
        'password',
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
        'email_verified_at' => 'datetime',
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
}
