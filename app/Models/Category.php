<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "parent_id",
        "name",
        "slug",
        "ordinal",
        "is_active",
        "icon",
    ];
    public $attributes = [
        'ordinal' => 0,
        'is_active' => 1 //true
    ];

    // public function getRouteKeyName()
    // {
    //     return 'slug'; // Trả về 'slug'
    // }


    /////////////////////////////////////////////////////
    // RELATIONS

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    // public function childProductsCount(): BelongsToMany
    // {
    //     // Quan trọng: Quan hệ này phải trỏ đến relationship products() để đếm SẢN PHẨM
    //     return $this->products();
    // }


}
