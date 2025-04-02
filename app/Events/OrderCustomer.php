<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCustomer implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $order;
    public $message;
    public function __construct(Order $order, string $message)
    {
        $this->order = $order;
        $this->message = $message;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('admin-notifications'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'new-order-customer';
    }

    public function broadcastWith(): array
    {
        $productNames = $this->order->orderItems->pluck('name')->toArray();

        return [
            'message' => $this->message,
            'order'   => [
                'code'          => $this->order->code,
                'total_amount'  => $this->order->total_amount,
                'fullname' => $this->order->fullname,
                'phone_number' => $this->order->phone_number
            ],
        ];
    }
}
