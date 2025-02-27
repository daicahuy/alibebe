<?php

namespace App\Services\Web\Client\Account;

use App\Repositories\CouponRepository;
use Illuminate\Support\Facades\Auth;

class CouponService
{
    protected $couponRepository;
    public function __construct(CouponRepository $couponRepository){
        $this->couponRepository = $couponRepository;
    }

    public function getCoupons() {
        $user_id = Auth::id();
        $data = $this->couponRepository->getAllCouponForUserLogin($user_id);
        return $data;
    }
}
