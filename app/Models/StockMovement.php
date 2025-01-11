<?php

namespace App\Models;

use App\Enums\StockMovementType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_variant_id',
        'quantity',
        'type',
        'reason',
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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
