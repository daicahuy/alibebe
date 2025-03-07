<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Services\Web\Admin\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index(Request $request)
    {
        $limit = $request->input('limit', 15); 
        $keyword = $request->input('_keyword'); 
        $listComment = $this->commentService->listComment($limit, $keyword); 

        return view('admin.pages.comments.list', compact('listComment', 'limit', 'keyword')); 
    }
    public function show(Request $request, Product $product)
    {
        $search = $request->input('search');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $sort = $request->input('sort'); 

        $showComment = $this->commentService->showComment($product->id, $search, $dateFrom, $dateTo, $sort);
        $totalCommentsAndReplies = $this->commentService->getTotalCommentsAndRepliesCount($product->id);
        return view('admin.pages.comments.show', compact('showComment', 'product', 'search', 'dateFrom', 'dateTo', 'sort','totalCommentsAndReplies'));
    }
    public function getCommentReplies($commentId)
    {
        $replies = $this->commentService->ListReply($commentId);
        return response()->json($replies);
    }

    public function deleteComment($id)
    {
        $result = $this->commentService->deleteComment($id); 

        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Bình luận và các phản hồi đã xóa thành công!']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Không thể xóa bình luận. Bình luận không tồn tại hoặc có lỗi xảy ra.']);
        }
    }

    public function deleteReply($id)
    {
        $result = $this->commentService->deleteReply($id);

        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Phản hồi đã xóa thành công!']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Không thể xóa phản hồi. Phản hồi không tồn tại hoặc có lỗi xảy ra.']);
        }
    }
}
