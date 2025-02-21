<?php

namespace App\Services\Api\Admin;

use App\Repositories\ProductRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    protected ProductRepository $productRepository;

    public function __construct(
        ProductRepository $productRepository
    )
    {
        $this->productRepository = $productRepository;
    }

    public function storeSingle($data)
    {
        try {
            dd($data);
            // Upload image
            $data['product']['thumbnail'] = Storage::put('products', $data['product']['thumbnail']);

            // Upload galleries
            $productGalleries = [];
            foreach ($data['product_galleries'] as $productGallery) {
                $productGalleries[] = Storage::put('product_galleries', $productGallery);
            }
            $data['product_galleries'] = $productGalleries;
            
            DB::beginTransaction();
            $product = $this->productRepository->create($data['product']);
            DB::commit();

        }
        catch (\Throwable $e) {
            DB::rollBack();
            Log::error(
                __CLASS__ . '@' . __FUNCTION__,
                ['error' => $e->getMessage()]
            );

            return response()->json([
                'message' => 'Lỗi hệ thống! Vui lòng thử lại sau ít phút.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}