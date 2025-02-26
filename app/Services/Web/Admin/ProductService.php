<?php

namespace App\Services\Web\Admin;

use App\Repositories\AttributeRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderItemRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TagRepository;
use DB;
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
        $attributes = $this->attributeRepository->getAllActive(['*'], ['attributeValues'])->toArray();
        $newAttributes = [];

        foreach ($attributes as $attribute) {
            $attributeName = $attribute['name'];
            $attributeValues = array_column($attribute['attribute_values'], 'value');

            $newAttributes[$attributeName] = $attributeValues;
        }

        return [
            'tags' => $this->tagRepository->getAll(),
            'brands' => $this->brandRepository->getAllActive(),
            'categories' => $this->categoryRepository->getParentActive(),
            'productAccessories' => $this->productRepository->getAllActive(),
            'attributes' => json_encode($newAttributes)
        ];
    }

    // Mạnh - listProducts - admin
    public function getProducts($perPage, $categoryId, $stockStatus, $keyword)
    {


        $products = $this->productRepository->getProducts($perPage, $categoryId, $stockStatus, $keyword);

        $products->getCollection()->each(function ($product) {

            // Lấy giá biến thể
            if ($product->productVariants->isNotEmpty()) {
                $minPrice = $product->productVariants->min('price');
                $maxPrice = $product->productVariants->max('price');

                if ($minPrice != $maxPrice) {
                    $product->price_range = number_format($minPrice, 0, ',', '.') . ' VND - ' . number_format($maxPrice, 0, ',', '.') . ' VND';
                } else {
                    $product->price_range = number_format($minPrice, 0, ',', '.') . ' VNĐ';
                }
            } else {
                $product->price_range = $product->price ? number_format($product->price, 0, ',', '.') . ' VND' : '';
            }


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

        $countTrash = $this->productRepository->countTrash();


        // dd($products);
        return [
            'products' => $products,
            'countTrash' => $countTrash,
        ];
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

    public function restore($id)
    {
        try {
            $product = $this->productRepository->findTrash($id);
            if (!$product) {
                return [
                    'success' => false, // có trong đơn hàng
                    'message' => 'Không tìm thấy sản phẩm. Vui lòng kiểm tra lại.'
                ];
            }

            $restoreSuccess = $this->productRepository->restore($id);
            if ($restoreSuccess) {
                return [
                    'success' => true, // có trong đơn hàng
                    'message' => 'Đã khôi phục thành công.'
                ];
            } else {
                return [
                    'success' => false, // có trong đơn hàng
                    'message' => 'Lỗi không thể khôi phục sản phẩm. Vui lòng thử lại sau.'
                ];
            }

        } catch (\Throwable $th) {
            log::error(
                __CLASS__ . '--@--' . __FUNCTION__,
                ['error' => $th->getMessage()]
            );

            return ['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau'];
        }
    }

    public function getTrash($perPage, $keyword)
    {
        try {
            $listTrashs = $this->productRepository->getTrash($perPage, $keyword);
            $listTrashs->getCollection()->each(function ($trash) {
                 // Lấy giá biến thể
            if ($trash->productVariants->isNotEmpty()) {
                $minPrice = $trash->productVariants->min('price');
                $maxPrice = $trash->productVariants->max('price');

                if ($minPrice != $maxPrice) {
                    $trash->price_range = number_format($minPrice, 0, ',', '.') . ' VND - ' . number_format($maxPrice, 0, ',', '.') . ' VND';
                } else {
                    $trash->price_range = number_format($minPrice, 0, ',', '.') . ' VNĐ';
                }
            } else {
                $trash->price_range = $trash->price ? number_format($trash->price, 0, ',', '.') . ' VND' : '';
            }

                // Lấy tổng stock quantity thông qua Accessor (thuộc tính ảo) trong model trash
                $stockQuantity = $trash->totalStockQuantity;
                $trash->stock_quantity = $stockQuantity;
            });
            // dd($listTrashs);
            return $listTrashs;
        } catch (\Throwable $th) {
            log::error(
                __CLASS__ . '--@--' . __FUNCTION__,
                ['error' => $th->getMessage()]
            );

            return ['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau'];
        }
    }

    // Xóa cứng
    public function forceDeleteProduct($productId)
    {
        try {
            $product = $this->productRepository->findTrash($productId);
            if (!$product) {
                return ['success' => false, 'message' => 'Sản phẩm không tồn tại trong thùng rác.'];
            }
            if ($this->orderItemRepository->hasOrderItems($productId)) {
                return [
                    'success' => false,
                    'message' => 'Sản phẩm này không thể xóa vĩnh viễn vì đang có trong đơn hàng. Vui lòng kiểm tra lại.'
                ];
            }
            DB::beginTransaction();
            try {

                $isDeleted = $this->productRepository->forceDeleteProduct($productId);

                if ($isDeleted) {
                    DB::commit();
                    return ['success' => true, 'message' => 'Đã xóa vĩnh viễn thành công.'];
                } else {
                    DB::rollBack();
                    return ['success' => false, 'message' => 'Không thể xóa. Vui lòng thử lại'];
                }
            } catch (\Throwable $th) {
                DB::rollBack();
                log::error(
                    __CLASS__ . '--@--' . __FUNCTION__,
                    ['error' => $th->getMessage()]
                );

                return ['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau'];
            }
        } catch (\Throwable $th) {
            Log::error(__METHOD__, ['error' => $th->getMessage(), 'product_id' => $productId]);
            return ['success' => false, 'message' => 'Đã có lỗi tổng quan. Vui lòng thử lại sau.'];
        }


    }


    // Bulk
    // Xóa mềm nhiều
    public function bulkTrash($productIds)
    {
        try { // try ngoài cùng

            if (!$productIds || !is_array($productIds) || empty($productIds)) {
                return ['success' => false, 'message' => 'Vui lòng chọn ít nhất một sản phẩm'];
            }

            $successIds = [];
            $failedIds = [];
            $orderItemIds = [];
            $variantProductIds = [];

            $products = $this->productRepository->getBulkTrash($productIds);

            $valiProducts = [];
            foreach ($products as $key => $product) {
                if ($product->orderItems->isNotEmpty()) {
                    $orderItemIds[] = $product->id;
                } else {
                    $valiProducts[] = $product->id;
                }
                // if ($product->type == 1) {
                //     $variantProductIds[] = $product->id;
                // }
            }

            DB::beginTransaction();
            try { // try bên trong - transaction

                if (!empty($valiProducts)) {
                    $queryBuilder = $this->productRepository->getwithTrashIds($valiProducts); // Lấy Query Builder 

                    $deleteCount = $queryBuilder->delete(); //  soft delete
                    $queryBuilder->update(['is_active' => 0]); // Cập nhật is_active (sử dụng lại Query Builder)


                    if ($deleteCount !== count($valiProducts)) {

                        Log::warning(
                            __METHOD__ . " - Số lượng product xóa không khớp ",
                            [
                                'expected' => count($valiProducts),
                                'actual' => $deleteCount,
                                'valid_product_ids' => $valiProducts,
                            ]
                        );
                        $successIds = []; // Coi như tất cả failed để đơn giản hóa
                        $failedIds = $valiProducts;
                    } else {
                        $successIds = $valiProducts;
                        $failedIds = [];
                    }

                    // XÓa mềm biến thể 
                    // if (!empty($variantProductIds)) {
                    //     $variantQueryBuilder = $this->productRepository->getwithTrashIds($variantProductIds)
                    //         ->where('type', 1)
                    //         ->with('productVariants');

                    //     $variantProducts = $variantQueryBuilder->get();

                    //     $totalVariantDeleteCount = 0;
                    //     foreach ($variantProducts as $mainProduct) {
                    //         $variantDeleteCount = $mainProduct->productVariants()->delete(); //xóa biến thể
                    //         $totalVariantDeleteCount += $variantDeleteCount;
                    //     }
                    //     Log::info(__METHOD__ . ' Xóa mềm ' . $totalVariantDeleteCount . 'biến thể của ' . count($variantProductIds));
                    // }
                }
                DB::commit();

            } catch (\Throwable $th) {
                DB::rollBack();
                log::error(
                    __CLASS__ . '--@--' . __FUNCTION__,
                    ['error' => $th->getMessage()]
                );
                return ['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau'];
            }


            $message = '';
            $status = true;


            if (!empty($failedIds)) {
                $message .= "Đã có lỗi xảy ra với các ID: " . implode(", ", $failedIds) . '.' . PHP_EOL;
                $status = false;
            }


            if (!empty($orderItemIds)) {
                $message .= "Các sản phẩm sau <b style='color:red;'>KHÔNG THỂ</b> chuyển vào thùng rác vì đang có đơn hàng liên quan ID: <b style='color:red;'> " . implode(", ", $orderItemIds) . '</b>.<br/>' . PHP_EOL;
                $status = false;
            }

            if (!empty($successIds)) {
                $message .= "Đã chuyển vào thùng rác thành công  ID: " . implode(", ", $successIds) . '.';
            }


            return [
                'success' => $status,
                'message' => nl2br($message), // Chuyển đổi newline thành <br>
                'failed_ids' => $failedIds
            ];

        } catch (\Throwable $th) {
            Log::error(__METHOD__, ['error' => $th->getMessage(), 'product_ids' => $productIds]);
            return ['success' => false, 'message' => 'Đã có lỗi tổng quan. Vui lòng thử lại sau.'];
        }
    }
    // Khôi phục nhiều 
    public function bulkRestoreTrash($productIds)
    {
        try {
            if (!is_array($productIds) || empty($productIds)) {
                return ['success' => false, 'message' => 'Vui lòng chọn sản phẩm'];
            }

            DB::beginTransaction();
            try {

                $restoreCount = $this->productRepository->bulkRestoreTrash($productIds);
                if ($restoreCount > 0) {
                    DB::commit();
                    return ['success' => true, 'message' => "Khôi phục thành công: {$restoreCount} sản phẩm"];
                } else {
                    DB::rollBack();
                    return [
                        'success' => false,
                        'message' => 'Không có sản phẩm nào được khôi phục. Vui lòng thử lại.'
                    ];
                }

            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error(
                    __CLASS__ . '--@--' . __FUNCTION__,
                    ['error' => $th->getMessage()]
                );
                return ['success' => false, 'message' => 'Đã xảy ra lỗi khi khôi phục sản phẩm. Vui lòng thử lại sau.'];
            }

        } catch (\Throwable $th) {
            Log::error(__METHOD__, ['error' => $th->getMessage(), 'product_ids' => $productIds]);
            return ['success' => false, 'message' => 'Đã có lỗi tổng quan. Vui lòng thử lại sau.'];
        }

    }


    // Xóa cứng nhiều 
    public function bulkFoceDeleteTrash($productIds)
    {
        try {

            if (!is_array($productIds) && empty($productIds)) {
                return [
                    'success' => false,
                    'message' => 'Vui lòng chọn sản phẩm và thử lại.'
                ];
            }
            // kiểm tra realion
            $productIdsToDelete = [];
            $productsInOrders = [];
            foreach ($productIds as $productId) {
                if ($this->orderItemRepository->hasOrderItems($productId)) {
                    $productsInOrders[] = $productId;
                } else {
                    $productIdsToDelete[] = $productId; // được xóa
                }
            }

            if ($productsInOrders) {
                return [
                    'success' => false,
                    'message' => 'Có sản phẩm có trong đơn hàng không thể xóa vĩnh viễn.'
                ];
            }

            if (empty($productIdsToDelete)) { // gần như không thể lọt, vì check xóa mềm rồi
                return [
                    'success' => false,
                    'message' => 'Không có sản phẩm nào được xóa vĩnh viễn vì tất cả đều có trong đơn hàng.'
                ];
            }





            DB::beginTransaction();
            try { // không có trong đơn hàng thì vào đây

                $deleteCount = $this->productRepository->bulkForceDeleteTrash($productIdsToDelete);

                if ($deleteCount > 0) {
                    DB::commit();

                    return [
                        'success' => true,
                        'message' => "Đã xóa vĩnh viễn thành công: {$deleteCount} sản phẩm"
                    ];
                } else {
                    DB::rollBack();

                    return [
                        'success' => false,
                        'message' => "Đã xóa vĩnh viễn KHÔNG thành công. Vui lòng kiểm tra lại."
                    ];
                }

            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error(
                    __CLASS__ . '--@--' . __FUNCTION__,
                    ['error' => $th->getMessage()]
                );
                return ['success' => false, 'message' => 'Đã xảy ra lỗi khi xóa vĩnh viễn sản phẩm. Vui lòng thử lại sau.'];
            }
        } catch (\Throwable $th) {
            Log::error(__METHOD__, ['error' => $th->getMessage(), 'product_ids' => $productIds]);
            return ['success' => false, 'message' => 'Đã có lỗi tổng quan. Vui lòng thử lại sau.'];
        }
    }

    public function getCategories()
    {
        $categories = $this->categoryRepository->getAllParentCate();
        // dd($categories);

        return $categories;
    }
}
