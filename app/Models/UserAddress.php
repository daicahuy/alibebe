<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "address",
        "fullname",
        "phone_number",
        "is_default",
    ];

    public $attributes = [
        'is_default' => 0
    ];

    /////////////////////////////////////////////////////
    // RELATIONS

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
