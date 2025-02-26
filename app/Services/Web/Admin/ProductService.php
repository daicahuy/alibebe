<?php

namespace App\Services\Web\Admin;

use App\Repositories\AttributeRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderItemRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TagRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Log;

class ProductService
{
    protected TagRepository $tagRepository;
    protected BrandRepository $brandRepository;
    protected CategoryRepository $categoryRepository;
    protected ProductRepository $productRepository;
    protected AttributeRepository $attributeRepository;
    protected OrderItemRepository $orderItemRepository;

    public function __construct(
        TagRepository $tagRepository,
        BrandRepository $brandRepository,
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository,
        AttributeRepository $attributeRepository,
        OrderItemRepository $orderItemRepository,
    ) {
        $this->tagRepository = $tagRepository;
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->attributeRepository = $attributeRepository;
        $this->orderItemRepository = $orderItemRepository;
    }

    public function getData()
    {
        $attributeSpecifications = $this->attributeRepository->getAllActive(['*'], ['attributeValues'], 0)->toArray();
        $attributeVariants = $this->attributeRepository->getAllActive(['*'], ['attributeValues'])->toArray();
        $newAttributeSpecifications = [];
        $newAttributeVariants = [];

        foreach ($attributeSpecifications as $attribute) {  
            $attributeName = $attribute['name'];
            $attributeValues = array_column($attribute['attribute_values'], 'value', 'id');
            
            $newAttributeSpecifications[$attributeName] = $attributeValues;
        }

        foreach ($attributeVariants as $attribute) {  
            $attributeName = $attribute['name'];
            $attributeValues = array_column($attribute['attribute_values'], 'value', 'id');
            
            $newAttributeVariants[$attributeName] = $attributeValues;
        }

        return [
            'tags' => $this->tagRepository->getAll(),
            'brands' => $this->brandRepository->getAllActive(),
            'categories' => $this->categoryRepository->getParentActive(),
            'productAccessories' => $this->productRepository->getAllActive(),
            'attributeSpecifications' => json_encode($newAttributeSpecifications),
            'attributeVariants' => json_encode($newAttributeVariants),
        ];
    }

    // Mạnh - listProducts - admin
    public function getProducts($perPage, $categoryId, $stockStatus, $keyword)
    {


        $products = $this->productRepository->getProducts($perPage, $categoryId, $stockStatus, $keyword);

        $products->getCollection()->each(function ($product) {
            // Lấy tổng stock quantity thông qua Accessor (thuộc tính ảo) trong model product
            $stockQuantity = $product->totalStockQuantity;
            $product->stock_quantity = $stockQuantity;
        });

        // Lọc theo stockStatus
        if ($stockStatus) {
            $st = 10;
            $filteredProducts = $products->getCollection()->filter(function ($product) use ($stockStatus, $st) {
                switch ($stockStatus) {
                    case 'in_stock':
                        return $product->stock_quantity > $st;

                    case 'out_of_stock':
                        return $product->stock_quantity == 0;

                    case 'low_stock':
                        return $product->stock_quantity <= $st && $product->stock_quantity > 0;

                    default:
                        return true;
                }
            });
            // Tạo lại paginate
            $products = new LengthAwarePaginator(
                $filteredProducts->values()->all(),
                $filteredProducts->count(),
                $products->perPage(),
                $products->currentPage(),
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }




        // dd($products);
        return $products;
    }

    // xóa mềm product
    public function delete($productId)
    {
        try {

            $product = $this->productRepository->find($productId);
            // dd($product);

            if (!$product) {
                return [
                    'success' => false, // có trong đơn hàng
                    'message' => 'Không tìm thấy sản phẩm. Vui lòng kiểm tra lại.'
                ];
            }


            if ($this->orderItemRepository->isProductInOrderItems($productId)) {
                return [
                    'success' => false, // có trong đơn hàng
                    'message' => 'Không thể xóa sản phẩm đang thuộc đơn hàng. Vui lòng kiểm tra lại.'
                ];
            } else {
                $deleteSuccess = $this->productRepository->delete($productId);
                if ($deleteSuccess) {
                    return [
                        'success' => true, // có trong đơn hàng
                        'message' => 'Đã chuyển sản phẩm vào thùng rác.'
                    ];
                } else {
                    return [
                        'success' => false, // có trong đơn hàng
                        'message' => 'Lỗi không thể xóa sản phẩm. Vui lòng thử lại sau.'
                    ];
                }
            }
        } catch (\Throwable $th) {

            log::error(
                __CLASS__ . '--@--' . __FUNCTION__,
                ['error' => $th->getMessage()]
            );

            return ['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau'];
        }
    }


    public function getCategories()
    {
        $categories = $this->categoryRepository->getAllParentCate();
        // dd($categories);

        return $categories;
    }
}
