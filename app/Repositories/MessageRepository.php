<?php

namespace App\Repositories;

use App\Enums\ChatSessionStatusType;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageRepository extends BaseRepository
{
    public function getModel()
    {
        return Message::class;
    }

    // Get all messages from a session
    public function getMessagesBySession($sessionId)
    {
        return $this->model->where('chat_session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    // Mark message as read
    public function markMessageAsRead($messageId)
    {
        $message = $this->model->find($messageId);
        $message->update([
            'is_read' => 1,
            'read_at' => now()
        ]);

        return $message;
    }
    
    // Get unread messages for a user
    public function getUnreadMessages($userId)
    {
        $user = Auth::user();
        
        // For customers, get messages from employees
        if ($user->role == 'customer') {
            return $this->model
                ->whereHas('chatSession', function($query) use ($userId) {
                    $query->where('customer_id', $userId)
                          ->where('status', ChatSessionStatusType::OPEN);
                })
                ->where('sender_id', '!=', $userId)
                ->where('is_read', 0)
                ->get();
        }
        
        // For employees, get messages from sessions they're assigned to
        return $this->model
            ->whereHas('chatSession', function($query) use ($userId) {
                $query->where('employee_id', $userId)
                      ->where('status', ChatSessionStatusType::OPEN);
            })
            ->where('sender_id', '!=', $userId)
            ->where('is_read', 0)
            ->get();
    }
    
    // Mark all messages in a session as read for a user
    public function markAllSessionMessagesAsRead($sessionId, $userId)
    {
        return $this->model
            ->where('chat_session_id', $sessionId)
            ->where('sender_id', '!=', $userId)
            ->where('is_read', 0)
            ->update([
                'is_read' => 1,
                'read_at' => now()
            ]);
    }
}