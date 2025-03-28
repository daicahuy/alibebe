<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\UserStatusType;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LockUserRequest;
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
        $limit = $request->input('limit', 15);
        $ListUsers = $this->userService->getUserEmployee($request, $limit);
        $totalUserLock = $this->userService->countUserEmployeeLock();
        return view('admin.pages.user_employee.list', compact('ListUsers', 'totalUserLock', 'limit'));
    }

    public function detail(Request $request)
    {
        
        return view('admin.pages.user_employee.detail');
    }

    public function lock(Request $request)
    {
        $limit = $request->input('limit', 15);
        $UsersLock = $this->userService->getUserEmployeeLock($request, $limit);
        return view('admin.pages.user_employee.lock', compact('UsersLock', 'limit'));
    }

    public function show(User $user)
    {
        $roles = [
            0 => __('form.user_customer'),
            1 => __('form.user_employee'),
            2 => __('form.user_admin'),
        ];
        $ShowUser = $this->userService->showUserEmployee($user->id, ['*']);

        return view('admin.pages.user_employee.show', [
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
        return view('admin.pages.user_employee.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        if (!empty($data)) {
            $isCreated = $this->userService->createUserEmployee($data);

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

        $EditUser = $this->userService->showUserEmployee($user->id, ['*']);
        return view('admin.pages.user_employee.edit', compact('EditUser', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        //    dd($request->all());
        if (!empty($data)) {
            $this->userService->UpdateUserEmployee($user->id, $data);

            return redirect()->back()->with('success', 'Cập nhật thông tin nhân viên thành công.');
        } else {
            return redirect()->back()->with('error', 'Cập nhật thông tin nhân viên thất bại. Vui lòng kiểm tra và thử lại.');
        }
    }

    public function lockUser(User $user)
    {
        $lock = $this->userService->showUserEmployee($user->id, ['*']);

        if ($lock->status == UserStatusType::ACTIVE) {

            $this->userService->UpdateUserEmployee($user->id, ['status' => UserStatusType::LOCK]);
            return redirect()->back()->with('success', 'Đã khóa thành công !');
        } else if ($lock->status == UserStatusType::LOCK) {

            $this->userService->UpdateUserEmployee($user->id, ['status' => UserStatusType::ACTIVE]);
            return redirect()->back()->with('success', 'Đã mở khóa thành công !');
        } else {
            return redirect()->back()->with('error', 'Thất bại xin kiểm tra lại');
        }
    }

    public function lockMultipleUsers(LockUserRequest $request)
    {
        $validated = $request->validated();

        $this->userService->UpdateUserEmployee($validated['user_ids'], ['status' => UserStatusType::LOCK]);

        return response()->json([
            'message' => ('Đã khóa thành công')
        ]);
    }

    public function unLockMultipleUsers(LockUserRequest $request)
    {
        $validated = $request->validated();

        $this->userService->UpdateUserEmployee($validated['user_ids'], ['status' => UserStatusType::ACTIVE]);

        return response()->json([
            'message' => ('Đã mở khóa thành công !')
        ]);
    }

    public function updateStatus(Request $request)
    {
        $userId = $request->id;
        $status = $request->status;

        $data = ['status' => $status];

        $result = $this->userService->UpdateUserEmployee($userId, $data);

        return response()->json([
            'success' => $result ? true : false,
            'message' => $result ? 'Cập nhật trạng thái thành công' : 'Không thể cập nhật trạng thái'
        ]);
    }
}
