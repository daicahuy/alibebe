<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    use HasFactory;

    const STATUS_OPEN = 'open';
    const STATUS_CLOSED = 'closed';

    public $timestamps = false;

    protected $fillables = [
        'customer_id',
        'employee_id',
        'status',
        'created_date',
        'closed_date',
    ];

    public function isStatusOpen()
    {
        return $this->status === self::STATUS_OPEN;
    }

    public function isStatusClosed()
    {
        return $this->status === self::STATUS_CLOSED;
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
