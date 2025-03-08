<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\MockObject\Stub\ReturnReference;

class AccountRepository extends BaseRepository
{
    public function getModel()
    {
        return User::class;
    }

    public function getUserProfileData()
    {
        /**
         * @var mixed
         */
        
        $user = Auth::user();
    
        if ($user) {
            $user->load(
                'cartItems',
                'comments',
                'commentReplies',
                'wishlists',
                'orders',
                'coupons',
                'reviews',
                'addresses'
            );
    
            // Lấy địa chỉ mặc định, nếu có
            $user->defaultAddress = $user->addresses->firstWhere('is_default', 1);
        }
    
        return $user;
    }


    public function findUserLogin()
    {
        $user_id = Auth::user()->id;
        $user = $this->model->findOrFail($user_id);
        return $user;
    }
}
