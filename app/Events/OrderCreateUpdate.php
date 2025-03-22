<?php
namespace App\Events;


use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderCreateUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order; // Add order data here

    /**
     * Create a new event instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('order-create-update') // Or a private channel if needed: new PrivateChannel('user.' . $this->order->user_id)
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'event-update-order';
    }

    public function broadcastWith(): array
    {
        return [
            'order' => $this->order->toArray() // Or a specific subset of order data
        ];
    }
}
