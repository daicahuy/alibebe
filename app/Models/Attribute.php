<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'is_variant',
        'is_active',
    ];

    protected $attributes = [
        'is_variant'=> 0,
        'is_active'=>0

    ];
    
    /////////////////////////////////////////////////////
    // RELATIONS

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }


}
