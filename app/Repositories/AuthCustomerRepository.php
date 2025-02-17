<?php
namespace App\Repositories;

use App\Models\User;


class AuthCustomerRepository extends BaseRepository
{

    public function getModel()
    {
        return User::class;
    }

    public function registerCustomer($data)
    {
        return User::query()->create($data);
    }




}




?>