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

        return $user->addresses;
    }
}
