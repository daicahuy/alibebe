<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository extends BaseRepository {
    
    public function getModel()
    {
        return Comment::class;
    }
    
    public function createComment($data)
    {
        return Comment::create($data);
    }
}