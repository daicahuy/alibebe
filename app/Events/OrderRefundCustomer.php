<?php

namespace App\Events;

use App\Models\Refund;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderRefundCustomer implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    private $refund;
    private $message;
    public function __construct(Refund $refund, string $message)
    {
        $this->refund = $refund;
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
            new Channel('give-order-refund'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'give-order-customer';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'refund'   => [
                'code'          => $this->refund->order->code,
                'total_amount'  => $this->refund->total_amount,
                'fullname' => $this->refund->user->fullname,
                'phone_number' => $this->refund->phone_number,
                'reason' => $this->refund->reason
            ],
        ];
    }
}
