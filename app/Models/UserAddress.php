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
        "id_default",
    ];

    public $attributes = [
        'id_default' => 0
    ];

    /////////////////////////////////////////////////////
    // RELATIONS

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
