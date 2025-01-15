<?php

namespace App\Services\Web\Admin;

use ApiBaseController;
use App\Enums\CouponDiscountType;
use App\Models\Coupon;
use App\Repositories\CategoryRepository;
use App\Repositories\CouponRepository;
use App\Repositories\CouponRestrictionRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CouponService
{
    public CouponRepository $couponRepository;
    public CouponRestrictionRepository $couponRestrictionRepository;
    public ProductRepository $productRepository;
    public CategoryRepository $categoryRepository;

    public function __construct(
        CouponRepository $couponRepository,
        CouponRestrictionRepository $couponRestrictionRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->couponRepository = $couponRepository;
        $this->couponRestrictionRepository = $couponRestrictionRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function showCategories()
    {
        return $this->categoryRepository->getAll(['*'], ['categories']);
    }
    public function showProducts()
    {
        return $this->productRepository->getAll();
    }
    public function countCouponInTrash()
    {
        return $this->couponRepository->countCouponInTrash();
    }
    // Lất Tất Cả Dữ Liệu Mã Giảm Giá cùn với các Mối Quan Hệ (orders , users , restriction)
    public function getAllCoupons($perPage)
    {
        return $this->couponRepository
            ->pagination(['*'], $perPage, ['id', 'DESC'], ['orders', 'users', 'restriction']);
    }
    // Hiển Thị Chi Tiết Mã Giảm Giá
    public function getCouponById(Coupon $coupon) {
        return $this->couponRepository->findById($coupon->id);
    }

    // Thêm mới mã giảm giá
    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            // Chia nhỏ dữ liệu từ $data
            $couponData = [
                'code' => $data['code'] ?? null,
                'title' => $data['title'] ?? null,
                'description' => $data['description'] ?? null,
                'discount_type' => $data['discount_type'],
                'discount_value' => $data['discount_value'] ?? 0,
                'usage_limit' => $data['usage_limit'] ?? 0,
                'usage_count' => $data['usage_count'] ?? 0,
                'user_group' => $data['user_group'] ?? 0,
                'is_expired' => isset($data['is_expired']) ? $data['is_expired'] : 0,
                'is_active' => isset($data['is_active']) ? $data['is_active'] : 0,
                'start_date' => $data['start_date'] ?? null,
                'end_date' => $data['end_date'] ?? null,
            ];

            // Lưu thông tin mã giảm giá vào bảng coupons
            $coupon = $this->couponRepository->create($couponData);

            // Lấy dữ liệu ràng buộc
            $restrictionsData = [
                'min_order_value' => $data['coupon_restrictions']['min_order_value'] ?? 0,
                'max_discount_value' => $data['coupon_restrictions']['max_discount_value'] ?? null,
                'valid_categories' => json_encode($data['coupon_restrictions']['valid_categories']),
                'valid_products' => json_encode($data['coupon_restrictions']['valid_products']),
                'coupon_id' => $coupon->id
            ];

            // Lưu ràng buộc nếu có
            if (!empty($restrictionsData)) {
                $this->couponRestrictionRepository->create($restrictionsData);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Error in CouponService::store", [
                'message' => $th->getMessage(),
                'data' => $data
            ]);
            throw $th;
        }
    }
    // Xóa mềm mã giảm giá
    public function deleteCoupon($couponId)
    {
        try {
            $coupon = $this->couponRepository->findByIdWithRelation($couponId, ['restriction']);
            $this->couponRepository->update($couponId, [
                'is_active' => 0
            ]);
            if ($coupon->restriction) {
                $coupon->restriction->delete();
            }
            $coupon->delete();
        } catch (\Throwable $th) {
            Log::error("Error in CouponService::deleteCoupon", [
                'message' => $th->getMessage()
            ]);
            throw $th;
        }
    }
    // Xóa cứng mã giảm giá
    public function forceDeleteCoupon($couponId)
    {
        DB::beginTransaction();
        try {
            $coupon = $this->couponRepository->findCouponDestroyedWithRelation($couponId, ['restriction']);
            if ($coupon->restriction) {
                $coupon->restriction->forceDelete();
            }
            $coupon->forceDelete();
            DB::commit();
        } catch (\Throwable $th) {
            Log::error("Error in CouponService::ForceDeleteCoupon", [
                'message' => $th->getMessage()
            ]);
            DB::rollBack();
            throw $th;
        }
    }
    // Lấy tất cả mã giảm giá ở trong thùng rác
    public function getAllCouponsInTrash()
    {
        return $this->couponRepository->trash();
    }
    // Khôi Phục 1 mã giảm giá
    public function restoreOneCoupon($couponId)
    {
        try {
            $coupon = $this->couponRepository->findCouponDestroyedWithRelation($couponId, ['restriction']);
            $coupon->restore();
            if ($coupon->restriction) {
                $coupon->restriction->restore();
            }
            $this->couponRepository->update($couponId, [
                'is_active' => 1
            ]);
        } catch (\Throwable $th) {
            Log::error("Error in CouponService::restoreOneCoupon", [
                'message' => $th->getMessage()
            ]);
            DB::rollBack();
            throw $th;
        }
    }
}
