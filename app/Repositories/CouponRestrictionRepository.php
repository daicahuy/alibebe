<?php
namespace App\Repositories;

use App\Models\CouponRestriction;

class CouponRestrictionRepository extends BaseRepository
{
    public function getModel() {
        return CouponRestriction::class;
    }
}