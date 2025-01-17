<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\UserStatusType;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\Web\Admin\UserEmployeeService;
use Illuminate\Http\Request;

class UserEmployeeController extends Controller
{
    protected UserEmployeeService $userService;

    public function __construct(UserEmployeeService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {

        $ListUsers = $this->userService->getUsersActivate($request);
        $totalUserLock = $this->userService->countUserLock();
        return view('admin.pages.userEmployee.list', compact('ListUsers','totalUserLock'));
    }

    public function lock(Request $request)
    {

        $UsersLock = $this->userService->getUsersLock($request);
        return view('admin.pages.userEmployee.lock', compact('UsersLock'));
    }

    public function show(User $user)
    {
        $roles = [
            0 => __('form.user_customer'),
            1 => __('form.user_employee'),
            2 => __('form.user_admin'),
        ];
        $ShowUser = $this->userService->ShowUser($user->id, ['*']);

        return view('admin.pages.userEmployee.show', [
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
        return view('admin.pages.userEmployee.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
    
        if (!empty($data)) {
            $isCreated = $this->userService->createUser($data);
    
            if ($isCreated) {
                return redirect()->route('admin.users.employee.index')->with('success', 'Thêm mới nhân viên thành công.');
            } else {
                return redirect()->back()->with('error', 'Đã xảy ra lỗi khi thêm mới nhân viên.');
            }
        } else {
            return redirect()->back()->with('error', 'Dữ liệu không hợp lệ. Vui lòng kiểm tra lại.');
        }
    }
    
    public function edit(User $user)
    {
        $roles = [
            0 => __('form.user_customer'),
            1 => __('form.user_employee'),
        ];

        $EditUser = $this->userService->ShowUser($user->id, ['*']);
        return view('admin.pages.userEmployee.edit', compact('EditUser', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        //    dd($request->all());
        if (!empty($data)) {
            $this->userService->UpdateUser($user->id, $data);

            return redirect()->back()->with('success', 'Cập nhật thông tin nhân viên thành công.');
        } else {
            return redirect()->back()->with('error', 'Cập nhật thông tin nhân viên thất bại. Vui lòng kiểm tra và thử lại.');
        }
    }

    public function lockUser(User $user)
    {
        $lock = $this->userService->ShowUser($user->id, ['*']);

        if ($lock->status == UserStatusType::ACTIVE) {

            $this->userService->UpdateUser($user->id, ['status' => UserStatusType::LOCK]);
            return redirect()->back()->with('success', 'Đã khóa thành công !');

        } else if ($lock->status == UserStatusType::LOCK) {

            $this->userService->UpdateUser($user->id, ['status' => UserStatusType::ACTIVE]);
            return redirect()->back()->with('success', 'Đã mở khóa thành công !');

        }else{
            return redirect()->back()->with('error', 'Thất bại xin kiểm tra lại');
        }
    }
}
