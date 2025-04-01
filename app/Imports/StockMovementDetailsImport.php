<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\StockMovementDetail;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StockMovementDetailsImport implements ToCollection, WithHeadingRow
{

    protected $stockMovementId;

    public function __construct(int $stockMovementId)
    {
        $this->stockMovementId = $stockMovementId;
    }

    public function model(array $row)
    {
        return new StockMovementDetail([
            'product_id'         => $row['product_id'] ?? null,
            'product_variant_id' => $row['product_variant_id'] ?? null,
            'stock_movement_id'  => $this->stockMovementId,
            'quantity'           => $row['quantity'],
        ]);
    }


    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (!$row['product_id'] && !$row['product_variant_id']) {
                throw new Exception("Dữ liệu không hợp lệ");
            }

            StockMovementDetail::create([
                'product_id'         => $row['product_id'] ?? null,
                'product_variant_id' => $row['product_variant_id'] ?? null,
                'stock_movement_id'  => $this->stockMovementId,
                'quantity'           => $row['quantity'],
            ]);

            if ($row['product_id']) {
                DB::table('product_stocks')->where('product_id', $row['product_id'])->increment('stock', $row['quantity']);
            }

            if ($row['product_variant_id']) {
                DB::table('product_stocks')->where('product_variant_id', $row['product_variant_id'])->increment('stock', $row['quantity']);
            }
        }
    }
}
