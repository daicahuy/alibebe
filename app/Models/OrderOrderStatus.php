<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderOrderStatus extends Pivot
{
    public function userModified()
    {
        return $this->belongsTo(User::class, 'modified_by', 'id');
    }
}
