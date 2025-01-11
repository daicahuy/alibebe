<?php

namespace App\Repositories;

use App\Models\Coupon;

class CouponRepository extends BaseRepository {
    
    public function getModel()
    {
        return Coupon::class;
    }
    
}