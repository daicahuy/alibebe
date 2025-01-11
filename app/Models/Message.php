<?php

namespace App\Models;

use App\Enums\MessageType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_session_id',
        'sender_id',
        'message',
        'type',
        'read_at',
    ];

    public function isTypeText()
    {
        return $this->type === MessageType::TEXT;
    }

    public function isTypeImage()
    {
        return $this->type === MessageType::IMAGE;
    }

    public function isTypeVideo()
    {
        return $this->type === MessageType::VIDEO;
    }

    public function isTypeFile()
    {
        return $this->type === MessageType::FILE;
    }



    /////////////////////////////////////////////////////
    // RELATIONS

    public function chatSession()
    {
        return $this->belongsTo(ChatSession::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }


}
