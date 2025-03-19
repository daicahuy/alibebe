<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\StoreProductSingleRequest;
use App\Http\Requests\Api\StoreProductVariantRequest;
use App\Http\Requests\Api\UpdateProductSingleRequest;
use App\Http\Requests\Api\UpdateProductVariantRequest;
use App\Models\Product;
use App\Services\Api\Admin\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends ApiBaseController
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getAll()
    {
        return $this->productService->getAll();
    }

    public function storeSingle(StoreProductSingleRequest $request)
    {
        $response = $this->productService->storeSingle($request->validated());

        if ($response['success']) {
            return $this->sendSuccess(
                statusCode: Response::HTTP_CREATED,
                message: $response['message'],
            );
        }

        return $this->sendError(
            statusCode: Response::HTTP_INTERNAL_SERVER_ERROR,
            message: $response['message']
        );
    }

    public function storeVariant(StoreProductVariantRequest $request)
    {
        $response = $this->productService->storeVariant($request->validated());
        
        if ($response['success']) {
            return $this->sendSuccess(
                statusCode: Response::HTTP_CREATED,
                message: $response['message'],
            );
        }

        return $this->sendError(
            statusCode: Response::HTTP_INTERNAL_SERVER_ERROR,
            message: $response['message']
        );
    }

    public function updateSingle(UpdateProductSingleRequest $request, int $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->sendError(
                statusCode: Response::HTTP_NOT_FOUND,
                message: 'Không tìm thấy sản phẩm có id là ' . $id
            );
        }

        $response = $this->productService->updateSingle($product, $request->validated());
        
        if ($response['success']) {
            return $this->sendSuccess(
                statusCode: Response::HTTP_OK,
                message: $response['message'],
            );
        }

        return $this->sendError(
            statusCode: Response::HTTP_INTERNAL_SERVER_ERROR,
            message: $response['message']
        );
    }

    public function updateVariant(UpdateProductVariantRequest $request, int $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->sendError(
                statusCode: Response::HTTP_NOT_FOUND,
                message: 'Không tìm thấy sản phẩm có id là ' . $id
            );
        }

        $response = $this->productService->updateVariant($product, $request->validated());
        
        if ($response['success']) {
            return $this->sendSuccess(
                statusCode: Response::HTTP_CREATED,
                message: $response['message'],
            );
        }

        return $this->sendError(
            statusCode: Response::HTTP_INTERNAL_SERVER_ERROR,
            message: $response['message']
        );
    }

    public function toggleActive(Request $request, Product $product)
    {
        $isActive = $request->input('is_active'); // Nhận giá trị is_active từ request

        $product->is_active = $isActive; // Gán giá trị cho thuộc tính is_active
        $product->save(); // Lưu thay đổi

        $this->childIsActive($product, $isActive);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công',
            // 'is_active' => $category->is_active,
            // 'category_id' => $category->id
        ]);
    }

    public function childIsActive(Product $product, $isActive)
    {
        $childProducts = $product->productVariants;

        if ($childProducts->count() > 0) {
            foreach ($childProducts as $chidProduct) {
                $chidProduct->is_active = $isActive;
                $chidProduct->save();

                // $this->childIsActive($chidProduct, $isActive);
            }
        }
    }
}
