<?php

namespace App\Events;

use App\Models\Refund;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendConfirmOrderToAdmin implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Refund $refund;
    public string $message;

    /**
     * Create a new event instance.
     */
    public function __construct(Refund $refund, string $message)
    {
        // Nạp luôn quan hệ order & user
        $this->refund  = $refund->load('order', 'user');
        $this->message = $message;
    }

    /**
     * The name of the event as client sẽ lắng nghe.
     */
    public function broadcastAs(): string
    {
        return 'send-confirm-admin';
    }

    /**
     * Channel mà client subscribe.
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('send-confirm');
    }

    /**
     * Payload gửi về client.
     */
    public function broadcastWith(): array
    {
        return [
            'id'      => $this->refund->id,
            'message' => $this->message,
            'refund' => [
                'id'           => $this->refund->id,
                'total_amount' => $this->refund->total_amount,
                'phone_number' => $this->refund->phone_number ?? '',
                'reason'       => $this->refund->reason,
                'order' => [
                    'id'   => $this->refund->order->id,
                    'code' => $this->refund->order->code,
                    'total_amount' => $this->refund->order->total_amount,
                    'fullname'     => $this->refund->order->fullname,
                    'phone_number' => $this->refund->order->phone_number ?? '',
                ],
                'user' => [
                    'fullname' => $this->refund->user->fullname,
                ],
            ],
        ];
    }
}
