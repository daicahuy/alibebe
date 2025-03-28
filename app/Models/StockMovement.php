<?php

namespace App\Models;

use App\Enums\StockMovementType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_number',
        'type',
        'user_id'
    ];

    public function isImport()
    {
        return $this->type = StockMovementType::IMPORT;
    }

    public function isExport()
    {
        return $this->type = StockMovementType::EXPORT;
    }

    public function isAdjustment()
    {
        return $this->type = StockMovementType::ADJUSTMENT;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stockMovementDetail()
    {
        return $this->hasMany(StockMovementDetail::class);
    }
}
