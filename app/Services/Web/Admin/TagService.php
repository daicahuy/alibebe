<?php

namespace App\Services\Web\Admin;

use App\Repositories\TagRepository;

class TagService
{
    protected $TagRepository;
    public function __construct(TagRepository $tagRepository)
    {
         $this->TagRepository = $tagRepository;
    }
    public function listTag15(int $perPage, string $keyWord = null) {
        return $this->TagRepository->getIndexTag($perPage, $keyWord);
    }
}