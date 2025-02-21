<?php

namespace App\Repositories;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistRepository extends BaseRepository
{

    public function getModel()
    {
        return Wishlist::class;
    }

    public function getWishlistForUserLogin()
    {
        $authLogin = Auth::id();

        return $this->model->where('user_id', $authLogin)
            ->with('product.brand')
            ->latest('id')
            ->paginate(10);
    }
}
