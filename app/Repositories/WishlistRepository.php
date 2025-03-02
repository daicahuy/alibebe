<?php

namespace App\Repositories;

use App\Models\User;
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
    public function countWishlists()
    {
        $authLogin = Auth::id();
        $user = User::with('wishlists')->findOrFail($authLogin);

        return $user->wishlists->count();
    }

    public function findByUserAndProduct($userId, $productId)
    {
        return $this->model->where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
    }
}
