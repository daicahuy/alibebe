<?php

namespace App\Models;

use App\Enums\ChatSessionStatusType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'employee_id',
        'status',
        'created_date',
        'closed_date',
    ];

    public function isClosed()
    {
        return $this->status === ChatSessionStatusType::CLOSED;
    }

    public function isOpen()
    {
        return $this->status === ChatSessionStatusType::OPEN;
    }



    /////////////////////////////////////////////////////
    // RELATIONS

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

}
