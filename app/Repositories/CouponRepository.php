<?php

namespace App\Repositories;

use App\Enums\UserGroupType;
use App\Models\Coupon;

class CouponRepository extends BaseRepository
{
    public function getModel()
    {
        return Coupon::class;
    }

    // tìm kiểm tên hoặc mô tả mã giảm giá 
    public function searchCoupon($searchKey, $perPage)
    {
        $query = $this->model
            ->where("code", "LIKE", "%$searchKey%")
            ->orWhere("title", "LIKE", "%$searchKey%");
    
        // Phân trang với số bản ghi trên mỗi trang
        return $query->paginate($perPage);
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
    public function trash()
    {
        return $this->model->onlyTrashed()->latest('id')->paginate(10);
    }
    // đếm số lượng mã giảm giá trong thùng rác
    public function countCouponInTrash()
    {
        return $this->model->onlyTrashed()->count();
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
}
