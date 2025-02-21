<?php

namespace App\Http\Controllers\Web\Client;

use App\Enums\UserGenderType;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAccountPasswordRequest;
use App\Services\Web\Client\Account\AddressService;
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
    public function __construct(
        OrderService $orderService,
        ProfileService $profileService,
        AddressService $addressService,
        WishlistService $wishlistService
    ) {
        $this->orderService = $orderService;
        $this->profileService = $profileService;
        $this->addressService = $addressService;
        $this->wishlistService = $wishlistService;
    }

    // ============== dashboard ===============
    public function dashboard()
    {
        return view('client.pages.accounts.dashboard');
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
    // ============== orders ==================
    public function order()
    {
        $orders = $this->orderService->index();
        return view('client.pages.accounts.order', compact('orders'));
    }

    public function orderDetail()
    {
        return view('client.pages.accounts.order_detail');
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
        $result = $this->profileService->updateInfomation();
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
            return redirect()->route('account.profile')->with('success', $result['message']);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }

    // ============= wishlist ===============
    public function wishlist()
    {
        $wishlist = $this->wishlistService->index();
        return view('client.pages.accounts.wishlist',compact('wishlist'));
    }

    public function addWishlist($id) {
        $result = $this->wishlistService->add($id);
        if ($result['status']) {
            return redirect()->route('account.wishlist')->with('success', $result['message']);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
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
        return view('client.pages.accounts.coupons');
    }
}
