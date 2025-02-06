<?php

namespace App\Repositories;

use App\Enums\UserRoleType;
use App\Enums\UserStatusType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class UserCustomerRepository extends BaseRepository
{
    public function getModel()
    {
        return User::class;
    }


    public function getUsersActivate(Request $request, $limit)
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



    public function showUser(int $id, array $columns = ['*'])
    {
        return $this->findById(
            $id,
            $columns
        );
    }

    public function getUserLock(Request $request, $limit)
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

    public function countUserLock()
    {
        return $this->model
            ->where('status', UserStatusType::LOCK)
            ->where('role', UserRoleType::CUSTOMER)
            ->count();
    }
    public function listByIds(array $ids, $status)
    {
        return $this->model->whereIn('id', $ids)->update(['status' => $status]);
    }
}
