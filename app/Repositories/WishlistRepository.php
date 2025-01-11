<?php

namespace App\Repositories;

use App\Models\Wishlist;

class WishlistRepository extends BaseRepository {
    
    public function getModel()
    {
        return Wishlist::class;
    }
    
}