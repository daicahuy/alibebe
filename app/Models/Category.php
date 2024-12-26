<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillables = [
        "parent_id",
        "name",
        "slug",
        "ordinal",
        "is_active",
        "icon",
    ];



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

    public function categoryTypes()
    {
        return $this->hasMany(CategoryType::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }


}
