<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository extends BaseRepository {
    
    public function getModel()
    {
        return Tag::class;
    }
    public function getIndexTag(int $perPage, string $keyWord = null)  {
        $query = Tag::query();
        if($keyWord){
            $query->where('name', 'like', '%'.$keyWord.'%');
        }
        return $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();
    }
}