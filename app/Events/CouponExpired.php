<?php

namespace App\Events;

use App\Models\Coupon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CouponExpired implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $coupon;
    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('coupon-notification'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'event-coupon';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->coupon->id,
            'code' => $this->coupon->code,
            'usage_count' => $this->coupon->usage_count,
            'usage_limit' => $this->coupon->usage_limit,
            'end_date' => $this->coupon->end_date,
        ];
    }
}
