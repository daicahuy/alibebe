<?php

namespace App\Services\Web\Client;

use App\Repositories\ProductRepository;
use Cookie;
use Exception;
use Log;
use Storage;
class CompareService
{
    protected ProductRepository $productRepo;
    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    // public function addProductToCompare($productId)
    // {
    //     // Lấy session driver 'compare'
    //     $compareSession = app('session')->driver('compare');

    //     $comparedProducts = $compareSession->get('compared_products', []);

    //     // Kiểm tra giới hạn 3 sản phẩm
    //     if (count($comparedProducts) >= 3) {
    //         throw new \Exception('So sánh tối đa 3 sản phẩm.');
    //     }

    //     $product = $this->productRepo->getById($productId);
    //     $productCategory = $product->categories->first();
    //     $productCategoryId = $productCategory ? $productCategory->id : null;

    //     // Kiểm tra danh mục
    //     if (empty($comparedProducts)) {
    //         if ($productCategoryId) {
    //             $compareSession->put('compared_category_id', $productCategoryId);
    //         } else {
    //             throw new \Exception('Sản phẩm phải thuộc ít nhất một danh mục.');
    //         }
    //     } else {
    //         $sessionCategoryId = $compareSession->get('compared_category_id');
    //         if ($sessionCategoryId !== $productCategoryId) {
    //             throw new \Exception('Vui lòng chọn sản phẩm cùng danh mục.');
    //         }
    //     }

    //     // Thêm sản phẩm vào session compare
    //     $comparedProducts[] = $productId;
    //     $compareSession->put('compared_products', $comparedProducts);

    //     // Trả về số lượng hiện tại
    //     return count($comparedProducts);
    // }


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
    // public function addProductToCompare($productId)
    // {

    //     $comparedProducts = session()->get('compared_products', []);

    //     if (count($comparedProducts) >= 3) {
    //         throw new \Exception('So sánh tối đa 3 sản phẩm.');
    //     }

    //     $product = $this->productRepo->getById($productId);
    //     $productCategory = $product->categories->first();
    //     $productCategoryId = $productCategory ? $productCategory->id : null;


    //     if (empty($comparedProducts)) {
    //         if ($productCategoryId) {
    //             session()->put('compared_category_id', $productCategoryId);
    //         } else {
    //             throw new \Exception('Sản phẩm phải thuộc ít nhất một danh mục.');
    //         }
    //     } else {
    //         $sessionCategoryId = session()->get('compared_category_id');
    //         if ($sessionCategoryId !== $productCategoryId) {
    //             throw new \Exception('Vui lòng chọn sản phẩm cùng danh mục.');
    //         }
    //     }
    //     session()->push('compared_products', $productId);

    //     $count = count(session()->get('compared_products'));
    //     return $count;
    // }

    // Xóa sản phẩm trong trang compare

    // add backend
    // public function addProductToCompareList(int $productId): void
    // {
    //     Log::info('[CompareService@addProductToCompareList] productId: ' . $productId); // Log product ID nhận được trong service
    //     $compareList = $this->getCompareList();
    //     Log::info('[CompareService@addProductToCompareList] Current compareList from cookie: ' . json_encode($compareList)); // Log danh sách hiện tại từ cookie

    //     if (!in_array($productId, $compareList)) {
    //         $compareList[] = $productId;
    //         Log::info('[CompareService@addProductToCompareList] productId ' . $productId . ' added to compareList. New compareList: ' . json_encode($compareList)); // Log danh sách sau khi thêm
    //         $this->saveCompareList($compareList);
    //         Log::info('[CompareService@addProductToCompareList] saveCompareList called.'); // Log khi gọi saveCompareList
    //     } else {
    //         Log::info('[CompareService@addProductToCompareList] productId ' . $productId . ' already in compareList.'); // Log nếu sản phẩm đã có trong list
    //     }
    // }


    public function removeProductFromCompareList(int $productId): void
{
    $compareList = $this->getCompareList();
    // Lọc chính xác theo ID và kiểu dữ liệu
    $updatedCompareList = array_filter($compareList, function ($id) use ($productId) {
        return $id !== $productId;
    });
    $this->saveCompareList(array_values($updatedCompareList));
}
    
    // Lấy danh sách sản phẩm so sánh (ví dụ, từ Cookie).
    public function getCompareList(): array
{
    $compareCookie = Cookie::get('compare_list');
    if ($compareCookie) {
        $ids = json_decode($compareCookie, true) ?? [];
        return array_map('intval', $ids); // Chuyển tất cả ID thành integer
    }
    return [];
}
public function saveCompareList(array $compareList): void // Hàm saveCompareList (ví dụ dùng Cookie::queue)
    {
        Cookie::queue('compare_list', json_encode($compareList), 60 * 24 * 30); // Lưu cookie bằng Cookie::queue (MÃ HÓA)
    }


    // 
    // public function removeProductFromCompare($productId)
    // {

    //     $comparedProducts = session()->get('compared_products', []);

    //     $comparedProducts = array_filter($comparedProducts, function ($id) use ($productId) {
    //         return $id != $productId;
    //     });
    //     session()->put('compared_products', $comparedProducts);

    //     if (empty(session()->get('compared_products'))) {
    //         session()->forget('compared_category_id');
    //     }

    //     $count = count(session()->get('compared_products'));
    //     return $count;
    // }

    // public function getCompareCount()
    // {

    //     $count = count(session()->get('compared_products', []));
    //     return $count;
    // }

    // public function getComparedProducts()
    // {

    //     $comparedproductIds = session()->get('compared_products', []);

    //     $products = $this->productRepo->getByIds($comparedproductIds);
    //     return $products;
    // }

    // public function clearCompareSession()
    // {

    //     session()->forget('compared_products');
    //     session()->forget('compared_category_id');
    //     return;
    // }

}