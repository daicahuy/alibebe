<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Support\Facades\DB;

class CommentRepository extends BaseRepository
{

    public function getModel()
    {
        return Comment::class;
    }

    public function createComment($data)
    {
        return $this->model->create($data);
    }
    public function listComment(int $limit = 15, string $keyword = null) 
    {
        $subQueryReplies = DB::table('comment_replies')
            ->selectRaw('comment_id, COUNT(*) as replies_count')
            ->groupBy('comment_id');

        $comments = $this->model->select(
            'products.id as product_id',
            'products.name as product_name',
            DB::raw('COUNT(DISTINCT comments.id) + COALESCE(SUM(replies.replies_count), 0) as total_comments')
        )
            ->join('products', 'comments.product_id', '=', 'products.id')
            ->leftJoinSub($subQueryReplies, 'replies', 'comments.id', '=', 'replies.comment_id')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_comments');

        if ($keyword) { 
            $comments->where(function ($query) use ($keyword) {
                $query->where('products.name', 'like', '%' . $keyword . '%');
            });
        }

        if ($limit !== null) {
            $comments->limit($limit);
        }

        return $comments->paginate($limit);
    }

    public function showComment($productId, string $search = null, string $dateFrom = null, string $dateTo = null, string $sort = null)
    {
        $query = $this->model->with('user') 
            ->where('product_id', $productId); 

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('fullname', 'like', '%' . $search . '%'); 
                    })
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        // **Lọc theo khoảng thời gian**
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom); 
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo); 
        }

        // **Sắp xếp bình luận**
        if ($sort === 'newest') {
            $query->orderBy('created_at', 'desc'); 
        } elseif ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc'); 
        } else {
            $query->orderBy('created_at', 'desc'); 
        }

        return $query->paginate(10); 
    }

    public function deleteComment(int $commentId): bool
    {
        $comment = $this->findById($commentId);

        if (!$comment) {
            return false;
        }

        CommentReply::where('comment_id', $comment->id)->delete();

        return $comment->delete();
    }

    public function getTotalCommentsAndRepliesCount(int $productId): int
    {
        $subQueryReplies = DB::table('comment_replies')
            ->selectRaw('comment_id, COUNT(*) as replies_count')
            ->groupBy('comment_id');

        $totalCount = $this->model
            ->where('product_id', $productId)
            ->leftJoinSub($subQueryReplies, 'replies', 'comments.id', '=', 'replies.comment_id')
            ->selectRaw('COUNT(DISTINCT comments.id) + COALESCE(SUM(replies.replies_count), 0) as total')
            ->value('total'); 

        return $totalCount ?? 0; 
    }
    
}
