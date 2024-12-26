<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCollection extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillables = [
        'product_id',
        'image',
    ];



    /////////////////////////////////////////////////////
    // RELATIONS

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
