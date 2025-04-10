<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\UserStatusType;
use App\Events\UserLocked;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LockUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Mail\UserLockedMail;
use App\Models\User;
use App\Services\Web\Admin\UserEmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

    public function detail(Request $request, User $user)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        if (!$startDate) {
            $startDate = now()->startOfDay()->toDateString();
        }
        if (!$endDate) {
            $endDate = now()->endOfDay()->toDateString();
        }
        $filterStatus = $request->input('status');
        $data = $this->userService->detail(
            $user->id,
            $startDate,
            $endDate
            ,
            $filterStatus
        );
        // dd($data);
        return view('admin.pages.user_employee.detail', compact(
            'data'
        ));
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


    public function lockUser(Request $request, User $user)
    {
        // Lấy thông tin người dùng
        $lock = $this->userService->showUserEmployee($user->id, ['*']);
    
        // Kiểm tra trạng thái hiện tại của người dùng
        if ($lock->status == UserStatusType::ACTIVE) {
            // Lấy lý do khóa từ request
            $reason = $request->input('reason_lock');
    
            // Cập nhật trạng thái thành "LOCK" và lưu lý do khóa
            $this->userService->UpdateUserEmployee($user->id, [
                'status' => UserStatusType::LOCK,
                'reason_lock' => $reason,
            ]);
    
            // Thêm log để kiểm tra
            Log::info('Locking user with ID: ' . $user->id . ' with reason: ' . $reason);
    
            // Phát sự kiện UserLocked
            event(new UserLocked($user->id, $reason));
    
            // Gửi email thông báo
            if ($lock->email) {
                Mail::to($lock->email)->send(new UserLockedMail($lock, $reason));
            }
    
            Log::info('UserLocked event broadcasted and email sent for user ID: ' . $user->id);
    
            return redirect()->back()->with('success', 'Đã khóa thành công!');
        } elseif ($lock->status == UserStatusType::LOCK) {
            // Cập nhật trạng thái thành "ACTIVE" và xóa lý do khóa
            $this->userService->UpdateUserEmployee($user->id, [
                'status' => UserStatusType::ACTIVE,
                'reason_lock' => null,
            ]);
    
            return redirect()->back()->with('success', 'Đã mở khóa thành công!');
        } else {
            return redirect()->back()->with('error', 'Thất bại, xin kiểm tra lại.');
        }
    }

    public function lockMultipleUsers(LockUserRequest $request)
    {
        // Lấy danh sách user_ids và lý do từ request
        $validated = $request->validated();
        $userIds = $validated['user_ids'];
        $reason = $validated['reason_lock']; // Lý do khóa
    
        // Cập nhật trạng thái của tất cả người dùng thành "LOCK" và lưu lý do khóa
        $this->userService->UpdateUserEmployee($userIds, [
            'status' => UserStatusType::LOCK,
            'reason_lock' => $reason,
        ]);
    
        // Phát sự kiện UserLocked và gửi email cho từng người dùng
        foreach ($userIds as $userId) {
            // Lấy thông tin người dùng
            $user = $this->userService->UpdateUserEmployee($userId, ['email', 'fullname']);
    
            // Phát sự kiện UserLocked
            event(new UserLocked($userId, $reason));
    
            // Gửi email thông báo
            if ($user && $user->email) {
                Mail::to($user->email)->send(new UserLockedMail($user, $reason));
                Log::info('Email sent to user ID: ' . $userId . ' with reason: ' . $reason);
            }
        }
    
        return response()->json([
            'message' => 'Đã khóa thành công!'
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
