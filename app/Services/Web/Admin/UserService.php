<?php

namespace App\Services\Web\Admin;

use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsersActivate(int $perPage, array $columns = ['*'], array $relations = [])
    {
        return $this->userRepository->getUsersActivate($perPage, $columns, $relations);
    }
    public function showUser(int $id, array $columns = ['*'])
    {
        return $this->userRepository->showUser($id, $columns);
    }
    public function getUsersLock(int $perPage, array $columns = ['*'], array $relations = [])
    {
        return $this->userRepository->getUserLock($perPage, $columns, $relations);
    }
    public function createUser($data)
    {
        return $this->userRepository->createUser($data);
    }

    public function UpdateUser($id, $data)
    {
        return $this->userRepository->update($id, $data);
    }
}
