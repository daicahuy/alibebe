<?php

namespace App\Models;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeValue extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'attribute_id',
        'value',
        'is_active',
    ];

    protected $attributes = [
        'is_active'=>0
    ];

    /////////////////////////////////////////////////////
    // RELATIONS

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function productVariants()
    {
        return $this->belongsToMany(ProductVariant::class);
    }


}