<?php

namespace App\Models;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillables = [
        'attribute_id',
        'value',
        'is_active',
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

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    
}
