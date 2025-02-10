<?php

namespace App\Repositories;

use App\Enums\UserGroupType;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CouponRepository extends BaseRepository
{
    public function getModel()
    {
        return Coupon::class;
    }
    // lấy tất cả sản phẩm chỉ có is_active
    public function paginationIsActive(
        array $columns = ['*'],
        int $perPage = 15,
        array $orderBy = ['id', 'DESC'],
        array $relations = [],
    )
    {
        return $this->model->select($columns)
            ->with($relations)
            ->where('is_active',1)
            ->orderBy($orderBy[0], $orderBy[1])
            ->paginate($perPage)
            ->withQueryString();
    }
    // Lấy Sản Phẩm không hoạt động
    public function paginationNoIsActive(
        array $columns = ['*'],
        int $perPage = 15,
        array $orderBy = ['id', 'DESC'],
        array $relations = [],
    )
    {
        return $this->model->select($columns)
            ->with($relations)
            ->where('is_active',0)
            ->orderBy($orderBy[0], $orderBy[1])
            ->paginate($perPage)
            ->withQueryString();
    }
    // tìm kiểm tên hoặc mô tả mã giảm giá 
    public function searchCoupon($searchKey, $perPage)
    {
        $query = $this->model
            ->where("code", "LIKE", "%$searchKey%")
            ->orWhere("title", "LIKE", "%$searchKey%");

        // Phân trang với số bản ghi trên mỗi trang
        return $query->paginate($perPage)->withQueryString();
    }

    // tìm kiếm 1 với quan hệ
    public function findByIdWithRelation($id, array $relations)
    {
        return $this->model->with($relations)->find($id);
    }
    // tìm kiếm nhiều với quan hệ
    public function findByIdsWithRelation($ids, array $relations)
    {
        return $this->model
            ->with($relations)
            ->whereIn('id', $ids)
            ->get();
    }
    // lấy danh sách thùng rác
    public function trash(
        array $columns = ['*'],
        int $perPage = 15,
        array $orderBy = ['id', 'DESC'],
        array $relations = [],
    ) {
        return $this->model
            ->onlyTrashed()
            ->select($columns)->with($relations)
            ->orderBy($orderBy[0], $orderBy[1])
            ->paginate($perPage)
            ->withQueryString();
    }
    // đếm số lượng mã giảm giá trong thùng rác
    public function countCouponInTrash()
    {
        return $this->model->onlyTrashed()->count();
    }
    // đếm số lượng mã giảm giá ẩn
    public function countCouponHidden() {
        return $this->model->where('is_active',0)->count();
    }
    // tìm mã giảm giá đã xóa cùng với mối quan hệ
    public function findCouponDestroyedWithRelation(string $id, array $relations)
    {
        // Lấy coupon đã bị xóa mềm
        $coupon = $this->model->onlyTrashed()->findOrFail($id);

        // Áp dụng onlyTrashed cho từng quan hệ được truyền vào
        foreach ($relations as $relation) {
            $coupon->load([$relation => function ($query) {
                $query->onlyTrashed(); // Áp dụng điều kiện onlyTrashed cho quan hệ
            }]);
        }

        return $coupon;
    }
    // tìm nhiều mã giảm giá đã được xóa với mối quan hệ
    public function findCouponDestroyedByIdsWithRelation($ids, array $relations)
    {
        $coupon = $this->model->withTrashed()->whereIn('id', $ids)->get();

        // Áp dụng onlyTrashed cho từng quan hệ được truyền vào
        foreach ($relations as $relation) {
            $coupon->load([$relation => function ($query) {
                $query->onlyTrashed(); // Áp dụng điều kiện onlyTrashed cho quan hệ
            }]);
        }

        return $coupon;
    }

    // thay đổi trạng thái nhiều mã giảm giá
    public function updateCouponsStatus($ids, array $data)
    {
        return $this->model->withTrashed()->whereIn('id', $ids)->update($data);
    }

    // lấy các coupon nằm trong thùng rác > 7 ngày
    public function getCouponTrashedOlderThanDays($days)
    {
        return $this->model->onlyTrashed()
            ->with(['users', 'restriction']) // eager load các quan hệ
            ->where('deleted_at', '<=', now()->subDays($days))
            ->get();
    }

    // Xem Chi Tiết Của Coupon
    public function findCounPonWithRelations($id, array $relations) {
        // Tìm coupon theo ID và eager load các quan hệ được truyền vào
        $coupon = $this->model->with($relations)
            ->findOrFail($id); // Trả về coupon hoặc lỗi nếu không tìm thấy

        // Chuyển valid_categories từ JSON thành mảng ID
        $validCategoryIds = json_decode($coupon->restriction->valid_categories, true);
        $validProductIds = json_decode($coupon->restriction->valid_products, true);

        // Lấy danh sách các danh mục từ các ID
        $categories = Category::whereIn('id', $validCategoryIds)->get(['id', 'name']);

        // Lấy danh sách các sản phẩm từ các ID
        $products = Product::whereIn('id', $validProductIds)->get(['id', 'name']);

        // Gán danh mục và sản phẩm vào coupon để dễ dàng truy cập trong view
        $coupon->categories = $categories;
        $coupon->products = $products;
        
        return $coupon;
    }
    
    // xóa các coupon trong thùng rác > 7 ngày
    public function forceDeleteOlderThanDays($days) {
        $coupons = $this->getCouponTrashedOlderThanDays($days);
        Log::info("Coupons : " . $coupons);
        $coupons->each(function  ($coupon) {
            $coupon->forceDelete();
        });
    }
}
