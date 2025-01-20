<?php

namespace App\Repositories;

use App\Enums\UserGroupType;
use App\Models\User;

class UserRepository extends BaseRepository
{

    public function getModel()
    {
        return User::class;
    }

    public function getUsersByCreatedDate($date)
    {
        return $this->model->where('created_at', '>=', $date)->get();
    }
    public function getUsersByGroupAndLoyaltyPoints($userGroup)
    {
        $query = $this->model;

        // Định nghĩa các giới hạn loyalty_points
        $loyaltyRanges = [
            1 => [0, 100], // newbie
            2 => [101, 200], // iron
            3 => [201, 400], // bronze
            4 => [301, 400], // silver
            5 => [401, 500], // gold
            6 => [501, 600], // platinum
            7 => [700, 1000], // Từ 700 trở lên diamond
        ];

        // Kiểm tra xem có nhóm loyalty_points tương ứng không
        if (array_key_exists($userGroup, $loyaltyRanges)) {
            return $query->whereBetween('loyalty_points', $loyaltyRanges[$userGroup])->get();
        }

        return collect(); // Trả về collection rỗng nếu không có nhóm phù hợp
    }
}
