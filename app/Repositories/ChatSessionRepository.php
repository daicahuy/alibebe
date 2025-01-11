<?php

namespace App\Repositories;

use App\Models\ChatSession;

class ChatSessionRepository extends BaseRepository {
    
    public function getModel()
    {
        return ChatSession::class;
    }
    
}