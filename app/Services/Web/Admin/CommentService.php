<?php

namespace App\Services\Web\Admin;

use App\Repositories\CommentReplyRepository;
use App\Repositories\CommentRepository;

class CommentService
{
    protected $commentRepository;
    protected $commentReplyRepository;
    public function __construct(
        CommentRepository $commentRepository,
        CommentReplyRepository $commentReplyRepository
    ) {
        $this->commentRepository = $commentRepository;
        $this->commentReplyRepository = $commentReplyRepository;
    }

    public function listComment($limit, $keyword = null) 
    {
        return $this->commentRepository->listComment($limit, $keyword); 
    }
    public function showComment($productId, string $search = null, string $dateFrom = null, string $dateTo = null, string $sort = null)
    {
        return $this->commentRepository->showComment($productId, $search, $dateFrom, $dateTo, $sort);
    }
    public function ListReply($commentId)
    {
        return $this->commentReplyRepository->ListReply($commentId);
    }

    public function deleteComment(int $commentId): bool
    {
        $comment = $this->commentRepository->findById($commentId);

        if (!$comment) {
            return false; 
        }

        return $this->commentRepository->deleteComment($commentId); 

    }
    public function deleteReply(int $replyId): bool
    {
        $reply = $this->commentReplyRepository->findById($replyId);

        if (!$reply) {
            return false; 
        }

        return $this->commentReplyRepository->deleteReply($replyId); 
    }
    public function getTotalCommentsAndRepliesCount(int $productId): int
    {
        return $this->commentRepository->getTotalCommentsAndRepliesCount($productId);
    }
}
