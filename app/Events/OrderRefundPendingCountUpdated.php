<?php

namespace App\Events;

use App\Models\Order;
use App\Models\OrderOrderStatus;
use App\Models\Refund;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderRefundPendingCountUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pendingCount;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        $this->pendingCount = Refund::query()->where("status", "pending")->count();

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('order-refund-pending-count');
    }

    public function broadcastAs()
    {
        return 'order-refund-pending-count-updated';
    }

    public function broadcastWith()
    {
        return ['count' => $this->pendingCount];
    }
}
