<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $orderId;  // Mã đơn hàng
    public $status;    // Trạng thái đơn hàng
    public $order;
    public $user_id;
    /**
     * Create a new event instance.
     */
    public function __construct($orderId, $status, $order, $user_id = "")
    {
        $this->orderId = $orderId;
        $this->status = $status;
        $this->order = $order;
        $this->user_id = $user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('order-status.' . $this->orderId) // Trả về array có chứa channel
        ];
    }

    public function broadcastAs()
    {
        return 'event-change-status';
    }

    public function broadcastWith()
    {
        return [
            'status' => $this->status,
            'orderId' => $this->orderId,
            'order' => $this->order,
            'userID' => $this->user_id,
        ];
    }
}
