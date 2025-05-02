<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BankInfoChangedForAll implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $refundId;
    public $changes;
    public $message;

    /**
     * Create a new event instance.
     *
     * @param int $refundId
     * @param array $changes
     * @param string $message
     * @return void
     */
    public function __construct($refundId, $changes, $message)
    {
        $this->refundId = $refundId;
        $this->changes = $changes;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('admin-notifications-bank');
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'bank.info.changed.all';
    }
}