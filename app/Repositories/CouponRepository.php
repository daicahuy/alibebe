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

    public function findByIdWithRelation($id, array $relations)
    {
        return $this->model->with($relations)->find($id);
    }

    public function findByIdsWithRelation($ids, array $relations)
    {
        // ép buộc chuỗi id thành mảng loại bỏ dấu ,
        if(!is_array($ids)) {
            $ids = explode(',',$ids);
        }
        return $this->model
            ->with($relations)
            ->whereIn('id', $ids)
            ->get();
    }

    public function trash()
    {
        return $this->model->onlyTrashed()->paginate(10);
    }

    public function countCouponInTrash()
    {
        return $this->model->onlyTrashed()->count();
    }

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
}
