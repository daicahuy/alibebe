<?php

namespace App\Repositories;

use App\Models\UserAddress;

class UserAddressRepository extends BaseRepository {
    
    public function getModel()
    {
        return UserAddress::class;
    }
    
}