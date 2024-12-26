<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillables = [
        'product_id',
        'user_id',
        'content',
    ];



    /////////////////////////////////////////////////////
    // RELATIONS

    public function commentReplies()
    {
        return $this->hasMany(CommentReply::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
