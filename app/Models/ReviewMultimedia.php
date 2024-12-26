<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewMultimedia extends Model
{
    use HasFactory;

    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';

    public $timestamps = false;

    protected $fillables = [
        'review_id',
        'file',
        'type',
    ];



    /////////////////////////////////////////////////////
    // RELATIONS

    public function review()
    {
        return $this->belongsTo(Review::class);
    }


}
