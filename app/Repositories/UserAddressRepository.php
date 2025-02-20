<?php

namespace App\Repositories;

use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class UserAddressRepository extends BaseRepository
{

    public function getModel()
    {
        return UserAddress::class;
    }

    public function getAddressesForUser()
    {
        /**
         * @var mixed
         */

        $user = Auth::user();

        $user->load('addresses');

        return $user->addresses()->latest('id')->paginate(6);
    }
    
    public function countAddress(){
        /**
         * @var mixed
         */
        $user = Auth::user();

        $user->load('addresses');

        return $user->addresses()->count();
    }
}
