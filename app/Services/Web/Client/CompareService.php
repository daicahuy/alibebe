<?php

namespace App\Services\Web\Client;

use App\Repositories\ProductRepository;
use Cookie;
use Exception;
use Illuminate\Http\Request;
use Log;
use Storage;
class CompareService
{
    protected ProductRepository $productRepo;
    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }



    public function getComparedProductsData($productIds)
    {
        $products = $this->productRepo->getProductsWithDetailsByIds(
            $productIds,
            ['attributeValues.attribute', 'productVariants.attributeValues.attribute'],
        );
        $productsData = [];

        foreach ($products as $product) {
            $productData = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'thumbnail' => Storage::url($product->thumbnail),
                'specifications' => [], //thông số kĩ thuật
                'variant_attributes' => [], //  mảng để chứa thuộc tính biến thể
            ];

            // 1. Xử lý THÔNG SỐ KỸ THUẬT (cho cả sản phẩm đơn và sản phẩm gốc của biến thể - is_variant = 0)
            foreach ($product->attributeValues as $attributeValue) {
                // **Lọc: Chỉ lấy attributeValues không phải là biến thể (is_variant = 0 hoặc null)**
                if (!$attributeValue->is_variant) { // Giả sử có trường 'is_variant' trong bảng attribute_values
                    $productData['specifications'][$attributeValue->attribute->name] = $attributeValue->value;
                }
            }

            // 2. Xử lý THUỘC TÍNH BIẾN THỂ (chỉ cho sản phẩm biến thể - type = 1)
            if ($product->isVariant()) { // Sử dụng method isVariant() đã định nghĩa trong model Product
                foreach ($product->productVariants as $variant) {
                    $variantAttributes = [];
                    foreach ($variant->attributeValues as $variantAttributeValue) {
                        // **Lọc: Chỉ lấy attributeValues là biến thể (is_variant = 1)**
                        if ($variantAttributeValue->is_active) { // Giả sử có trường 'is_variant' trong bảng attribute_values
                            $variantAttributes[$variantAttributeValue->attribute->name] = $variantAttributeValue->value;
                        }
                    }
                    // Thêm thông tin biến thể vào mảng 'variant_attributes'
                    $productData['variant_attributes'][] = $variantAttributes; // Mỗi phần tử là 1 biến thể, chứa mảng thuộc tính của biến thể đó
                }
            }


            $productsData[] = $productData;
        }

        return $productsData;

    }
   


   



}