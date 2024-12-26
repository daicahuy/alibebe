<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillables = [
        'promotion_name',
        'percent_decrease',
        'is_active',
        'start_date',
        'end_date',
    ];



    /////////////////////////////////////////////////////
    // RELATIONS

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }
    

}
