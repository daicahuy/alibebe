<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RefundOrderUpdateStatus implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $orderId;  // Mã đơn hàng
    public $status;    // Trạng thái đơn hàng
    /**
     * Create a new event instance.
     */
    public function __construct($orderId, $status)
    {
        $this->orderId = $orderId;  // Gán mã đơn hàng
        $this->status = $status;      // Gán trạng thái
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('order-refund-status.' . $this->orderId) // Trả về array có chứa channel
        ];
    }

    public function broadcastAs()
    {
        return 'event-change-status-refund';
    }

    public function broadcastWith()
    {
        return [
            'status' => $this->status,
            'orderId' => $this->orderId
        ];
    }
}
