<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserLocked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $reason; // Thêm thuộc tính lý do khóa

    public function __construct($userId, $reason)
    {
        $this->userId = $userId;
        $this->reason = $reason; // Gán lý do khóa
    }

    public function broadcastOn(): array
    {
        Log::info('Broadcasting user-locked event for user ID: ' . $this->userId . ' with reason: ' . $this->reason);

        return [
            new Channel('user.logout.' . $this->userId) // Sử dụng PrivateChannel để bảo mật
        ];
    }

    public function broadcastAs()
    {
        return 'user-locked'; // Tên sự kiện
    }

    public function broadcastWith()
    {
        return [
            'userId' => $this->userId,
            'reason' => $this->reason, // Truyền lý do khóa trong payload
        ];
    }
}
