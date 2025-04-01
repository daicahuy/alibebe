<?php

namespace App\Http\Controllers\Web\Client;

use App\Enums\OrderStatusType;
use App\Enums\UserGenderType;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAccountPasswordRequest;
use App\Services\Web\Client\Account\CouponService;
use App\Services\Web\Client\Account\AddressService;
use App\Services\Web\Client\Account\DashboardService;
use App\Services\Web\Client\Account\OrderService;
use App\Services\Web\Client\Account\ProfileService;
use App\Services\Web\Client\Account\WishlistService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $orderService;
    protected $profileService;
    protected $addressService;
    protected $wishlistService;
    protected $dashboardService;
    protected $couponService;
    public function __construct(
        OrderService $orderService,
        ProfileService $profileService,
        AddressService $addressService,
        WishlistService $wishlistService,
        DashboardService $dashboardService,
        CouponService $couponService,
    ) {
        $this->orderService = $orderService;
        $this->profileService = $profileService;
        $this->addressService = $addressService;
        $this->wishlistService = $wishlistService;
        $this->dashboardService = $dashboardService;
        $this->couponService = $couponService;
    }

    // ============== dashboard ===============
    public function dashboard()
    {
        $data = $this->dashboardService->index();
        // dd($data);
        return view('client.pages.accounts.dashboard',compact('data'));
    }

    // ============== address ===============
    public function address()
    {
        $addresses = $this->addressService->index();
        return view('client.pages.accounts.address', compact('addresses'));
    }

    public function storeAddress() {
        $result = $this->addressService->createAddress();
        if ($result['status']) {
            return redirect()->route('account.address')->with('success', $result['message']);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }
    public function updateAddress($id) {
        $result = $this->addressService->updateAddressService($id);
        if ($result['status']) {
            return redirect()->route('account.address')->with('success', $result['message']);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }
    public function updateDefaultAddress() {
        $result = $this->addressService->updateIdDefault();
        if ($result['status']) {
            return redirect()->route('account.address')->with('success', $result['message']);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }
    public function deleteAddress($id) {
        $result = $this->addressService->deleteAddress($id);
        if ($result['status']) {
            return redirect()->route('account.address')->with('success', $result['message']);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }
    // ========= Profile ===========

    public function profile()
    {
        $user = $this->profileService->index();
        $genders = array_map('strtolower', UserGenderType::asSelectArray());
        return view('client.pages.accounts.profile', compact('user', 'genders'));
    }

    public function updateBasicInfomation()
    {
        $result = $this->profileService->updateInformation();
        if ($result['status']) {
            return redirect()->route('account.profile')->with('success', $result['message']);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }

    public function updateImage()
    {
        $result = $this->profileService->createOrUpdateImage();
        if ($result['status']) {
            return redirect()->route('account.profile')->with('success', $result['message']);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }

    public function updatePassword(UpdateAccountPasswordRequest $updateAccountPasswordRequest)
    {
        $result = $this->profileService->updatePasswordService($updateAccountPasswordRequest);
        if ($result['status']) {
            return redirect()->route('account.profile')
            ->with('success', $result['message'])
            ->with('logout_required', true);;
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }

    // ============= wishlist ===============
    public function wishlist()
    {
        $wishlist = $this->wishlistService->index();
        $wishListCount = $this->wishlistService->count();
        return view('client.pages.accounts.wishlist',compact('wishlist','wishListCount'));
    }

    public function toggleWishlist($id)
    {
        $wishlistItem = $this->wishlistService->findWishlistItem($id);
    
        if ($wishlistItem) {
            $result = $this->wishlistService->remove($wishlistItem->id);
            $action = 'removed'; // Hành động là xóa
        } else {
            $result = $this->wishlistService->add($id);
            $action = 'added'; // Hành động là thêm
        }
        return response()->json([
            'result' => $result['status'],
            'message' => $result['message'],
            'action' => $action,
            'wishlistCount' => $this->wishlistService->count(),
        ]);
    }   
    
    public function removeWishlist($id) {
        $result = $this->wishlistService->remove($id);
        if ($result['status']) {
            return redirect()->route('account.wishlist')->with('success', $result['message']);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }

    // ============= coupon ================
    public function coupon() {
        $coupons = $this->couponService->getCoupons();
        return view('client.pages.accounts.coupons',compact('coupons'));
    }
}
