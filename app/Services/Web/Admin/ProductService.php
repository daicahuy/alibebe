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

            // Xử lý giá sản phẩm
            if ($product->type == 1) { // Sản phẩm biến thể
                $minPrice = null;
                $maxPrice = null;
                $minSalePrice = null;
                $maxSalePrice = null;

                foreach ($product->productVariants as $variant) {
                    if ($variant->is_active == 1) { // CHỈ XÉT BIẾN THỂ ACTIVE
                        // Giá gốc
                        if ($minPrice === null || $variant->price < $minPrice) {
                            $minPrice = $variant->price;
                        }
                        if ($maxPrice === null || $variant->price > $maxPrice) {
                            $maxPrice = $variant->price;
                        }

                        // Giá sale
                        if ($product->is_sale == 1 && $variant->sale_price !== null) {
                            if ($minSalePrice === null || $variant->sale_price < $minSalePrice) {
                                $minSalePrice = $variant->sale_price;
                            }
                            if ($maxSalePrice === null || $variant->sale_price > $maxSalePrice) {
                                $maxSalePrice = $variant->sale_price;
                            }
                        }
                    }
                }

                if ($minPrice !== null && $maxPrice !== null) {
                    if ($product->is_sale == 1 && $minSalePrice !== null && $maxSalePrice !== null) {
                        if ($minSalePrice != $maxSalePrice) {
                            $product->price_range = number_format($minPrice) . ' - ' . number_format($maxPrice) . ' VND' . "\n" . number_format($minSalePrice) . ' - ' . number_format($maxSalePrice) . ' VND';
                            $product->show_sale = true;
                            $product->original_price_display = number_format($minPrice) . ' - ' . number_format($maxPrice) . ' VND';
                        } else {
                            $product->price_range = number_format($minPrice) . ' VND' . "\n" . number_format($minSalePrice) . ' VND';
                            $product->show_sale = true;
                            $product->original_price_display = number_format($minPrice) . ' VND';
                        }
                    } else {
                        if ($minPrice != $maxPrice) {
                            $product->price_range = number_format($minPrice) . ' - ' . number_format($maxPrice) . ' VND';
                        } else {
                            $product->price_range = number_format($minPrice) . ' VND';
                        }
                        $product->show_sale = false;
                    }
                } else {
                    $product->price_range = 'Liên hệ';
                    $product->show_sale = false;
                }

            } else { // Sản phẩm đơn (type != 1)
                if ($product->is_sale == 1 && $product->sale_price !== null) {
                    $product->price_range = number_format($product->price) . ' VND' . "\n" . number_format($product->sale_price) . ' VND';
                    $product->show_sale = true;
                    $product->original_price_display = number_format($product->price) . ' VND';
                } else {
                    $product->price_range = $product->price ? number_format($product->price) . ' VND' : '';
                    $product->show_sale = false;
                }
            }

            // Lấy tổng stock quantity (không thay đổi)
            $stockQuantity = $product->totalStockQuantity;
            $product->stock_quantity = $stockQuantity;
        });

        // Lọc theo stockStatus
        $filteredProductsCollection = $products->getCollection(); // Lấy collection trước khi paginate
        if ($stockStatus) {
            $st = 10;
            $filteredProductsCollection = $products->getCollection()->filter(function ($product) use ($stockStatus, $st) {
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
            // Gán lại collection đã lọc vào đối tượng phân trang gốc
            $products->setCollection($filteredProductsCollection->values()); // Cập nhật collection trong đối tượng $products
        }

        $countTrash = $this->productRepository->countTrash();
        $countHidden = $this->productRepository->countHidden();


        // dd($products);
        return [
            'products' => $products,
            'countTrash' => $countTrash,
            'countHidden' => $countHidden,
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
                // if ($trash->productVariants->isNotEmpty()) {
                //     $minPrice = $trash->productVariants->min('price');
                //     $maxPrice = $trash->productVariants->max('price');

                //     if ($minPrice != $maxPrice) {
                //         $trash->price_range = number_format($minPrice, 0, ',', '.') . ' VND - ' . number_format($maxPrice, 0, ',', '.') . ' VND';
                //     } else {
                //         $trash->price_range = number_format($minPrice, 0, ',', '.') . ' VNĐ';
                //     }
                // } else {
                //     $trash->price_range = $trash->price ? number_format($trash->price, 0, ',', '.') . ' VND' : '';
                // }

                // Xử lý giá sản phẩm
                if ($trash->type == 1) { // Sản phẩm biến thể
                    $minPrice = null;
                    $maxPrice = null;
                    $minSalePrice = null;
                    $maxSalePrice = null;

                    foreach ($trash->productVariants as $variant) {
                        if ($variant->is_active == 1) { // CHỈ XÉT BIẾN THỂ ACTIVE
                            // Giá gốc
                            if ($minPrice === null || $variant->price < $minPrice) {
                                $minPrice = $variant->price;
                            }
                            if ($maxPrice === null || $variant->price > $maxPrice) {
                                $maxPrice = $variant->price;
                            }

                            // Giá sale
                            if ($trash->is_sale == 1 && $variant->sale_price !== null) {
                                if ($minSalePrice === null || $variant->sale_price < $minSalePrice) {
                                    $minSalePrice = $variant->sale_price;
                                }
                                if ($maxSalePrice === null || $variant->sale_price > $maxSalePrice) {
                                    $maxSalePrice = $variant->sale_price;
                                }
                            }
                        }
                    }

                    if ($minPrice !== null && $maxPrice !== null) {
                        if ($trash->is_sale == 1 && $minSalePrice !== null && $maxSalePrice !== null) {
                            if ($minSalePrice != $maxSalePrice) {
                                $trash->price_range = number_format($minPrice) . ' - ' . number_format($maxPrice) . ' VND' . "\n" . number_format($minSalePrice) . ' - ' . number_format($maxSalePrice) . ' VND';
                                $trash->show_sale = true;
                                $trash->original_price_display = number_format($minPrice) . ' - ' . number_format($maxPrice) . ' VND';
                            } else {
                                $trash->price_range = number_format($minPrice) . ' VND' . "\n" . number_format($minSalePrice) . ' VND';
                                $trash->show_sale = true;
                                $trash->original_price_display = number_format($minPrice) . ' VND';
                            }
                        } else {
                            if ($minPrice != $maxPrice) {
                                $trash->price_range = number_format($minPrice) . ' - ' . number_format($maxPrice) . ' VND';
                            } else {
                                $trash->price_range = number_format($minPrice) . ' VND';
                            }
                            $trash->show_sale = false;
                        }
                    } else {
                        $trash->price_range = 'Liên hệ';
                        $trash->show_sale = false;
                    }

                } else { // Sản phẩm đơn (type != 1)
                    if ($trash->is_sale == 1 && $trash->sale_price !== null) {
                        $trash->price_range = number_format($trash->price) . ' VND' . "\n" . number_format($trash->sale_price) . ' VND';
                        $trash->show_sale = true;
                        $trash->original_price_display = number_format($trash->price) . ' VND';
                    } else {
                        $trash->price_range = $trash->price ? number_format($trash->price) . ' VND' : '';
                        $trash->show_sale = false;
                    }
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

    public function getHidden($perPage, $keyword)
    {
        try {
            $listHidden = $this->productRepository->getHidden($perPage, $keyword);
            $listHidden->getCollection()->each(function ($hidden) {
                // Lấy giá biến thể
                // if ($hidden->productVariants->isNotEmpty()) {
                //     $minPrice = $hidden->productVariants->min('price');
                //     $maxPrice = $hidden->productVariants->max('price');

                //     if ($minPrice != $maxPrice) {
                //         $hidden->price_range = number_format($minPrice, 0, ',', '.') . ' VND - ' . number_format($maxPrice, 0, ',', '.') . ' VND';
                //     } else {
                //         $hidden->price_range = number_format($minPrice, 0, ',', '.') . ' VNĐ';
                //     }
                // } else {
                //     $hidden->price_range = $hidden->price ? number_format($hidden->price, 0, ',', '.') . ' VND' : '';
                // }

                // Giá sản phẩm biến thể
                if ($hidden->type == 1) {
                    $minPrice = null;
                    $maxPrice = null;
                    $minSalePrice = null;
                    $maxSalePrice = null;

                    foreach ($hidden->productVariants as $variant) {
                        if ($variant->is_active == 0 || $variant->is_active == 1) { // biến thể active

                            // Giá gốc
                            if ($minPrice === null || $variant->price < $minPrice) {
                                $minPrice = $variant->price;
                            }
                            if ($maxPrice === null || $variant->price > $maxPrice) {
                                $maxPrice = $variant->price;
                            }

                            // Giá sale
                            if ($hidden->is_sale == 1 && $variant->sale_price !== null) {
                                if ($minSalePrice === null || $variant->sale_price < $minSalePrice) {
                                    $minSalePrice = $variant->sale_price;
                                }
                                if ($maxSalePrice === null || $variant->sale_price > $maxSalePrice) {
                                    $maxSalePrice = $variant->sale_price;
                                }
                            }
                        }
                    }

                    if ($minPrice !== null && $maxPrice !== null) {
                        if ($hidden->is_sale == 1 && $minSalePrice !== null && $maxSalePrice !== null) {

                            if ($minSalePrice != $maxSalePrice) {
                                $hidden->price_range = number_format($minPrice) . '-' . number_format($maxPrice) . ' VND ' . "\n" . number_format($minSalePrice) .
                                    '-' . number_format($maxSalePrice) . ' VND ';
                                $hidden->show_sale = true;
                                $hidden->original_price_display = number_format($minPrice) . '-' . number_format($maxPrice) . ' VND ';
                            } else {
                                $hidden->price_range = number_format($minPrice) . ' VND ' . "\n" . number_format($minSalePrice) . ' VND ';
                                $hidden->show_sale = true;
                                $hidden->original_price_display = number_format($minPrice) . ' VND ';
                            }

                        } else {
                            if ($minPrice != $maxPrice) {
                                $hidden->price_range = number_format($minPrice) . '-' . number_format($maxPrice) . ' VND ';
                            } else {
                                $hidden->price_range = number_format($minPrice) . ' VND ';
                            }
                            $hidden->show_sale = false;
                        }
                    } else {
                        $hidden->price_range = 'Liên hệ';
                        $hidden->show_sale = false;
                    }

                } else { // sản phẩm đơn
                    if ($hidden->is_sale == 1 && $hidden->sale_price !== null) {
                        $hidden->price_range = number_format($hidden->price) . ' VND ' . "\n" . number_format($hidden->sale_price) . ' VND ';
                        $hidden->show_sale = true;
                        $hidden->original_price_display = number_format($hidden->price) . ' VND ';
                    } else {
                        $hidden->price_range = $hidden->price ? number_format($hidden->price) . ' VND ' : '';
                        $hidden->show_sale = false;
                    }
                }

                // Lấy tổng stock quantity thông qua Accessor (thuộc tính ảo) trong model hidden
                $stockQuantity = $hidden->totalStockQuantity;
                $hidden->stock_quantity = $stockQuantity;
            });
            // dd($listHidden);
            return $listHidden;
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
            // Đã kiểm tra khi xóa mềm
            // if ($this->orderItemRepository->hasOrderItems($productId)) {
            //     return [
            //         'success' => false,
            //         'message' => 'Sản phẩm này không thể xóa vĩnh viễn vì đang có trong đơn hàng. Vui lòng kiểm tra lại.'
            //     ];
            // }
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
        try { // try ngoài cùng - Bắt các lỗi tổng quan

            // 1. Kiểm tra đầu vào: Đảm bảo $productIds là mảng và không rỗng.
            if (!is_array($productIds) || empty($productIds)) {
                Log::warning(__METHOD__ . " - Input validation failed", ['product_ids' => $productIds]);
                return ['success' => false, 'message' => 'Vui lòng chọn ít nhất một sản phẩm.'];
            }

            // 2. KIỂM TRA ĐIỀU KIỆN DỪNG: Kiểm tra xem có bất kỳ sản phẩm nào có đơn hàng liên quan không.
            // LẤY DỮ LIỆU: Lấy sản phẩm với relationship orderItems

            $productsToCheckForOrders = $this->productRepository->getBulkTrash($productIds); // Đảm bảo method này chỉ lấy sản phẩm CHƯA XÓA MỀM và tải orderItems

            $productsWithOrdersIds = [];
            foreach ($productsToCheckForOrders as $product) {
                // KIỂM TRA: Nếu relationship orderItems không rỗng
                if ($product->orderItems->isNotEmpty()) {
                    $productsWithOrdersIds[] = $product->id;
                }
            }


            // NẾU CÓ SẢN PHẨM CÓ ĐƠN HÀNG LIÊN QUAN, DỪNG TOÀN BỘ THAO TÁC XÓA MỀM.
            if (!empty($productsWithOrdersIds)) {
                // Sửa: Thông báo chung, KHÔNG liệt kê IDs trong nội dung thông báo
                $message = "Không thể chuyển một số sản phẩm vào thùng rác vì đang có đơn hàng liên quan. Vui lòng xử lý đơn hàng trước khi xóa.";
                Log::warning(__METHOD__ . " - Some products have related orders, stopping bulk trash.", ['product_ids_with_orders' => $productsWithOrdersIds]);

                return [
                    'success' => false,
                    'message' => $message, // Nội dung thông báo không chứa IDs cụ thể
                    'failed_ids' => $productsWithOrdersIds // IDs vẫn được trả về trong failed_ids
                ];
            }
            // === KẾT THÚC PHẦN DỪNG ===


            // 3. Nếu không có sản phẩm nào có đơn hàng liên quan, tiến hành xóa mềm c
            DB::beginTransaction();
            try { // try bên trong - Bắt các lỗi xảy ra TRONG QUÁ TRÌNH thực hiện transaction database.


                $queryBuilderForProducts = $this->productRepository->getProductsByIds($productIds); // Sử dụng $productIds ban đầu


                // Cập nhật is_active về 0 (NGAY TRƯỚC KHI XÓA MỀM).
                $updateCount = $queryBuilderForProducts->update(['is_active' => 0]);

                // LẤY LẠI QUERY BUILDER:

                $queryBuilderAfterUpdate = $this->productRepository->getProductsByIds($productIds); // Sử dụng $productIds ban đầu


                // THAO TÁC DATABASE: Xóa mềm (SAU KHI CẬP NHẬT).
                $deleteCount = $queryBuilderAfterUpdate->delete();
                // === KẾT THÚC SỬA ĐỔI THỨ TỰ ===


                // 4. Kiểm tra 
                if ($updateCount === count($productIds) && $deleteCount === count($productIds)) {
                    // Nếu số lượng khớp, toàn bộ thao tác thành công.
                    DB::commit();

                    $message = "Đã chuyển vào thùng rác thành công cho " . count($productIds) . " sản phẩm.";
                    Log::info(__METHOD__ . " - Bulk trash successful.", ['product_ids' => $productIds]);

                    return [
                        'success' => true,
                        'message' => $message,
                        'failed_ids' => [] // Không có sản phẩm nào thất bại
                    ];
                } else {
                    // Nếu số lượng không khớp, toàn bộ thao tác thất bại.
                    DB::rollBack();

                    $message = "Đã xảy ra lỗi khi chuyển sản phẩm vào thùng rác. Vui lòng thử lại.";
                    Log::warning(
                        __METHOD__ . " - Số lượng product xóa/cập nhật không khớp. Rollback.",
                        [
                            'product_ids' => $productIds,
                            'delete_count' => $deleteCount,
                            'update_count' => $updateCount,
                        ]
                    );

                    return [
                        'success' => false,
                        'message' => $message,
                        'failed_ids' => $productIds
                    ];
                }

            } catch (\Throwable $th) {

                DB::rollBack(); // ROLLBACK transaction database.

                $message = "Đã xảy ra lỗi hệ thống trong quá trình chuyển sản phẩm vào thùng rác. Vui lòng thử lại sau.";
                Log::error(
                    __CLASS__ . '--@--' . __FUNCTION__,
                    ['error' => $th->getMessage(), 'product_ids' => $productIds]
                );

                return [
                    'success' => false,
                    'message' => $message, // Nội dung thông báo không chứa IDs cụ thể
                    'failed_ids' => $productIds // Toàn bộ danh sách ban đầu được coi là thất bại (IDs vẫn được trả về)
                ];
            }

        } catch (\Throwable $th) {

            // Log lỗi và trả về thông báo lỗi tổng quan.
            Log::error(__METHOD__ . " - Lỗi tổng quan.", ['error' => $th->getMessage(), 'product_ids' => $productIds]);
            return ['success' => false, 'message' => 'Đã có lỗi tổng quan khi xử lý danh sách sản phẩm. Vui lòng thử lại sau.'];
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

            if (!is_array($productIds) || empty($productIds)) {
                return [
                    'success' => false,
                    'message' => 'Vui lòng chọn sản phẩm và thử lại.'
                ];
            }
            // kiểm tra realion
            // $productIdsToDelete = [];
            // $productsInOrders = [];
            // foreach ($productIds as $productId) {
            //     if ($this->orderItemRepository->hasOrderItems($productId)) {
            //         $productsInOrders[] = $productId;
            //     } else {
            //         $productIdsToDelete[] = $productId; // được xóa
            //     }
            // }

            // if ($productsInOrders) {
            //     return [
            //         'success' => false,
            //         'message' => 'Có sản phẩm có trong đơn hàng không thể xóa vĩnh viễn.'
            //     ];
            // }

            // if (empty($productIdsToDelete)) { // gần như không thể lọt, vì check xóa mềm rồi
            //     return [
            //         'success' => false,
            //         'message' => 'Không có sản phẩm nào được xóa vĩnh viễn vì tất cả đều có trong đơn hàng.'
            //     ];
            // }





            DB::beginTransaction();
            try { // không có trong đơn hàng thì vào đây

                $deleteCount = $this->productRepository->bulkForceDeleteTrash($productIds);

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
