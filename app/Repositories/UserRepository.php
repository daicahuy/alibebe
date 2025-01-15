<?php

namespace App\Repositories;

use App\Enums\UserStatusType;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class UserRepository extends BaseRepository
{
    public function getModel()
    {
        return User::class;
    }


    public function getUsersActivate(int $perPage, array $columns = ['*'], array $relations = [])
    {
        return $this->model
            ->where('status', UserStatusType::ACTIVE)
            ->select($columns)
            ->with($relations)
            ->orderBy('id', 'DESC')
            ->paginate($perPage)
            ->withQueryString();
    }
    public function showUser(int $id, array $columns = ['*'])
    {
        return $this->findById(
            $id,
            $columns
        );
    }

    public function getUserLock(int $perPage, array $columns = ['*'], array $relations = [])
    {
        return $this->model
            ->where('status', UserStatusType::LOCK)
            ->select($columns)
            ->with($relations)
            ->orderBy('id', 'DESC')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function createUser($data)
    {
        try {
            return $this->create($data);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    public function UpdateUser($id, $data)
    {
        try {
            return $this->update($id, $data);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }
}
