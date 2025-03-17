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
                'price' => $product->price, // giá sp gốc
                'sale_price' => $product->sale_price, //sale gốc
                'thumbnail' => Storage::url($product->thumbnail),
                'specifications' => [], //thông số kĩ thuật
                'variant_attributes' => [], //  mảng để chứa thuộc tính biến thể
                'rating_avg' => 0,
                'min_variant_price' => null,
                'max_variant_price' => null,
                'min_variant_sale_price' => null,
                'max_variant_sale_price' => null,
                'type' => $product->type,
                'is_sale' => $product->is_sale
            ];

            // tính avg rating
            $avgRating = $product->reviews()->avg('rating');
            $productData['rating_avg'] = number_format($avgRating, 1);

            //  xử lý tiền
            if ($product->type == 1) { // biến thể
                $minPrice = null;
                $maxPrice = null;
                $minSalePrice = null;
                $maxSalePrice = null;

                // if ($product->is_sale == 1) {
                foreach ($product->productVariants as $variant) {
                    if ($variant->is_active == 1) {
                        //    giá gốc
                        if ($minPrice === null || $variant->price < $minPrice) {
                            $minPrice = $variant->price;
                        }
                        if ($maxPrice === null || $variant->price > $maxPrice) {
                            $maxPrice = $variant->price;
                        }

                        //biến thể có giá sale
                        if ($variant->sale_price) {
                            if ($minSalePrice === null || $variant->sale_price < $minSalePrice) {
                                $minSalePrice = $variant->sale_price;
                            }
                            if ($maxSalePrice === null || $variant->sale_price > $maxSalePrice) {
                                $maxSalePrice = $variant->sale_price;
                            }
                        }// sản phẩm gốc 
                        if ($product->is_sale == 1) {
                            if ($variant->sale_price) {
                                if ($minSalePrice === null || $variant->sale_price < $minSalePrice) {
                                    $minSalePrice = $variant->sale_price;
                                }
                                if ($maxSalePrice === null || $variant->sale_price > $maxSalePrice) {
                                    $maxSalePrice = $variant->sale_price;
                                }
                            }
                        }
                        // XỬ LÝ THUỘC TÍNH BIẾN THỂ - CHỈ CHO BIẾN THỂ ACTIVE
                        $variantAttributes = [];
                        foreach ($variant->attributeValues as $variantAttributeValue) {
                            $variantAttributes[$variantAttributeValue->attribute->name] = $variantAttributeValue->value;
                        }
                        $productData['variant_attributes'][] = $variantAttributes;
                    }
                }
                // } //end-sale

                // Xác định giá và FORMAT GIÁ TRỰC TIẾP VỚI number_format (không có HTML)
                if ($minPrice !== null && $maxPrice !== null) { // CHỈ KHI CÓ BIẾN THỂ ACTIVE THÌ MỚI HIỂN THỊ GIÁ
                    if ($product->is_sale == 1 && $minSalePrice !== null && $maxSalePrice !== null) { // NẾU ĐANG SALE VÀ CÓ GIÁ SALE
                        if ($minSalePrice != $maxSalePrice) {
                            $productData['min_variant_price'] = number_format($minPrice);
                            $productData['max_variant_price'] = number_format($maxPrice);
                            $productData['min_variant_sale_price'] = number_format($minSalePrice);
                            $productData['max_variant_sale_price'] = number_format($maxSalePrice);
                        } else {
                            $productData['min_variant_price'] = number_format($minPrice);
                            $productData['max_variant_price'] = null;
                            $productData['min_variant_sale_price'] = number_format($minSalePrice);
                            $productData['max_variant_sale_price'] = null;
                        }
                    } else { // KHÔNG SALE HOẶC KHÔNG CÓ GIÁ SALE
                        if ($minPrice != $maxPrice) {
                            $productData['min_variant_price'] = number_format($minPrice);
                            $productData['max_variant_price'] = number_format($maxPrice);
                            $productData['min_variant_sale_price'] = null;
                            $productData['max_variant_sale_price'] = null;
                        } else {
                            $productData['min_variant_price'] = number_format($minPrice);
                            $productData['max_variant_price'] = null;
                            $productData['min_variant_sale_price'] = null;
                            $productData['max_variant_sale_price'] = null;
                        }
                    }
                } else {
                    $productData['min_variant_price'] = null;
                    $productData['max_variant_price'] = null;
                    $productData['min_variant_sale_price'] = null;
                    $productData['max_variant_sale_price'] = null;
                }
                $productData['is_sale'] = $product->is_sale; // Truyền trạng thái sale sang view
            } else { // Sản phẩm đơn
                $productData['price'] = number_format($product->price);
                $productData['sale_price'] = $product->is_sale == 1 && $product->sale_price ? number_format($product->sale_price) : null;
                $productData['is_sale'] = $product->is_sale; // Truyền trạng thái sale sang view
            }
            // // gán dữ liệu vào data

            // $productData['min_variant_price'] = $minPrice;
            // $productData['max_variant_price'] = $maxPrice;
            // $productData['min_variant_sale_price'] = $minSalePrice;
            // $productData['max_variant_sale_price'] = $maxSalePrice;

            // // set giá gốc về null

            // $productData['price'] = null;
            // $productData['sale_price'] = null;





            // 1. Xử lý THÔNG SỐ KỸ THUẬT (cho cả sản phẩm đơn và sản phẩm gốc của biến thể - is_variant = 0)
            foreach ($product->attributeValues as $attributeValue) {
                // **Lọc: Chỉ lấy attributeValues không phải là biến thể (is_variant = 0 hoặc null)**
                if (!$attributeValue->is_variant) { // Giả sử có trường 'is_variant' trong bảng attribute_values
                    $productData['specifications'][$attributeValue->attribute->name] = $attributeValue->value;
                }
            }

            // // 2. Xử lý THUỘC TÍNH BIẾN THỂ (chỉ cho sản phẩm biến thể - type = 1)
            // if ($product->isVariant()) { // Sử dụng method isVariant() đã định nghĩa trong model Product
            //     foreach ($product->productVariants as $variant) {
            //         $variantAttributes = [];
            //         foreach ($variant->attributeValues as $variantAttributeValue) {
            //             // **Lọc: Chỉ lấy attributeValues là biến thể (is_variant = 1)**
            //             if ($variantAttributeValue->is_active) { // Giả sử có trường 'is_variant' trong bảng attribute_values
            //                 $variantAttributes[$variantAttributeValue->attribute->name] = $variantAttributeValue->value;
            //             }
            //         }
            //         // Thêm thông tin biến thể vào mảng 'variant_attributes'
            //         $productData['variant_attributes'][] = $variantAttributes; // Mỗi phần tử là 1 biến thể, chứa mảng thuộc tính của biến thể đó
            //     }
            // }


            $productsData[] = $productData;
        }
        // dd($productsData);
        return $productsData;

    }







}