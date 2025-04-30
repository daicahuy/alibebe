<?php

use App\Enums\UserRoleType;
use App\Models\ChatSession;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('order-status.{orderId}', function ($user, $orderId) {
    // Logic xác thực của bạn ở đây
    return true; // Hoặc kiểm tra xem người dùng có quyền truy cập hay không
});

Broadcast::channel('chat.{chatSession}', function ($user, $chatSessionId) {
    $chatSession = ChatSession::findOrFail($chatSessionId);

    Log::info('Channel Authorization Check', [
        'user_id' => $user->id,
        'chat_session_id' => $chatSessionId,
        'is_customer' => $chatSession->customer_id == $user->id,
        'is_employee' => $chatSession->employee_id == $user->id,
        'result' => $chatSession && (
            $user->id == $chatSession->customer_id ||
            $user->id == $chatSession->employee_id
        )
    ]);

    return $user->id == $chatSession->customer_id
        || $user->id == $chatSession->employee_id
        || $user->role == UserRoleType::ADMIN
        || $user->role == UserRoleType::EMPLOYEE;
});

Broadcast::channel('coupon-notification', function ($user) {
    return $user->role == UserRoleType::ADMIN
        || $user->role == UserRoleType::EMPLOYEE;
});

Broadcast::channel('system-notification', function ($user) {
    return $user->role == UserRoleType::ADMIN
        || $user->role == UserRoleType::EMPLOYEE;
});

Broadcast::channel('give-order-refund', function ($user) {
    return $user->role == UserRoleType::ADMIN
        || $user->role == UserRoleType::EMPLOYEE;
});

Broadcast::channel('send-confirm', function ($user) {
    return $user->role == UserRoleType::ADMIN;
});

Broadcast::channel('send-confirm-e.{userId}', function ($user, $userId) {
    // Chỉ user có ID khớp mới subscribe được
    return (int)$user->id === (int)$userId;
});