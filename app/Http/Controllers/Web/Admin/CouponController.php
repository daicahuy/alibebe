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
        $sortField = request('sortField', 'id'); // Mặc định là 'id'
        $sortDirection = request('sortDirection', 'DESC'); // Mặc định là 'DESC'

        // Lấy danh sách mã giảm giá dựa trên sắp xếp
        $coupons = $this->couponService->getAllCoupons($perPage, $sortField, $sortDirection);

        // Đếm số mã giảm giá trong thùng rác
        $couponsIntrash = $this->couponService->countCouponInTrash();

        // Đếm số mã giảm giá ẩn
        $couponsHidden = $this->couponService->countCouponHidden();

        return view('admin.pages.coupons.list', compact('coupons', 'couponsIntrash', 'couponsHidden'));
    }

    public function hide()
    {
        $perPage = request('per_page', 10);
        $sortField = request('sortField', 'id'); // Mặc định là 'id'
        $sortDirection = request('sortDirection', 'DESC'); // Mặc định là 'DESC'

        // Lấy danh sách mã giảm giá dựa trên sắp xếp
        $coupons = $this->couponService->getAllCouponsByStatus($perPage, $sortField, $sortDirection);

        // Đếm số mã giảm giá trong thùng rác
        $couponsIntrash = $this->couponService->countCouponInTrash();

        return view('admin.pages.coupons.hide', compact('coupons', 'couponsIntrash'));
    }

    public function show(Coupon $coupon)
    {
        $coupon = $this->couponService->getCouponWithRelations($coupon->id, ['restriction']);
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
        $result = $this->couponService->update($request->validated(), $coupon->id);

        if ($result['status']) {
            return redirect()->route('admin.coupons.edit', $coupon)->with('success', $result['message']);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
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
        $perPage = request('per_page', 10);
        $sortField = request('sortField', 'id'); // Mặc định là 'id'
        $sortDirection = request('sortDirection', 'DESC'); // Mặc định là 'DESC'

        $coupons = $this->couponService->getAllCouponsInTrash($perPage, $sortField, $sortDirection);
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
        // Gọi service để tìm kiếm và xử lý logic
        $result = $this->couponService->searchCouponWithSeachKey();

        // Kiểm tra kết quả trả về từ service
        if ($result['status']) {
            return view('admin.pages.coupons.list', [
                'coupons' => $result['coupons'],
                'couponsIntrash' => $result['couponsIntrash'],
                'couponsHidden' => $result['couponsHidden']
            ]);
        } else {
            return back()->withErrors(['message' => $result['message']]);
        }
    }

    public function updateUsageLimitOrEndDate(string $id)
    {
        $data = request()->validate([
            'usage_limit' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:today'
            ],
        ]);

        $result = $this->couponService->updateUsageLimitOrEndDate($data, $id);

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
