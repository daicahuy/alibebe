<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\CouponDiscountType;
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
        $coupon = $coupon->with('restriction',)->findOrFail($coupon->id);
        $categories = $this->couponService->showCategories();
        $products = $this->couponService->showProducts();
        $userGroupTypes = UserGroupType::getKeys();

        $selectedCategories = json_decode($coupon->restriction->valid_categories);
        $selectedProducts = json_decode($coupon->restriction->valid_products);

        $discountTypes = CouponDiscountType::asArray();

        return view('admin.pages.coupons.edit', compact(
            'coupon',
            'categories',
            'products',
            'userGroupTypes',
            'discountTypes',
            'selectedCategories',
            'selectedProducts'
        ));
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $this->couponService->update($request->validated());
    }

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

    public function forceDestroySelected()
    {
        $couponIds = request('selected_coupons');

        $result = $this->couponService->forceDeleteSelectedCoupons($couponIds);

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

    public function searchCoupon()
    {
        // Lấy searchKey từ query string (nếu có)
        $searchKey = request('searchKey', '');
        $searchKey = trim($searchKey);
        $perPage = request('per_page', 10); // Đặt số lượng bản ghi trên mỗi trang

        // Lấy kết quả tìm kiếm với phân trang
        $coupons = $this->couponService->searchCouponWithSeachKey($searchKey, $perPage);

        // Đảm bảo tham số searchKey và perPage vẫn xuất hiện trong URL khi phân trang
        $coupons = $coupons->appends([
            'searchKey' => $searchKey,
            'per_page' => $perPage,
        ]);

        // Trả về view với dữ liệu phân trang và từ khóa tìm kiếm (nếu có)
        return view('admin.pages.coupons.list', compact('coupons', 'searchKey'));
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
