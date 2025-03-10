<?php

namespace App\Repositories;

use App\Enums\ChatSessionStatusType;
use App\Enums\UserRoleType;
use App\Models\ChatSession;
use Illuminate\Support\Facades\DB;

class ChatSessionRepository extends BaseRepository
{

    public function getModel()
    {
        return ChatSession::class;
    }

    // Lấy tất cả các phiên trò chuyện với các quan hệ liên quan (khách hàng, nhân viên, tin nhắn)
    public function getAllChatSessionWithRelation($perPage = 10)
    {
        // Lấy các cột cần thiết từ model ChatSession
        $query = $this->model->select('id', 'customer_id', 'employee_id', 'status')
            ->with(['messages:id,chat_session_id,message', 'customer:id,fullname,avatar', 'employee:id,fullname,avatar']);

        $user = auth()->user();  // Lấy người dùng hiện tại

        // Quản trị viên có thể xem tất cả các phiên trò chuyện
        if ($user->role == UserRoleType::ADMIN) {
            return $query->paginate($perPage);
        } elseif ($user->role == UserRoleType::EMPLOYEE) {
            // Nhân viên chỉ xem các phiên mà họ được gán hoặc các phiên chưa được gán và đang mở
            return $query->where(function ($q) use ($user) {
                $q->where('employee_id', $user->id)
                    ->orWhere(function ($q2) {
                        $q2->whereNull('employee_id')
                            ->where('status', ChatSessionStatusType::OPEN);
                    });
            })->paginate($perPage);
        } else {
            // Khách hàng chỉ xem được các phiên trò chuyện của họ
            return $query->where('customer_id', $user->id)
                ->paginate($perPage);
        }
    }

    // Lấy thông tin chi tiết của một phiên trò chuyện cụ thể
    public function getChatSession($chatSessionId)
    {
        $user = auth()->user();  // Lấy người dùng hiện tại

        // Lấy phiên trò chuyện cùng với các tin nhắn liên quan
        $query = $this->model->with([
            'messages' => function ($query) {
                $query->oldest()->paginate(10);  // Phân trang tin nhắn
            },
            'customer:id,fullname,avatar',
            'employee:id,fullname,avatar'
        ])
            ->where('id', $chatSessionId)
            ->where('status', ChatSessionStatusType::OPEN);

        // Hạn chế quyền truy cập dựa trên vai trò của người dùng
        if ($user->role == UserRoleType::EMPLOYEE) {
            // Nhân viên chỉ truy cập được các phiên mà họ được gán hoặc chưa được gán
            $query->where(function ($q) use ($user) {
                $q->where('employee_id', $user->id)
                    ->orWhereNull('employee_id');
            });
        } elseif ($user->role == UserRoleType::CUSTOMER) {
            // Khách hàng chỉ truy cập được các phiên của họ
            $query->where('customer_id', $user->id);
        }

        return $query->first();
    }

    // Cập nhật trạng thái của phiên trò chuyện (mở, đóng, v.v.)
    public function updateChatSessionStatus($sessionId, $status)
    {
        $session = $this->model->find($sessionId);
        $session->update([
            'status' => $status,
            'closed_at' => $status == ChatSessionStatusType::CLOSED  ? now() : null,  // Cập nhật thời gian đóng nếu trạng thái là ĐÓNG
        ]);

        return $session;
    }

    // Gán nhân viên cho một phiên trò chuyện cụ thể
    public function assignEmployeeToSession($sessionId, $employeeId)
    {
        $session = $this->model->find($sessionId);

        // Chỉ gán nếu phiên đang mở và chưa có nhân viên được gán
        if ($session && $session->status == ChatSessionStatusType::OPEN && !$session->employee_id) {
            $session->update([
                'employee_id' => $employeeId
            ]);
        }

        return $session;
    }

    // Tìm phiên trò chuyện đang hoạt động của một khách hàng cụ thể
    public function findActiveChatSession($customerId)
    {
        return $this->model
            ->where('customer_id', $customerId)
            ->where('status', ChatSessionStatusType::OPEN)  // Phiên đang mở
            ->first();
    }

    // Kiểm tra xem có tồn tại phiên trò chuyện giữa khách hàng và nhân viên hay không
    public function checkExistChatSession($customerId, $employeeId)
    {
        return $this->model
            ->where(function ($query) use ($customerId, $employeeId) {
                $query->where('customer_id', $customerId)
                    ->where('employ_id', $employeeId);
            })
            ->orWhere(function ($query) use ($customerId, $employeeId) {
                $query->where('customer_id', $employeeId)
                    ->where('employ_id', $customerId);
            })
            ->exists();  // Kiểm tra sự tồn tại của phiên
    }
}
