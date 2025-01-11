<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository extends BaseRepository {
    
    public function getModel()
    {
        return Tag::class;
    }
    
}