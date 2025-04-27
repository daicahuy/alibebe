<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\UserStatusType;
use App\Events\UserLocked;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LockUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Jobs\SendUserLockedEmail;
use App\Mail\UserLockedMail;
use App\Models\User;
use App\Services\OrderCancelService;
use App\Services\Web\Admin\UserEmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserEmployeeController extends Controller
{
    protected UserEmployeeService $userService;

    protected OrderCancelService $OrderCancelService;

    public function __construct(UserEmployeeService $userService, OrderCancelService $OrderCancelService)
    {
        $this->userService = $userService;

        $this->OrderCancelService = $OrderCancelService;
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
        $request->validate([
            'startDate' => 'nullable|date|before_or_equal:today', // Ngày bắt đầu: có thể rỗng, là ngày, không sau ngày hiện tại
            'endDate' => 'nullable|date|after_or_equal:startDate|before_or_equal:today',
        ], [
            'startDate.before_or_equal' => 'Ngày bắt đầu không được chọn ngày trong tương lai.',
            'endDate.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng Ngày bắt đầu.',
            'endDate.before_or_equal' => 'Ngày kết thúc không được chọn ngày trong tương lai.',
        ]);

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
            $endDate,
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
        // Lấy thông tin người dùng (chúng ta đã có $user instance rồi)
        $lock = $user; // Không cần gọi lại userService để lấy

        // Kiểm tra trạng thái hiện tại của người dùng
        if ($lock->status == UserStatusType::ACTIVE) {
            // Lấy lý do khóa từ request
            $reason = $request->input('reason_lock');

            // Cập nhật trạng thái thành "LOCK" và lưu lý do khóa
            $this->userService->UpdateUserEmployee($user->id, [
                'status' => UserStatusType::LOCK,
                'reason_lock' => $reason,
            ]);

            // Dispatch job để gửi email (chỉ truyền user ID)
            dispatch(new SendUserLockedEmail($user->id, $reason));

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
        $reason = $request->input('reason_lock'); // Lý do khóa

        // Cập nhật trạng thái của tất cả người dùng thành "LOCK" và lưu lý do khóa
        $this->userService->UpdateUserEmployee($userIds, [
            'status' => UserStatusType::LOCK,
            'reason_lock' => $reason,
        ]);

        // Dispatch job để gửi email cho từng người dùng
        foreach ($userIds as $userId) {
            // Dispatch event UserLocked
            event(new UserLocked($userId, $reason));

            // Dispatch job để gửi email
            dispatch(new SendUserLockedEmail($userId, $reason));
            Log::info('Job dispatched to send email to user ID: ' . $userId . ' with reason: ' . $reason);
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

    public function lockUserSpam(User $user)
    {
        $this->userService->UpdateUserEmployee($user->id, [
            'status' => UserStatusType::ACTIVE,
            'order_blocked_until' => null,
        ]);
        $this->OrderCancelService->delete($user->id);


        // Trả về response thành công NGAY LẬP TỨC
        return response()->json(['success' => true, 'message' => 'Đã mở khóa thành công!']);
    }

    // public function updateStatus(Request $request)
    // {
    //     $userId = $request->id;
    //     $status = $request->status;

    //     $data = ['status' => $status];

    //     $result = $this->userService->UpdateUserEmployee($userId, $data);

    //     return response()->json([
    //         'success' => $result ? true : false,
    //         'message' => $result ? 'Cập nhật trạng thái thành công' : 'Không thể cập nhật trạng thái'
    //     ]);
    // }
}
