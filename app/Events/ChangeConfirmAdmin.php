<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChangeConfirmAdmin implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $refundId;
    /**
     * Create a new event instance.
     */
    public function __construct($refundId)
    {
        //
        $this->refundId = $refundId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('order-refund-confirmed.' . $this->refundId) // Trả về array có chứa channel
        ];
    }

    public function broadcastAs()
    {
        return 'event-order-refund-confirmed';
    }

    public function broadcastWith()
    {
        return [
            'orderId' => $this->refundId,

        ];
    }
}
