<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\UserGroupType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;
use App\Models\Coupon;
use App\Services\Web\Admin\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CouponController extends Controller
{
    protected $couponService;
    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    public function index()
    {
        $perPage = request('per_page',10);
        $coupons = $this->couponService->getAllCoupons($perPage);
        $couponsIntrash = $this->couponService->countCouponInTrash();
        return view('admin.pages.coupons.list', compact('coupons','couponsIntrash'));
    }

    public function show(Coupon $coupon) {
        $coupon = $coupon->with('restriction')->findOrFail($coupon->id);
        return view('admin.pages.coupons.show',compact('coupon'));
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
        try {
            $this->couponService->store($request->validated());
            return redirect()
                ->route("admin.coupons.index")
                ->with("success", "Thêm Mới Thành Công !!!");
        } catch (\Throwable $th) {
            Log::error("message" . $th->getMessage());
            return back()->withErrors(['message' => 'Có lỗi xảy ra !!!']);
        }
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.pages.coupons.edit');
    }

    public function update(Request $request, Coupon $coupon) {}

    public function destroy(Coupon $coupon)
    {
        try {
            $this->couponService->deleteCoupon($coupon->id);
            return redirect()
                ->route("admin.coupons.index")
                ->with("success", "Đưa Mã Vào Thùng Rác Thành Công !!!");
        } catch (\Throwable $th) {
            return back()->withErrors(['message' => 'Có lỗi xảy ra !!!']);
        }
    }

    public function trash()
    {
        $coupons = $this->couponService->getAllCouponsInTrash();
        return view('admin.pages.coupons.trash', compact('coupons'));
    }

    public function forceDestroy(string $id) {
        try {
            $this->couponService->forceDeleteCoupon($id);
            return redirect()
                ->route("admin.coupons.index")
                ->with("success", "Xóa Mã Giảm Giá Thành Công !!!");
        } catch (\Throwable $th) {
            return back()->withErrors(['message' => 'Có lỗi xảy ra !!!']);
        }
    }

    public function restore(string $id) {
        try {
            $this->couponService->restoreOneCoupon($id);
            return redirect()
            ->route("admin.coupons.index")
            ->with("success", "Khôi Phục Mã Giảm Giá Thành Công !!!");
        } catch (\Throwable $th) {
            Log::error("message" . $th->getMessage());
            return back()->withErrors(['message' => 'Có lỗi xảy ra !!!']);
        }
    }
}
