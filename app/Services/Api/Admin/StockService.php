<?php

namespace App\Services\Api\Admin;

use App\Enums\StockMovementType;
use App\Repositories\ProductRepository;
use App\Repositories\StockMovementDetailRepository;
use App\Repositories\StockMovementRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockService
{
    const STOCK_MOVEMENT_CODE_NUMBER_LENGTH = 8;

    protected ProductRepository $productRepository;
    protected StockMovementRepository $stockMovementRepository;
    protected StockMovementDetailRepository $stockMovementDetailRepository;

    public function __construct(
        ProductRepository $productRepository,
        StockMovementRepository $stockMovementRepository,
        StockMovementDetailRepository $stockMovementDetailRepository,
    )
    {
        $this->productRepository = $productRepository;
        $this->stockMovementRepository = $stockMovementRepository;
        $this->stockMovementDetailRepository = $stockMovementDetailRepository;
    }

    public function importStock($data)
    {
        $checkImportStock = false;
        
        try {
            DB::beginTransaction();
            $stockMovement = $this->stockMovementRepository->create([
                'code_number' => $this->generateCodeNumber(),
                'user_id' => $data['user_id'],
                'type' => StockMovementType::IMPORT
            ]);

            if (isset($data['singleProducts'])) {
                foreach ($data['singleProducts'] as $singleProduct) {
                    if (isset($singleProduct['quantity'])) {
                        $checkImportStock = true;

                        $stockMovement->stockMovementDetail()->create([
                            'product_id' => $singleProduct['id'],
                            'quantity' => $singleProduct['quantity']
                        ]);
                        DB::table('product_stocks')->where('product_id', $singleProduct['id'])->increment('stock', $singleProduct['quantity']);
                    }
                }
            }
    
            if (isset($data['variantProducts'])) {
                foreach ($data['variantProducts'] as $variantProduct) {
                    if (isset($variantProduct['quantity'])) {
                        $checkImportStock = true;

                        $stockMovement->stockMovementDetail()->create([
                            'product_variant_id' => $variantProduct['id'],
                            'quantity' => $variantProduct['quantity']
                        ]);
                        DB::table('product_stocks')->where('product_variant_id', $variantProduct['id'])->increment('stock', $variantProduct['quantity']);
                    }
                }
            }

            if (!$checkImportStock) {
                DB::rollBack();
                return ['success' => true, 'message' => 'Không có thay đổi gì', 'status' => Response::HTTP_OK];
            }

            DB::commit();
            return ['success' => true, 'message' => 'Nhập kho thành công !', 'status' => Response::HTTP_CREATED];
        }
        catch (\Throwable $e) {
            DB::rollBack();
            Log::error(
                __CLASS__ . '@' . __FUNCTION__,
                ['error' => $e->getMessage()],
            );

            return ['success' => false, 'message' => 'Lỗi hệ thống! Vui lòng thử lại sau ít phút.'];
        }
        
    }

    public function generateCodeNumber($prefix = 'NK')
    {
        $lastId = $this->stockMovementRepository->getLatestId() + 1;
        
        return $prefix . str_pad($lastId, self::STOCK_MOVEMENT_CODE_NUMBER_LENGTH, '0', STR_PAD_LEFT);
    }
}