<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    const TYPE_TEXT = 'text';
    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';
    const TYPE_FILE = 'file';

    protected $fillables = [
        'chat_session_id',
        'sender_id',
        'message',
        'type',
        'is_read',
    ];

    public function isTypeText()
    {
        return $this->type === self::TYPE_TEXT;
    }

    public function isTypeImage()
    {
        return $this->type === self::TYPE_IMAGE;
    }

    public function isTypeVideo()
    {
        return $this->type === self::TYPE_VIDEO;
    }

    public function isTypeFile()
    {
        return $this->type === self::TYPE_FILE;
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
