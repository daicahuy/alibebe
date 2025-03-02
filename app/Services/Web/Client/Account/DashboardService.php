<?php

namespace App\Services\Web\Client\Account;

use App\Repositories\AccountRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserAddressRepository;
use App\Repositories\UserRepository;
use App\Repositories\WishlistRepository;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    protected UserRepository $userRepository;
    protected OrderRepository $orderRepository;
    protected WishlistRepository $wishlistRepository;
    protected AccountRepository $accountRepository;

    public function __construct(
        UserRepository $userRepository,
        OrderRepository $orderRepository,
        WishlistRepository $wishlistRepository,
        AccountRepository $accountRepository
    ) {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
        $this->wishlistRepository = $wishlistRepository;
        $this->accountRepository = $accountRepository;
    }

    public function index()
    {
        $id = Auth::id();

        // Lấy thông tin user 1 lần thay vì gọi nhiều lần
        $user = $this->userRepository->findById($id);
        $point = $user->loyalty_points;

        return [
            'countOrder'      => $this->orderRepository->getOrderStatistics(),
            'wishlist'        => $this->wishlistRepository->countWishlists(),
            'userGroup'       => strtolower($this->userRepository->getUserRank($point)),
            'point'           => $point,
            'user'            => $user,
            'defaultAddress'  => $this->accountRepository->getUserProfileData()->defaultAddress ?? null
        ];
    }
}
