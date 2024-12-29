<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
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


}
