<?php
namespace App\Repositories;

use App\Models\User;
use Hash;


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

    public function changePassword($email, $password)
    {
        return User::where('email', $email)->update([
            'password' => Hash::make($password),
        ]);
    }




}




?>