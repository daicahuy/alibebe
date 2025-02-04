<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository extends BaseRepository
{

    public function getModel()
    {
        return Tag::class;
    }
    public function getIndexTag(int $perPage, string $keyWord = null, string $sort = null, string $order = null)
    {
        $query = Tag::query();
        
        if ($keyWord) {
            $query->where('name', 'like', '%' . $keyWord . '%');
        } elseif ($sort) {
            $query->orderBy($sort, $order);
        } else {
            $query->orderBy('created_at', 'asc');
        }
        return $query->paginate($perPage);
    }
    public function delete(int $id)
    {
        $tag = $this->findById($id);
        if ($tag->products()->exists()) {
            throw new \Exception('Không thể xóa do đã có sản phẩm liên kết');
        }
        return $tag->delete();
    }
    public function deleteAll(array $ids)
    {
        $tags = Tag::whereIn('id', $ids)->get();
        // dd($tags);
        $TagIdWithProducts = [];
        foreach ($tags as $tag) {
            if ($tag->products()->exists()) {
                $TagIdWithProducts[] = $tag->id;
            }
        }
        if (!empty($TagIdWithProducts)) {
            $TagIdsList = implode(', ', $TagIdWithProducts);
            throw new \Exception("Không thể xóa vì các thẻ sau đang liên kết với sản phẩm: {$TagIdsList}.");
        }

        return Tag::whereIn('id', $ids)->delete();
    }
}