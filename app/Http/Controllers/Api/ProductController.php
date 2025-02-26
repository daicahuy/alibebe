<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProductSingleRequest;
use App\Models\Product;
use App\Services\Api\Admin\ProductService;
use Illuminate\Http\Request;

class ProductController extends ApiBaseController
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function storeSingle(StoreProductSingleRequest $request)
    {
        $response = $this->productService->storeSingle($request->validated());
        return $response;
        // Create product
        // $product = Product::create($request->all());

        // return $this->sendSuccess($product, 'Product created successfully.');
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
