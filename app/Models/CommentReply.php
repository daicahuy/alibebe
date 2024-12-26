<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    use HasFactory;

    protected $fillables = [
        'comment_id',
        'reply_user_id',
        'user_id',
        'content',
    ];



    /////////////////////////////////////////////////////
    // RELATIONS

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replyUser()
    {
        return $this->belongsTo(User::class, 'reply_user_id');
    }


}
