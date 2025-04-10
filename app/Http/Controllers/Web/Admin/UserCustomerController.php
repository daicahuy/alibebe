<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\UserRoleType;
use App\Enums\UserStatusType;
use App\Events\UserLocked;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LockUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Mail\UserLockedMail;
use App\Mail\UserRoleChangedMail;
use App\Models\User;
use App\Repositories\OrderRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\WishlistRepository;
use App\Services\Web\Admin\UserCustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserCustomerController extends Controller
{
    protected UserCustomerService $userService;
    protected OrderRepository $orderRepo;
    protected WishlistRepository $wishlistRepo;
    protected ReviewRepository $reviewRepo;


    public function __construct(UserCustomerService $userService, OrderRepository $orderRepo, WishlistRepository $wishlistRepo, ReviewRepository $reviewRepo)
    {
        $this->userService = $userService;
        $this->orderRepo = $orderRepo;
        $this->wishlistRepo = $wishlistRepo;
        $this->reviewRepo = $reviewRepo;

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


        $data = $this->userService->detail($user->id, $startDate, $endDate, $filterStatus);


        dd($data);

        return view('admin.pages.user_customer.detail', compact(
            'data'
        ));
    }

    public function index(Request $request)
    {
        $limit = $request->input('limit', 15);
        $ListUsers = $this->userService->getUserCustomer($request, $limit);
        $totalUserLock = $this->userService->countUserCustomerLock();

        return view('admin.pages.user_customer.list', compact('ListUsers', 'totalUserLock', 'limit'));
    }


    public function lock(Request $request)
    {
        $limit = $request->input('limit', 15);
        $UsersLock = $this->userService->getUserCustomerLock($request, $limit);
        return view('admin.pages.user_customer.lock', compact('UsersLock', 'limit'));
    }

    public function show(User $user)
    {
        $roles = [
            0 => __('form.user_customer'),
            1 => __('form.user_employee'),
            2 => __('form.user_admin'),
        ];
        $ShowUser = $this->userService->showUserCustomer($user->id, ['*']);

        return view('admin.pages.user_customer.show', [
            'ShowUser' => $ShowUser,
            'roleLabel' => $roles[$user->role],
        ]);
    }

    public function edit(User $user)
    {
        $roles = [
            0 => __('form.user_customer'),
            1 => __('form.user_employee'),
        ];

        $EditUser = $this->userService->showUserCustomer($user->id, ['*']);
        return view('admin.pages.user_customer.edit', compact('EditUser', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (!empty($data)) {
            $this->userService->UpdateUserCustomer($user->id, $data);

            return redirect()->back()->with('success', 'Cập nhật thông tin người dùng thành công.');
        } else {
            return redirect()->back()->with('error', 'Cập nhật thông tin người dùng thất bại. Vui lòng kiểm tra và thử lại.');
        }
    }


    public function lockUser(Request $request, User $user)
    {
        // Lấy thông tin người dùng
        $lock = $this->userService->ShowUserCustomer($user->id, ['*']);
    
        // Kiểm tra trạng thái hiện tại của người dùng
        if ($lock->status == UserStatusType::ACTIVE) {
            // Lấy lý do khóa từ request
            $reason = $request->input('reason_lock');
    
            // Cập nhật trạng thái thành "INACTIVE" và lưu lý do khóa
            $this->userService->UpdateUserCustomer($user->id, [
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
            $this->userService->UpdateUserCustomer($user->id, [
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
    
        // Cập nhật trạng thái của tất cả người dùng thành "INACTIVE" và lưu lý do khóa
        $this->userService->UpdateUserCustomer($userIds, [
            'status' => UserStatusType::LOCK,
            'reason_lock' => $reason,
        ]);
    
        // Phát sự kiện UserLocked và gửi email cho từng người dùng
        foreach ($userIds as $userId) {
            // Lấy thông tin người dùng
            $user = $this->userService->showUserCustomer($userId, ['email', 'fullname']);
    
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

        $this->userService->UpdateUserCustomer($validated['user_ids'], ['status' => UserStatusType::ACTIVE]);

        return response()->json([
            'message' => ('Đã mở khóa thành công !')
        ]);
    }

    public function updateStatus(Request $request)
    {
        $userId = $request->id;
        $status = $request->status;

        $data = ['status' => $status];

        $result = $this->userService->UpdateUserCustomer($userId, $data);

        return response()->json([
            'success' => $result ? true : false,
            'message' => $result ? 'Cập nhật trạng thái thành công' : 'Không thể cập nhật trạng thái'
        ]);
    }

    public function decentralization(User $user)
{
     // Kiểm tra người dùng hiện tại có quyền quản trị viên (role = 2) hay không
     if (auth()->user()->role !== UserRoleType::ADMIN) {
        return redirect()->back()->with('error', 'Bạn không có quyền thực hiện hành động này.');
    }
    if ($user->role == UserRoleType::CUSTOMER) {
        // Cập nhật quyền thành nhân viên
        $this->userService->UpdateUserCustomer($user->id, ['role' => UserRoleType::EMPLOYEE]);

        // Gửi email thông báo
        Mail::to($user->email)->send(new UserRoleChangedMail($user, 'Nhân viên'));

        return redirect()->back()->with('success', 'Cấp quyền nhân viên thành công');
    } elseif ($user->role == UserRoleType::EMPLOYEE) {
        // Cập nhật quyền thành khách hàng
        $this->userService->UpdateUserCustomer($user->id, ['role' => UserRoleType::CUSTOMER]);

        // Gửi email thông báo
        Mail::to($user->email)->send(new UserRoleChangedMail($user, 'Khách hàng'));

        return redirect()->back()->with('success', 'Hủy quyền nhân viên thành công');
    }
}
}
