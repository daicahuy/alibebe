<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    
    protected $fillable = [
        'name',
        'logo',
        'is_active',
    ];



    /////////////////////////////////////////////////////
    // RELATIONS

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


}
