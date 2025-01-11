<?php

namespace App\Repositories;

use App\Models\Message;

class MessageRepository extends BaseRepository {
    
    public function getModel()
    {
        return Message::class;
    }
    
}