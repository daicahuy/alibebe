<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use App\Models\ChatSession;

class NewMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $chatSession;

    public function __construct(Message $message, ChatSession $chatSession)
    {
        // Load relationship sender và format dữ liệu
        $this->message = $message->load(['sender' => function ($query) {
            $query->select('id', 'fullname', 'avatar', 'role');
        }]);

        $this->chatSession = $chatSession;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->chatSession->id);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'message' => $this->message->message,
            'type' => $this->message->type,
            'created_at' => $this->message->created_at->toDateTimeString(),
            'sender' => [
                'id' => $this->message->sender->id,
                'fullname' => $this->message->sender->fullname,
                'avatar' => $this->message->sender->avatar_url,
                'role' => $this->message->sender->role
            ]
        ];
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }
}
