<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillables = [
        'parent_id',
        'name',
        'logo',
        'is_active',
    ];



    /////////////////////////////////////////////////////
    // RELATIONS

    public function payments()
    {
        return $this->hasMany(Payment::class, 'parent_id');
    }

    public function parentPayment()
    {
        return $this->belongsTo(Payment::class, 'parent_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }


}
