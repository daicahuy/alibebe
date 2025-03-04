<?php

namespace App\Services\Web\Admin;

use App\Repositories\CommentRepository;

class CommentService
{
    protected $commentRepository;
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function listComment(){
        return $this->commentRepository->listComment();
    }
   
}
