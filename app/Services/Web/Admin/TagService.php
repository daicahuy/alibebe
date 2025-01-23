<?php

namespace App\Services\Web\Admin;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use App\Repositories\TagRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
    public function storeTag(StoreTagRequest $storeTagRequest)  {
        try {
            $data = $storeTagRequest->validated();
            $data['slug'] = str::slug($data['name']);
            return $this->TagRepository->create($data);

        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . "@" .__FUNCTION__,
                ['error'=> $th->getMessage()]
            );
        }
    }

    public function UpdateTag(UpdateTagRequest $updateTagRequest, Tag $tag) {
        $data = $updateTagRequest->validated();
        try {
            $data['slug'] = str::slug($data['name']);
            return $this->TagRepository->update($tag->id ,$data);
        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . "@" . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
        }
    }
    public function delete(int $id) {
        try {
            return $this->TagRepository->delete($id);
        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . "@" . __FUNCTION__,
                ['error'=> $th->getMessage()]
            );
            throw $th;
        }
    }
    public function deleteAll(array $ids)  {
        try {
            // dd($ids);
            return $this->TagRepository->deleteAll($ids);
        } catch (\Throwable $th) {
            Log::error(__CLASS__ . "@" . __FUNCTION__, ['error' => $th->getMessage()]);
            throw $th; // Truyền tiếp lỗi lên Controller
        }
    }
}