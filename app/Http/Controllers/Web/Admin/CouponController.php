<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\UserGroupType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Coupon;
use App\Services\Web\Admin\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected $couponService;
    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    public function index()
    {
        $perPage = request('per_page', 10);
        $coupons = $this->couponService->getAllCoupons($perPage);
        $couponsIntrash = $this->couponService->countCouponInTrash();
        return view('admin.pages.coupons.list', compact('coupons', 'couponsIntrash'));
    }

    public function show(Coupon $coupon)
    {
        $coupon = $coupon->with('restriction')->findOrFail($coupon->id);
        return view('admin.pages.coupons.show', compact('coupon'));
    }

    public function create()
    {
        $categories = $this->couponService->showCategories();
        $products = $this->couponService->showProducts();
        $userGroupTypes = UserGroupType::getKeys();

        return view('admin.pages.coupons.create', compact('categories', 'products', 'userGroupTypes'));
    }

    public function store(StoreCouponRequest $request)
    {
        $result = $this->couponService->store($request->validated());

        if ($result['status']) {
            return redirect()->route('admin.coupons.index')->with('success', $result['message']);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }

    public function edit(Coupon $coupon)
    {
        dd($coupon);
        $coupon = $coupon->with('restriction')->findOrFail($coupon->id);
        return view('admin.pages.coupons.edit', compact($coupon));
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon) {}

    public function destroy(Coupon $coupon)
    {
        $result = $this->couponService->deleteCoupon($coupon->id);

        if ($result['status']) {
            return redirect()->route('admin.coupons.trash')->with('success', $result['message']);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }

    public function destroySelected()
    {
        $couponIds = request('selected_coupons');

        $result = $this->couponService->deleteSelectedCoupons($couponIds);

        if ($result['status']) {
            return redirect()->route('admin.coupons.trash')->with('success', $result['message']);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }

    public function trash()
    {
        $coupons = $this->couponService->getAllCouponsInTrash();
        return view('admin.pages.coupons.trash', compact('coupons'));
    }

    public function forceDestroy(string $id)
    {
        $result = $this->couponService->forceDeleteCoupon($id);
        if ($result['status']) {
            return redirect()->route('admin.coupons.trash')->with('success', $result['message']);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }

    public function restore(string $id)
    {
        $result = $this->couponService->restoreOneCoupon($id);
        if ($result['status']) {
            return redirect()->route('admin.coupons.index')->with('success', $result['message']);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }
    public function restoreSelected()
    {
        $couponIds = request('selected_coupons');
        $result = $this->couponService->restoreSelectedCoupon($couponIds);
        if ($result['status']) {
            return redirect()->route('admin.coupons.index')->with('success', $result['message']);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }


    // api
    public function apiUpdateStatus($id)
    {
        // Lấy trạng thái mới từ request
        $couponStatus = request('is_active');

        // Gọi Service để cập nhật trạng thái mã giảm giá
        $result = $this->couponService->apiUpdateStatus($id, $couponStatus);

        return response()->json($result);
    }
}
