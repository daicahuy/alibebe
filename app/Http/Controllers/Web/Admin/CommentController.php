<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\Web\Admin\CommentService;


class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService) {
        $this->commentService = $commentService;
    }
   
    public function index(){
        $listComment = $this->commentService->listComment();
        return view('admin.pages.comments.list', compact('listComment'));
    }
}
