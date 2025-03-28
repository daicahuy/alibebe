<?php

namespace App\Events;

use App\Models\Order;
use App\Models\OrderOrderStatus;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPendingCountUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pendingCount;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        $this->pendingCount = OrderOrderStatus::query()->where("order_status_id", 1)->count();

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('order-pending-count');
    }

    public function broadcastAs()
    {
        return 'pending-count-updated';
    }

    public function broadcastWith()
    {
        return ['count' => $this->pendingCount];
    }
}
