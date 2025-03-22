<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $sessionId;
    public $senderId;

    public function __construct($message, $sessionId, $senderId)
    {
        $this->message = $message;
        $this->sessionId = $sessionId;
        $this->senderId = $senderId;
    }

    public function broadcastOn()
    {
        return new Channel('chat.' . $this->sessionId);
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'sender_id' => $this->senderId,
            'created_at' => now()->toDateTimeString()
        ];
    }
}