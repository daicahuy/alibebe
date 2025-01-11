<?php

namespace App\Repositories;

use App\Models\CommentReply;

class CommentReplyRepository extends BaseRepository {
    
    public function getModel()
    {
        return CommentReply::class;
    }
    
}