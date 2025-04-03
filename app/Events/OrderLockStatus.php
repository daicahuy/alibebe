<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderLockStatus implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $orderId;
    public $status;
    public $userID;

    /**
     * Create a new event instance.
     */
    public function __construct($orderId, $status, $userID)
    {
        $this->orderId = $orderId;  // Gán mã đơn hàng
        $this->status = $status;  // Gán mã đơn hàng
        $this->userID = $userID;  // Gán mã đơn hàng
        // Gán trạng thái
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('order-status-lock.' . $this->orderId) // Trả về array có chứa channel
        ];
    }

    public function broadcastAs()
    {
        return 'event-change-status-lock';
    }

    public function broadcastWith()
    {
        return [
            'orderId' => $this->orderId,
            'status' => $this->status,
            'userID' => $this->userID,
        ];
    }
}
