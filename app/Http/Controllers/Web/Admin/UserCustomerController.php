<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\UserStatusType;
use App\Events\UserLocked;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LockUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Repositories\OrderRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\WishlistRepository;
use App\Services\Web\Admin\UserCustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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


public function lockUser(User $user)
{
    // Lấy thông tin người dùng
    $lock = $this->userService->ShowUserCustomer($user->id, ['*']);

    // Kiểm tra trạng thái hiện tại của người dùng
    if ($lock->status == UserStatusType::ACTIVE) {
        // Cập nhật trạng thái thành "LOCK"
        $this->userService->UpdateUserCustomer($user->id, ['status' => UserStatusType::LOCK]);
// Thêm log để kiểm tra
Log::info('Locking user with ID: ' . $user->id);
        // Phát sự kiện UserLocked
        // broadcast(new UserLocked($user->id));
        event(new UserLocked($user->id));
        Log::info('UserLocked event broadcasted for user ID: ' . $user->id);
        return redirect()->back()->with('success', 'Đã khóa thành công!');
    } elseif ($lock->status == UserStatusType::LOCK) {
        // Cập nhật trạng thái thành "ACTIVE"
        $this->userService->UpdateUserCustomer($user->id, ['status' => UserStatusType::ACTIVE]);

        return redirect()->back()->with('success', 'Đã mở khóa thành công!');
    } else {
        return redirect()->back()->with('error', 'Thất bại, xin kiểm tra lại.');
    }
}

public function lockMultipleUsers(LockUserRequest $request)
{
    // Lấy danh sách user_ids từ request
    $validated = $request->validated();
    $userIds = $validated['user_ids'];

    // Cập nhật trạng thái của tất cả người dùng thành "LOCK"
    $this->userService->UpdateUserCustomer($userIds, ['status' => UserStatusType::LOCK]);

    // Phát sự kiện UserLocked cho từng người dùng
    foreach ($userIds as $userId) {
        event(new UserLocked($userId));
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
}
