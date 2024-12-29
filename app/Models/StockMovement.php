<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    const TYPE_IMPORT = 'import';
    const TYPE_EXPORT = 'export';
    const TYPE_ADJUSTMENT = 'adjustment';

    protected $fillable = [
        'product_id',
        'product_variant_id',
        'quantity',
        'type',
        'reason',
        'user_id'
    ];

    public function isTypeImport()
    {
        return $this->type = self::TYPE_IMPORT;
    }

    public function isTypeExport()
    {
        return $this->type = self::TYPE_EXPORT;
    }

    public function isTypeAdjustment()
    {
        return $this->type = self::TYPE_ADJUSTMENT;
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
