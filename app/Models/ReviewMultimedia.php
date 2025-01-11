<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewMultimedia extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'review_id',
        'file',
        'file_type',
    ];


    /////////////////////////////////////////////////////
    // RELATIONS

    public function review()
    {
        return $this->belongsTo(Review::class);
    }


}
