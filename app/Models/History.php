<?php

namespace App\Models;

use App\Enums\HistoryActionType;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_type',
        'subject_id',
        'action_type',
        'old_value',
        'new_value',
        'user_id',
        'description',
    ];

    public function isCreate()
    {
        return $this->action_type = HistoryActionType::CREATE;
    }

    public function isUpdate()
    {
        return $this->action_type = HistoryActionType::UPDATE;
    }

    public function isDelete()
    {
        return $this->action_type = HistoryActionType::DELETE;
    }

    public function isChangeStatus()
    {
        return $this->action_type = HistoryActionType::CHANGE_STATUS;
    }


    /////////////////////////////////////////////////////
    // RELATIONS


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
