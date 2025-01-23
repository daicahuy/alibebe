<?php

namespace App\Services\Web\Admin;

use ApiBaseController;
use App\Enums\CouponDiscountType;
use App\Enums\UserGroupType;
use App\Models\Coupon;
use App\Repositories\CategoryRepository;
use App\Repositories\CouponRepository;
use App\Repositories\CouponRestrictionRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CouponService
{
    public CouponRepository $couponRepository;
    public CouponRestrictionRepository $couponRestrictionRepository;
    public ProductRepository $productRepository;
    public CategoryRepository $categoryRepository;
    public OrderRepository $orderRepository;
    public UserRepository $userRepository;

    public function __construct(
        CouponRepository $couponRepository,
        CouponRestrictionRepository $couponRestrictionRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        OrderRepository $orderRepository,
        UserRepository $userRepository
    ) {
        $this->couponRepository = $couponRepository;
        $this->couponRestrictionRepository = $couponRestrictionRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
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
    // Lất Tất Cả Dữ Liệu Mã Giảm Giá cùng với các Mối Quan Hệ (orders , users , restriction)
    public function getAllCoupons($perPage)
    {
        return $this->couponRepository
            ->pagination(['*'], $perPage, ['id', 'DESC'], ['orders', 'users', 'restriction']);
    }
    // Hiển Thị Chi Tiết Mã Giảm Giá
    public function getCouponById(Coupon $coupon)
    {
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

            $user_group = request('user_group');

            if ($user_group == UserGroupType::ALL) {
                $allUsers = $this->userRepository->getAll();

                if ($allUsers->isEmpty()) {
                    return [
                        'status' => false,
                        'message' => 'Không tìm thấy người dùng nào .'
                    ];
                }

                $userIds = $allUsers->pluck('id')->toArray();

                $coupon->users()->attach($userIds);
            } else if ($user_group == UserGroupType::NEWBIE) {
                $curentDate = now();
                // giới hạn thời gian
                $newUserThreshold = $curentDate->subDays(10);

                // lấy người dùng mới
                $newUsers = $this->userRepository->getUsersByCreatedDate($newUserThreshold);

                if ($newUsers->isEmpty()) {
                    return [
                        'status' => false,
                        'message' => 'Không tìm thấy người dùng mới trong 10 ngày qua.'
                    ];
                }

                $newUserIds = $newUsers->pluck('id')->toArray();

                $coupon->users()->attach($newUserIds);
            } else {
                $users = $this->userRepository->getUsersByGroupAndLoyaltyPoints($user_group);
                if ($users->isEmpty()) {
                    return [
                        'status' => false,
                        'message' => 'Không tìm thấy người dùng nào .'
                    ];
                }
                $userIds = $users->pluck('id')->toArray();

                $coupon->users()->attach($userIds);
            }

            // Lấy dữ liệu ràng buộc
            $restrictionsData = [
                'min_order_value' => $data['coupon_restrictions']['min_order_value'] ?? 0,
                'max_discount_value' => $data['coupon_restrictions']['max_discount_value'] ?? null,
                'valid_categories' => json_encode(array_map('intval', $data['coupon_restrictions']['valid_categories'])),
                'coupon_id' => $coupon->id
            ];

            $data['is_apply_all'] = request('is_apply_all');

            // Kiểm tra nếu checkbox 'is_apply_all' được chọn
            if (isset($data['is_apply_all']) && $data['is_apply_all'] == 'on') {
                // Lấy tất cả sản phẩm từ bảng products
                $products = $this->showProducts();
                $restrictionsData['valid_products'] = json_encode($products->pluck('id')->toArray());
            } else {
                // Kiểm tra nếu có 'valid_products' trong request, nếu không thì gán giá trị mặc định là mảng rỗng
                $restrictionsData['valid_products'] = isset($data['coupon_restrictions']['valid_products'])
                    ? json_encode(array_map('intval', $data['coupon_restrictions']['valid_products']))
                    : json_encode([]);  // Gán giá trị mặc định là mảng rỗng nếu không có valid_products
            }

            // Lưu ràng buộc nếu có
            if (!empty($restrictionsData)) {
                $this->couponRestrictionRepository->create($restrictionsData);
            }

            DB::commit();
            return [
                'status' => true,
                'message' => 'Thêm Mới Mã Giảm Giá Thành Công'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Error in CouponService::store", [
                'message' => $th->getMessage(),
                'data' => $data
            ]);
            return [
                'status' => false,
                'message' => 'Có Lỗi Xảy Ra , Vui Lòng Thử Lại !!!'
            ];
        }
    }
    // chỉnh sửa mã giảm giá
    public function update() {}
    // Xóa mềm mã giảm giá
    public function deleteCoupon($couponId)
    {
        try {
            $coupon = $this->couponRepository->findByIdWithRelation($couponId, ['restriction', 'orders']);
            if ($coupon->orders()->exists()) {
                return [
                    'status' => false,
                    'message' => 'Mã Này Đang Được Sử Dụng, Không Được Xóa !!!'
                ];
            }
            $this->couponRepository->update($couponId, [
                'is_active' => 0
            ]);

            if ($coupon->restriction) {
                $coupon->restriction->delete();
            };

            $coupon->delete();

            return [
                'status' => true,
                'message' => 'Đưa Vào Thùng Rác Thành Công !!!'
            ];
        } catch (\Throwable $th) {
            Log::error("Error in CouponService::deleteCoupon", [
                'message' => $th->getMessage()
            ]);
            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra , Vui Lòng Thử Lại !!!'
            ];
        }
    }

    // Xóa cứng mã giảm giá
    public function forceDeleteCoupon($couponId)
    {
        DB::beginTransaction();
        try {
            $coupon = $this->couponRepository->findCouponDestroyedWithRelation($couponId, ['restriction', 'orders', 'users']);
            if ($coupon->orders()->exists()) {
                return [
                    'status' => false,
                    'message' => 'Mã Này Đang Được Sử Dụng, Không Được Xóa !!!'
                ];
            }
            if ($coupon->restriction) {
                $coupon->restriction->forceDelete();
            }

            if ($coupon->users()->exists()) {
                $coupon->users()->sync([]);
            }

            $coupon->forceDelete();
            DB::commit();
            return [
                'status' => true,
                'message' => 'Xóa Mã Giảm Giá Thành Công !!!'
            ];
        } catch (\Throwable $th) {
            Log::error("Error in CouponService::ForceDeleteCoupon", [
                'message' => $th->getMessage()
            ]);
            DB::rollBack();
            return [
                'status' => false,
                'message' => 'Có Lỗi Xảy Ra , Vui Lòng Thử Lại !!!'
            ];
        }
    }
    // xóa theo checked (all , selected)
    public function deleteSelectedCoupons($couponIds)
    {
        try {
            // Đảm bảo couponIds là mảng số nguyên
            if (!is_array($couponIds)) {
                $couponIds = explode(',', $couponIds);
            }

            $couponIds = array_map('intval', $couponIds);

            $coupons = $this->couponRepository->findByIdsWithRelation($couponIds, ['restriction', 'orders']);

            $this->couponRepository->updateCouponsStatus($couponIds, [
                'is_active' => 0
            ]);

            foreach ($coupons as $coupon) {

                if ($coupon->restriction) {
                    $coupon->restriction->delete();
                }

                $coupon->delete();
            }

            return [
                'status' => true,
                'message' => 'Đưa Vào Thùng Rác Thành Công !!!'
            ];
        } catch (\Throwable $th) {
            Log::error("Error in CouponService::deleteSelectedCoupon", [
                'message' => $th->getMessage()
            ]);
            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra , Vui Lòng Thử Lại !!!'
            ];
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

            return [
                'status' => true,
                'message' => 'Khôi Phục Mã Giảm Giá Thành Công !!! Mã Giảm Giá - ' . $coupon->title
            ];
        } catch (\Throwable $th) {
            Log::error("Error in CouponService::restoreOneCoupon", [
                'message' => $th->getMessage()
            ]);
            DB::rollBack();
            return [
                'status' => false,
                'message' => 'Có Lỗi Xảy Ra , Vui Lòng Thử Lại !!!'
            ];
        }
    }

    public function restoreSelectedCoupon($couponIds)
    {
        try {

            if (!is_array($couponIds)) {
                $couponIds = explode(',', $couponIds);
            }

            $couponIds = array_map('intval', $couponIds);

            $coupons = $this->couponRepository->findCouponDestroyedByIdsWithRelation($couponIds, ['restriction']);

            $this->couponRepository->updateCouponsStatus($couponIds, ['is_active' => 1]);

            foreach ($coupons as $coupon) {

                if ($coupon->restriction) {
                    $coupon->restriction->restore();
                }

                $coupon->restore();
            }

            return [
                'status' => true,
                'message' => 'Khôi Phục Mã Giảm Giá Thành Công !!!'
            ];
        } catch (\Throwable $th) {
            Log::error("Error in CouponService::restoreOneCoupon", [
                'message' => $th->getMessage()
            ]);
            return [
                'status' => false,
                'message' => 'Có Lỗi Xảy Ra , Vui Lòng Thử Lại !!!'
            ];
        }
    }

    // API - update status 

    public function apiUpdateStatus(string $id, $couponStatus)
    {
        try {

            $this->couponRepository->update($id,['is_active' => $couponStatus]);

            return response()->json([
                'message' => 'Cập Nhật Thành Công !!!',
                'status' => true
            ]);
        } catch (\Throwable $th) {
            Log::error("Error in CouponService::" . __FUNCTION__, [
                'message' => $th->getMessage()
            ]);
            return response()->json([
                'message' => 'Cập Nhật Thất Bại !!!',
                'errors' => $th->getMessage(),
                'status' => false,
            ], 404);
        }
    }
}
