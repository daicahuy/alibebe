<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillables = [
        'name',
        'slug',
        'is_variant',
        'is_active',
    ];


    
    /////////////////////////////////////////////////////
    // RELATIONS

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }
    
    
}
