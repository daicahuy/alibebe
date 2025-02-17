<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AccountRepository extends BaseRepository
{
    public function getModel()
    {
        return User::class;
    }

}
