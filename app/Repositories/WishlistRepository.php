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
            ->with([
                'product.brand',
                'product.productVariants'
            ])
            ->latest('id')
            ->paginate(10);
    }
    public function getWishlistById($userId)
    {
        return $this->model->where('user_id', $userId)
            ->with([
                'product.brand',
                'product.productVariants'
            ])
            ->latest('id')
            ->paginate(5, ['*'], 'wishlists_page');
    }
    public function countWishlistById($userId)
    {

        $user = User::with('wishlists')->findOrFail($userId);

        return $user->wishlists->count();
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

    // customer detail
    public function getTimeActivity($userId)
    {
        $latestActivity = $this->model->where('user_id', $userId)->latest()->first();
        return $latestActivity;
    }
}
