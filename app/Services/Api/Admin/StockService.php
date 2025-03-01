<?php

namespace App\Services\Api\Admin;

use App\Repositories\ProductRepository;
use App\Repositories\StockMovementRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockService
{
    protected ProductRepository $productRepository;
    protected StockMovementRepository $stockMovementRepository;

    public function __construct(
        ProductRepository $productRepository,
        StockMovementRepository $stockMovementRepository,
    )
    {
        $this->productRepository = $productRepository;
        $this->stockMovementRepository = $stockMovementRepository;
    }

    public function importSingle($data)
    {
        try {
            $product = $this->productRepository->findById($data['id']);
    
            if ($product->isVariant()) {
                return ['success' => false, 'message' => 'Sản phẩm không hợp lệ'];
            }
    
            DB::beginTransaction();
            $this->stockMovementRepository->create([
                'product_id' => $data['id'],
                'quantity' => $data['quantity'],
                'user_id' => $data['user_id'],
            ]);
            DB::table('product_stocks')->where('product_id', $data['id'])->increment('stock', $data['quantity']);
            DB::commit();

            return ['success' => true, 'message' => 'Nhập kho thành công !'];
        }
        catch (\Throwable $e) {
            DB::rollBack();
            Log::error(
                __CLASS__ . '@' . __FUNCTION__,
                ['error' => $e->getMessage()]
            );

            return ['success' => false, 'message' => 'Lỗi hệ thống! Vui lòng thử lại sau ít phút.'];
        }
    }

    public function importVariant($data)
    {
        try {
            $checkImportStock = false;

            DB::beginTransaction();
            foreach ($data['variants'] as $variant) {
                if (isset($variant['quantity'])) {
                    $checkImportStock = true;
                    $this->stockMovementRepository->create([
                        'product_variant_id' => $variant['id'],
                        'quantity' => $variant['quantity'],
                        'user_id' => $data['user_id'],
                    ]);
                    DB::table('product_stocks')->where('product_variant_id', $variant['id'])->increment('stock', $variant['quantity']);
                }
            }
            DB::commit();

            if (!$checkImportStock) {
                return ['success' => true, 'message' => 'Không có thay đổi gì', 'status' => Response::HTTP_OK];
            }

            return ['success' => true, 'message' => 'Nhập kho thành công !', 'status' => Response::HTTP_CREATED];
        }
        catch (\Throwable $e) {
            DB::rollBack();
            Log::error(
                __CLASS__ . '@' . __FUNCTION__,
                ['error' => $e->getMessage()]
            );

            return ['success' => false, 'message' => 'Lỗi hệ thống! Vui lòng thử lại sau ít phút.', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];  
        }
    }
}