<?php

namespace App\Services\Web\Admin;

use ApiBaseController;
use App\Enums\CouponDiscountType;
use App\Enums\NotificationType;
use App\Enums\UserGroupType;
use App\Events\CouponExpired;
use App\Models\Coupon;
use App\Models\Notification;
use App\Models\User;
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
    public function countCouponHidden()
    {
        return $this->couponRepository->countCouponHidden();
    }
    // Lất Tất Cả Dữ Liệu Mã Giảm Giá cùng với các Mối Quan Hệ (orders , users , restriction)
    public function getAllCoupons($perPage, $sortField = 'id', $sortDirection = 'DESC')
    {
        return $this->couponRepository
            ->paginationIsActive(['*'], $perPage, [$sortField, $sortDirection], ['orders', 'users', 'restriction']);
    }
    // Lất Tất Cả Dữ Liệu Mã Giảm Giá cùng với các Mối Quan Hệ (orders , users , restriction)
    public function getAllCouponsByStatus($perPage, $sortField = 'id', $sortDirection = 'DESC')
    {
        return $this->couponRepository
            ->paginationNoIsActive(['*'], $perPage, [$sortField, $sortDirection], ['orders', 'users', 'restriction']);
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
            $userIds = [];

            if ($user_group == UserGroupType::ALL) {
                $allUsers = $this->userRepository->getAll();

                if ($allUsers->isEmpty()) {
                    return [
                        'status' => false,
                        'message' => 'Không tìm thấy người dùng nào.'
                    ];
                }

                $userIds = $allUsers->pluck('id')->toArray();
            } else if ($user_group == UserGroupType::NEWBIE) {
                $currentDate = now();
                // Giới hạn thời gian
                $newUserThreshold = $currentDate->subDays(10);

                // Lấy người dùng mới
                $newUsers = $this->userRepository->getUsersByCreatedDate($newUserThreshold);

                if ($newUsers->isEmpty()) {
                    return [
                        'status' => false,
                        'message' => 'Không tìm thấy người dùng mới trong 10 ngày qua.'
                    ];
                }

                $userIds = $newUsers->pluck('id')->toArray();
            } else {
                $users = $this->userRepository->getUsersByGroupAndLoyaltyPoints($user_group);
                if ($users->isEmpty()) {
                    return [
                        'status' => false,
                        'message' => 'Không tìm thấy người dùng nào.'
                    ];
                }
                $userIds = $users->pluck('id')->toArray();
            }

            // Chuẩn bị mảng user_id với amount = 1
            $userCouponData = array_fill_keys($userIds, ['amount' => 1]);

            // Gán mã giảm giá cho người dùng với amount = 1
            $coupon->users()->attach($userCouponData);

            // Lấy dữ liệu ràng buộc
            $restrictionsData = [
                'min_order_value' => $data['coupon_restrictions']['min_order_value'] ?? 0,
                'max_discount_value' => $data['coupon_restrictions']['max_discount_value'] ?? 0,
                'coupon_id' => $coupon->id
            ];

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
    // xem mã giảm giá
    public function getCouponWithRelations($id, array $relations)
    {
        return $this->couponRepository->findCounPonWithRelations($id, $relations);
    }
    // chỉnh sửa mã giảm giá
    public function update(array $data, $couponId)
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
            $coupon = $this->couponRepository->findByIdWithRelation($couponId, ['restriction', 'orders', 'users']);

            if ($coupon->orders()->exists()) {
                return [
                    'status' => false,
                    'message' => 'Mã Này Đang Được Sử Dụng, Không Được Chỉnh Sửa !!!'
                ];
            }

            $coupon->update($couponData);

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

                $userIds = $newUsers->pluck('id')->toArray();
            } else {
                $users = $this->userRepository->getUsersByGroupAndLoyaltyPoints($user_group);
                if ($users->isEmpty()) {
                    return [
                        'status' => false,
                        'message' => 'Không tìm thấy người dùng nào .'
                    ];
                }
                $userIds = $users->pluck('id')->toArray();
            }
            // Chuẩn bị mảng user_id với amount = 1
            $userCouponData = array_fill_keys($userIds, ['amount' => 1]);

            // Gán mã giảm giá cho người dùng với amount = 1
            $coupon->users()->sync($userCouponData);

            // Lấy dữ liệu ràng buộc
            $restrictionsData = [
                'min_order_value' => $data['coupon_restrictions']['min_order_value'] ?? 0,
                'max_discount_value' => $data['coupon_restrictions']['max_discount_value'] ?? null,
                'coupon_id' => $coupon->id
            ];

            $restrictionId = $coupon->restriction->id;

            // Lưu ràng buộc nếu có
            if (!empty($restrictionsData)) {
                $this->couponRestrictionRepository->update($restrictionId, $restrictionsData);
            }

            DB::commit();
            return [
                'status' => true,
                'message' => 'Thay Đổi Giảm Giá Thành Công'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Error in CouponService::update", [
                'message' => $th->getMessage(),
                'data' => $data
            ]);
            return [
                'status' => false,
                'message' => 'Có Lỗi Xảy Ra , Vui Lòng Thử Lại !!!'
            ];
        }
    }
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
            $coupon = $this->couponRepository->findCouponDestroyedWithRelation($couponId, ['restriction']);


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
                $coupon->users()->sync([], ['amount' => 0]);
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

            // Lấy các coupon với quan hệ restriction và orders
            $coupons = $this->couponRepository->findByIdsWithRelation($couponIds, ['restriction', 'orders']);

            // Mảng lưu trữ các mã coupon đang được sử dụng
            $couponsInUse = [];

            // Kiểm tra nếu bất kỳ coupon nào có đang được sử dụng trong đơn hàng
            foreach ($coupons as $coupon) {
                if ($coupon->orders()->exists()) {
                    // Nếu coupon đang được sử dụng, thêm vào mảng $couponsInUse
                    $couponsInUse[] = $coupon->code; // Giả sử 'code' là thuộc tính chứa mã coupon
                }
            }

            // Nếu có coupon nào đang được sử dụng, trả thông báo lỗi với các mã đó
            if (!empty($couponsInUse)) {
                return [
                    'status' => false,
                    'message' => 'Các mã sau đang được sử dụng và không thể xóa: ' . implode(', ', $couponsInUse)
                ];
            }

            // Cập nhật trạng thái is_active của các coupon
            $this->couponRepository->updateCouponsStatus($couponIds, ['is_active' => 0]);

            // Xóa các restriction và coupon
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
            // Ghi log lỗi nếu có
            Log::error("Error in CouponService::deleteSelectedCoupon", [
                'message' => $th->getMessage()
            ]);
            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra , Vui Lòng Thử Lại !!!'
            ];
        }
    }

    // Xóa vĩnh viễn theo ids
    public function forceDeleteSelectedCoupons($couponIds)
    {
        try {
            // Đảm bảo couponIds là mảng số nguyên
            if (!is_array($couponIds)) {
                $couponIds = explode(',', $couponIds);
            }

            $couponIds = array_map('intval', $couponIds);

            $coupons = $this->couponRepository->findCouponDestroyedByIdsWithRelation($couponIds, ['restriction']);

            foreach ($coupons as $coupon) {

                $coupon->users()->sync([]);

                if ($coupon->restriction) {
                    $coupon->restriction->forceDelete();
                }

                $coupon->forceDelete();
            }

            return [
                'status' => true,
                'message' => 'Đã Xóa Thành Công !!!'
            ];
        } catch (\Throwable $th) {
            Log::error("Error in CouponService::forceDeleteSelectedCoupon", [
                'message' => $th->getMessage()
            ]);
            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra , Vui Lòng Thử Lại !!!'
            ];
        }
    }
    // Lấy tất cả mã giảm giá ở trong thùng rác
    public function getAllCouponsInTrash($perPage, $sortField = 'id', $sortDirection = 'DESC')
    {
        return $this->couponRepository->trash(['*'], $perPage, [$sortField, $sortDirection], ['orders', 'users', 'restriction']);
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
                'message' => 'Khôi Phục Mã Giảm Giá Thành Công !!!'
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
    // khôi phục tất cả mã giảm giá đã xóa
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

    // Tìm Kiếm Mã Giảm GIá
    public function searchCouponWithSeachKey()
    {
        $searchKey = trim(request('searchKey', ''));
        $perPage = request('per_page', 10);

        try {
            // Kiểm tra nếu searchKey rỗng
            if (empty($searchKey)) {
                return [
                    'status' => false,
                    'coupons' => collect(),
                    'message' => 'Vui lòng nhập tiêu đề hoặc mã giảm giá để tìm kiếm!'
                ];
            }

            // Thực hiện tìm kiếm trong repository
            $coupons = $this->couponRepository->searchCoupon($searchKey, $perPage);

            if ($coupons->isEmpty()) {
                return [
                    'status' => false,
                    'coupons' => collect(),
                    'message' => 'Không Tìm Thấy Mã Giảm Giá Có Tiêu Đề / Mã : ' . $searchKey . '!!!'
                ];
            }

            // Đếm số lượng mã giảm giá trong thùng rác
            $couponsIntrash = $this->couponRepository->countCouponInTrash();

            $couponsHidden = $this->couponRepository->countCouponHidden();

            // Trả về kết quả với logic đã xử lý
            return [
                'status' => true,
                'coupons' => $coupons,
                'couponsIntrash' => $couponsIntrash,
                'couponsHidden' => $couponsHidden
            ];
        } catch (\Throwable $th) {
            // Ghi log lỗi nếu có ngoại lệ xảy ra
            Log::error("Error in CouponService::searchCouponWithSeachKey", [
                'message' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);

            // Trả về thông báo lỗi
            return [
                'status' => false,
                'coupons' => collect(),
                'message' => 'Có lỗi xảy ra khi tìm kiếm, vui lòng thử lại sau.'
            ];
        }
    }

    // tự động xóa mã guamr giá trong thùng rác
    public function deleteOldTrashedCoupon($days = 7)
    {
        try {
            // Gọi repository để xóa các coupon trong thùng rác > $days ngày
            $this->couponRepository->forceDeleteOlderThanDays($days);

            // Trả về phản hồi khi thành công
            return [
                'message' => 'Xóa thành công các mã giảm giá cũ!',
                'status' => true
            ];
        } catch (\Throwable $th) {
            // Ghi log lỗi khi có ngoại lệ
            Log::error("Lỗi khi xóa các mã giảm giá trong thùng rác", [
                'days' => $days,
                'error' => $th->getMessage()
            ]);

            // Trả về phản hồi khi có lỗi
            return [
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!',
                'status' => false
            ];
        }
    }

    // chỉnh sửa các mã giảm giá đã được người dùng sử dùng
    // ( chỉ dùng cho các mã mà người dùng đã dùng => chỉnh sửa ngày , giới hạn)
    public function updateUsageLimitOrEndDate(array $data, string $id)
    {
        try {
            $coupon = $this->couponRepository->findById($id);
            if (!$coupon) {
                return [
                    'message' => 'Không tìm thấy mã giảm giá!',
                    'status' => false
                ];
            }

            $endDate = $data['end_date'] ?? null;
            $usageLimit = $data['usage_limit'] ?? null;

            // Tạo mảng cập nhật tùy vào dữ liệu thực có
            $updateData = [];

            // Nếu end_date được gửi và khác null => cập nhật
            if (!is_null($endDate)) {
                // Nếu nhập lại dữ liệu cũ, báo lỗi
                if ($coupon->end_date == $endDate) {
                    return [
                        'message' => 'Dữ liệu ngày kết thúc nhập vào giống với dữ liệu cũ.',
                        'status' => false
                    ];
                }
                $updateData['end_date'] = $endDate;
            }

            // Nếu usage_limit được gửi và khác null => cập nhật
            if (!is_null($usageLimit)) {
                if ($usageLimit < $coupon->usage_count) {
                    return [
                        'message' => "Giới hạn sử dụng mới ($usageLimit) không được nhỏ hơn số lượt đã dùng ({$coupon->usage_count}).",
                        'status' => false
                    ];
                }
                // Nếu nhập lại dữ liệu cũ, báo lỗi
                if ($coupon->usage_limit == $usageLimit) {
                    return [
                        'message' => 'Dữ liệu nhập vào giống với dữ liệu cũ.',
                        'status' => false
                    ];
                }
                $updateData['usage_limit'] = $usageLimit;
            }

            // Nếu không có trường nào được gửi => không làm gì
            if (empty($updateData)) {
                return [
                    'message' => 'Không có thay đổi nào được gửi lên.',
                    'status' => false
                ];
            }

            // Thực hiện cập nhật mã giảm giá
            $coupon->update($updateData);

            // Sau khi cập nhật mã giảm giá, cập nhật lại pivot table coupon_user
            // Cho những user có amount = 0 thì cập nhật lại thành 1 (không ảnh hưởng đến user khác)
            DB::table('coupon_users')
                ->where('coupon_id', $coupon->id)
                ->where('amount', 0)
                ->update(['amount' => 1]);

            return [
                'message' => 'Đặt Lại Thành Công!',
                'status' => true
            ];
        } catch (\Throwable $th) {
            Log::error("Lỗi cập nhật mã giảm giá: " . $th->getMessage());
            return [
                'message' => 'Có Lỗi Xảy Ra, Vui Lòng Thử Lại!!!',
                'errors' => $th->getMessage(),
                'status' => false
            ];
        }
    }


    // API - update status 

    public function apiUpdateStatus(string $id, $couponStatus)
    {
        try {
            $this->couponRepository->update($id, ['is_active' => $couponStatus]);
            $admins = User::where('role', 2)
                ->orWhere('role', 1)
                ->get();

            $coupon = $this->couponRepository->findById($id);

            $message = $couponStatus
                ? "Mã giảm giá {$coupon->code} đã được kích hoạt."
                : "Mã giảm giá {$coupon->code} đã bị tắt.";

            // Tạo thông báo cho mỗi admin
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id'   => $admin->id,
                    'message'   => $message,
                    'read'      => false,
                    'type'      => NotificationType::Coupon, // hoặc giá trị phù hợp
                    'coupon_id' => $coupon->id
                ]);
            }

            event(new CouponExpired($coupon, $message));

            return [
                'message' => 'Cập Nhật Thành Công !!!',
                'status' => true
            ];
        } catch (\Throwable $th) {
            Log::error("Lỗi cập nhật trạng thái mã giảm giá", [
                'coupon_id' => $id,
                'error' => $th->getMessage()
            ]);

            return [
                'message' => 'Có Lỗi Xảy Ra , Vui Lòng Thử Lại !!!',
                'errors' => $th->getMessage(),
                'status' => false
            ];
        }
    }
}
