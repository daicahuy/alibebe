<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\Web\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $perPage = 15;
        $ListUsers = $this->userService->getUsersActivate($perPage, ['*']);

        return view('admin.pages.users.list', compact('ListUsers'));
    }

    public function lock()
    {
        $perPage = 15;
        $UsersLock = $this->userService->getUsersLock($perPage, ['*']);
        return view('admin.pages.users.lock', compact('UsersLock'));
    }

    public function show(User $user)
    {
        $roles = [
            0 => __('form.user_customer'),
            1 => __('form.user_employee'),
            2 => __('form.user_admin'),
        ];
        $ShowUser = $this->userService->ShowUser($user->id, ['*']);

        return view('admin.pages.users.show', [
            'ShowUser' => $ShowUser,
            'roleLabel' => $roles[$user->role],
        ]);
    }

    public function create()
    {
        $roles = [
            0 => __('form.user_customer'),
            1 => __('form.user_employee'),
        ];
        return view('admin.pages.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        // dd($request->all());
        try {
            $this->userService->createUser($data);
            return back()
                ->route('admin.pages.users.list')
                ->with('success', true);
        } catch (\Throwable $th) {
            return back()
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    public function edit(User $user)
    {
        $roles = [
            0 => __('form.user_customer'),
            1 => __('form.user_employee'),
        ];

        $EditUser = $this->userService->ShowUser($user->id, ['*']);
        return view('admin.pages.users.edit', compact('EditUser', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
    //    dd($request->all());
        try {
            $this->userService->UpdateUser($user->id, $data);
            redirect()
                ->with('success', true);
        } catch (\Throwable $th) {
            return back()
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }
}
