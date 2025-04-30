<?php

namespace App\Events;

use App\Models\Refund;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendConfirmOrderToEmployee implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Refund $refund;
    public string $message;
    public int $employeeId;

    /**
     * Create a new event instance.
     */
    public function __construct(Refund $refund, string $message, int $employeeId)
    {
        // Nạp luôn quan hệ order & user
        $this->refund     = $refund->load('order', 'user');
        $this->message    = $message;
        $this->employeeId = $employeeId;
    }

    /**
     * The name of the event as client sẽ lắng nghe.
     */
    public function broadcastAs(): string
    {
        return 'send-confirm-employee';
    }

    /**
     * Channel mà client subscribe.
     */
    public function broadcastOn(): Channel
    {
        // Private channel riêng cho từng nhân viên
        return new PrivateChannel('send-confirm-e.' . $this->employeeId);
    }

    /**
     * Payload gửi về client.
     */
    public function broadcastWith(): array
    {
        return [
            'id'      => $this->refund->id,
            'message' => $this->message,
            'refund'  => [
                'id'           => $this->refund->id,
                'total_amount' => $this->refund->total_amount,
                'phone_number' => $this->refund->phone_number ?? '',
                'reason'       => $this->refund->reason,
                'order'        => [
                    'id'           => $this->refund->order->id,
                    'code'         => $this->refund->order->code,
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
