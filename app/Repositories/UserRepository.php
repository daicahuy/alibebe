<?php

namespace App\Repositories;

use App\Enums\UserRoleType;
use App\Enums\UserStatusType;
use App\Models\User;
use Illuminate\Http\Request;


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
            1 => [0, 100],       // Newbie (0 - 100 điểm, tương ứng 0 - 10 lần mua hàng)
            2 => [101, 300],     // Iron (101 - 300 điểm, tương ứng 11 - 30 lần mua hàng)
            3 => [301, 500],     // Bronze (301 - 500 điểm, tương ứng 31 - 50 lần mua hàng)
            4 => [501, 700],     // Silver (501 - 700 điểm, tương ứng 51 - 70 lần mua hàng)
            5 => [701, 850],     // Gold (701 - 850 điểm, tương ứng 71 - 85 lần mua hàng)
            6 => [851, 999],     // Platinum (851 - 999 điểm, tương ứng 86 - 99 lần mua hàng)
            7 => [1000, PHP_INT_MAX] // Diamond (từ 1000 điểm trở lên, không giới hạn tối đa)
        ];

        // Kiểm tra xem có nhóm loyalty_points tương ứng không
        if (array_key_exists($userGroup, $loyaltyRanges)) {
            return $query->whereBetween('loyalty_points', $loyaltyRanges[$userGroup])->get();
        }

        return collect(); // Trả về collection rỗng nếu không có nhóm phù hợp
    }

    public function getUserRank($loyaltyPoints)
    {
        $ranks = [
            'Newbie' => [0, 100],
            'Iron' => [101, 300],
            'Bronze' => [301, 500],
            'Silver' => [501, 700],
            'Gold' => [701, 850],
            'Platinum' => [851, 999],
            'Diamond' => [1000, PHP_INT_MAX],
        ];

        foreach ($ranks as $rank => [$min, $max]) {
            if ($loyaltyPoints >= $min && $loyaltyPoints <= $max) {
                return $rank;
            }
        }

        return 'Newbie';
    }

    public function getUserGroupId(int $loyaltyPoints): int
    {
        $loyaltyRanges = [
            1 => [0, 100],
            2 => [101, 300],
            3 => [301, 500],
            4 => [501, 700],
            5 => [701, 850],
            6 => [851, 999],
            7 => [1000, PHP_INT_MAX]
        ];

        foreach ($loyaltyRanges as $group => [$min, $max]) {
            if ($loyaltyPoints >= $min && $loyaltyPoints <= $max) {
                return $group;
            }
        }

        return 1; // Mặc định Newbie
    }

    public function getUserCustomer(Request $request, $limit)
    {
        $query = $this->model
            ->where('status', UserStatusType::ACTIVE)
            ->where('role', UserRoleType::CUSTOMER);

        if ($request->filled('_keyword')) {
            $keyword = $request->input('_keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('fullname', 'LIKE', "%$keyword%")
                    ->orWhere('email', 'LIKE', "%$keyword%")
                    ->orWhere('phone_number', 'LIKE', "%$keyword%");
            });
        }

        // Lấy giá trị sắp xếp từ request
        $sortField = $request->input('sort_field');
        $sortOrder = $request->input('sort_order', 'desc'); // Mặc định giảm dần

        if ($sortField === 'fullname') {
            $query->orderBy('fullname', $sortOrder);
        } else {
            $query->orderBy('id', 'DESC'); // Quay về mặc định
        }

        return $query->paginate($limit)->withQueryString();
    }



    public function showUserCustomer(int $id, array $columns = ['*'])
    {
        return $this->findById(
            $id,
            $columns
        );
    }

    public function getUserCustomerLock(Request $request, $limit)
    {
        $query = $this->model
            ->where('status', UserStatusType::INACTIVE)
            ->where('role', UserRoleType::CUSTOMER);

        if ($request->filled('_keyword')) {
            $keyword = $request->input('_keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('fullname', 'LIKE', "%$keyword%")
                    ->orWhere('email', 'LIKE', "%$keyword%")
                    ->orWhere('phone_number', 'LIKE', "%$keyword%");
            });
        }

        $sortField = $request->input('sort_field');
        $sortOrder = $request->input('sort_order', 'desc'); // Mặc định giảm dần

        if ($sortField === 'fullname') {
            $query->orderBy('fullname', $sortOrder);
        } else {
            $query->orderBy('id', 'DESC'); // Quay về mặc định
        }

        return $query->paginate($limit)->withQueryString();
    }

    public function countUserCustomerLock()
    {
        return $this->model
            ->where('status', UserStatusType::INACTIVE)
            ->where('role', UserRoleType::CUSTOMER)
            ->count();
    }

    public function getUserEmployee(Request $request, $limit)
    {
        $query = $this->model
            ->where('status', UserStatusType::ACTIVE)
            ->where('role', UserRoleType::EMPLOYEE);

        if ($request->filled('_keyword')) {
            $keyword = $request->input('_keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('fullname', 'LIKE', "%$keyword%")
                    ->orWhere('email', 'LIKE', "%$keyword%")
                    ->orWhere('phone_number', 'LIKE', "%$keyword%");
            });
        }

        $sortField = $request->input('sort_field');
        $sortOrder = $request->input('sort_order', 'desc'); // Mặc định giảm dần

        if ($sortField === 'fullname') {
            $query->orderBy('fullname', $sortOrder);
        } else {
            $query->orderBy('id', 'DESC'); // Quay về mặc định
        }

        return $query->paginate($limit)->withQueryString();
    }


    public function countUserEmployeeLock()
    {
        return $this->model
            ->where('status', UserStatusType::INACTIVE)
            ->where('role', UserRoleType::EMPLOYEE)
            ->count();
    }

    public function showUserEmployee(int $id, array $columns = ['*'])
    {
        return $this->findById(
            $id,
            $columns
        );
    }

    public function getUserEmployeeLock(Request $request, $limit)
    {

        $query = $this->model
            ->where('status', UserStatusType::INACTIVE)
            ->where('role', UserRoleType::EMPLOYEE);

        if ($request->filled('_keyword')) {
            $keyword = $request->input('_keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('fullname', 'LIKE', "%$keyword%")
                    ->orWhere('email', 'LIKE', "%$keyword%")
                    ->orWhere('phone_number', 'LIKE', "%$keyword%");
            });
        }

        $sortField = $request->input('sort_field');
        $sortOrder = $request->input('sort_order', 'desc'); // Mặc định giảm dần

        if ($sortField === 'fullname') {
            $query->orderBy('fullname', $sortOrder);
        } else {
            $query->orderBy('id', 'DESC'); // Quay về mặc định
        }

        return $query->paginate($limit)->withQueryString();
    }

    public function listByIds(array $ids, $status)
    {
        return $this->model->whereIn('id', $ids)->update(['status' => $status]);
    }

    // customer detail
    public function getUserAndAddress($userId, $columns = ['*'])
    {
        return $this->model->with([
            'addresses' => function ($query) {
                $query->select('id', 'user_id', 'address', 'is_default');
            }
        ])->findOrFail($userId, $columns);
    }
    public function getUserById($userId)
    {
        $user = $this->model->findorFail($userId);
        // return $user->where('id', $userId)->first();
        return $user;
    }

    public function getTimeActivity($userId)
    {
        $latestActivity = $this->model->where('id', $userId)->latest()->first();
        return $latestActivity;
    }
}
