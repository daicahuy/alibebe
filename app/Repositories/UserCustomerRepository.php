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


    public function getUsersActivate(Request $request)
    {
        $limit = 15;
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

        return $query->orderBy('id', 'DESC')
            ->paginate($limit)
            ->withQueryString();
    }

    public function showUser(int $id, array $columns = ['*'])
    {
        return $this->findById(
            $id,
            $columns
        );
    }

    public function getUserLock(Request $request)
    {
        $limit = 15;
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

        return $query->orderBy('id', 'DESC')
            ->paginate($limit)
            ->withQueryString();
    }

    public function countUserLock()
    {
        return $this->model
            ->where('status', UserStatusType::LOCK)
            ->where('role', UserRoleType::CUSTOMER)
            ->count();
    }
}
