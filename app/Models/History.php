<?php

namespace App\Models;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    const ACTION_TYPE_CREATE = 'create';
    const ACTION_TYPE_UPDATE = 'update';
    const ACTION_TYPE_DELETE = 'delete';
    const ACTION_TYPE_CHANGE_STATUS = 'change_status';

    protected $fillable = [
        'subject_type',
        'subject_id',
        'action_type',
        'old_value',
        'new_value',
        'user_id',
        'description',
    ];

    public function isActionTypeCreate()
    {
        return $this->action_type = History::ACTION_TYPE_CREATE;
    }

    public function isActionTypeUpdate()
    {
        return $this->action_type = History::ACTION_TYPE_UPDATE;
    }

    public function isActionTypeDelete()
    {
        return $this->action_type = History::ACTION_TYPE_DELETE;
    }

    public function isActionTypeChangeStatus()
    {
        return $this->action_type = History::ACTION_TYPE_CHANGE_STATUS;
    }


    /////////////////////////////////////////////////////
    // RELATIONS


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
