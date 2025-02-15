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
            ->where('status', UserStatusType::LOCK)
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
            ->where('status', UserStatusType::LOCK)
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
            ->where('status', UserStatusType::LOCK)
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
            ->where('status', UserStatusType::LOCK)
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

}
