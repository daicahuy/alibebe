<?php

namespace App\Repositories;

use App\Models\CommentReply;

class CommentReplyRepository extends BaseRepository {
    
    public function getModel()
    {
        return CommentReply::class;
    }
    
    public function createReply($data)
    {
        return CommentReply::create($data);
    }

    public function ListReply($commentId)
    {
        $query = $this->model->where('comment_id', $commentId)
                             ->with('user'); 

        return $query->get();
    }
    
    public function deleteReply(int $replyId): bool
    {
        $reply = $this->findById($replyId);

        if (!$reply) {
            return false; 
        }

        return $reply->delete();
    }
}