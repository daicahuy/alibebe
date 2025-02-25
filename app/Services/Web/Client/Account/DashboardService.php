<?php
namespace App\Services\Web\Client\Account;

use App\Repositories\UserRepository;

class DashboardService 
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function index() {
    }
}