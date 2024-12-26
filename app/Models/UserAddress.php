<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillables = [
        "user_id",
        "address",
        "id_default",
    ];



    /////////////////////////////////////////////////////
    // RELATIONS

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
