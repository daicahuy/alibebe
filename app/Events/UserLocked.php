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

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function broadcastOn(): array
    {
        Log::info($this->userId);
        
        return [
            
            new Channel('user.logout.' . $this->userId) // Trả về array có chứa channel
        ];
    }

    public function broadcastAs()
    {
        return 'user-locked';
    }
    public function broadcastWith()
    {
        return [
            'userId' => $this->userId,  
        ];
    }
}