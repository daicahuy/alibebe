<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderUnlockAtTime implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $orderId;  // Mã đơn hàng

    /**
     * Create a new event instance.
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;  // Gán mã đơn hàng
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
        ];
    }
}
