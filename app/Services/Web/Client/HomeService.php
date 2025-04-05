<?php

namespace App\Services\Web\Client;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeService
{
    protected CategoryRepository $categoryRepo;
    protected ProductRepository $productRepository;

    // Khởi tạo
    public function __construct(CategoryRepository $categoryRepo, ProductRepository $productRepository)
    {
        $this->categoryRepo = $categoryRepo;
        $this->productRepository = $productRepository;
    }


    public function listCategory()
    {
        return $this->categoryRepo->listCategory();
    }
    public function getTrendingProduct()
    {
        $trendingProducts = $this->productRepository->getTrendingProducts();

        if ($trendingProducts->isEmpty()) {
            return DB::table('products')
                ->leftJoin('reviews', function ($join) {
                    $join->on('reviews.product_id', '=', 'products.id')
                        ->where('reviews.is_active', 1); // Chỉ lấy đánh giá đã được duyệt
                })
                ->select(
                    'products.id',
                    'products.name',
                    'products.thumbnail',
                    'products.views',
                    'products.price',
                    DB::raw('COALESCE(NULLIF(products.sale_price, 0), products.price) as sale_price'),
                    DB::raw('COALESCE(AVG(reviews.rating), 0) as average_rating'), // Lấy điểm trung bình đánh giá
                    DB::raw('COUNT(reviews.id) as total_reviews'), // Đếm số lượng đánh giá đã duyệt
                    'products.views as views_count'
                )
                ->groupBy(
                    'products.id',
                    'products.name',
                    'products.thumbnail',
                    'products.views',
                    'products.price',
                    'products.sale_price'
                )
                ->orderByDesc('products.created_at')
                ->limit(12)
                ->get();



        }

        return $trendingProducts;
    }
    public function getBestSellerProductsToday()
    {
        return $this->productRepository->getBestSellerProductsToday();
    }

    public function topCategoriesInWeek()
    {
        return $this->categoryRepo->topCategoryInWeek();
    }
    public function bestSellingProduct()  {
        return $this->productRepository->bestSellingProduct();
    }
    public function getProductByView()
    {
        return $this->productRepository->getProductByView();
    }
    public function detailModal($id)
    {
        try {
            $product = $this->productRepository->detailModal($id) ?? 0;

            if (!$product) {
                throw new ModelNotFoundException('Không tìm thấy sản phẩm.');
            }
            $avgRating = $product->reviews->avg('rating');

            // **CHỈNH SỬA QUAN TRỌNG: Tính toán sold_count TRƯỚC VÒNG LẶP và truyền vào map**
            $productVariants = $product->productVariants->map(function ($variant) use ($product) { // **USE $product để truyền product ID nếu cần**
                return [
                    'id' => $variant->id,
                    'price' => $variant->price,
                    'sale_price' => $variant->sale_price,
                    'display_price' => $variant->display_price,
                    'original_price' => $variant->original_price,
                    'thumbnail' => Storage::url($variant->thumbnail),
                    'is_active' => $variant->is_active,
                    'attribute_values' => $variant->attributeValues->map(function ($attributeValue) {
                        return [
                            'id' => $attributeValue->id,
                            'attribute_value' => $attributeValue->value,
                            'attributes_name' => $attributeValue->attribute->name,
                            'attributes_slug' => $attributeValue->attribute->slug,
                        ];
                    }),
                    'product_stock' => $variant->productStock ?
                        [
                            "product_id" => $variant->productStock->product_id,
                            'product_variant_id' => $variant->productStock->product_variant_id,
                            'stock' => $variant->productStock->stock,
                        ] : [],
                    // **TÍNH TOÁN sold_count TRONG VÒNG LẶP MAP, ĐẢM BẢO TÍNH CHO TỪNG BIẾN THỂ**
                    'sold_count' => $variant->getSoldQuantity(), // **ĐẢM BẢO GỌI getSoldQuantity() CHO TỪNG $variant**
                ];
            });

            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'display_price' => $product->display_price,
                'original_price' => $product->original_price,
                'thumbnail' => Storage::url($product->thumbnail),
                'short_description' => $product->short_description,
                'categories' => $product->categories->pluck('name')->implode(', '),
                'brand' => $product->brand ? $product->brand->name : null,
                'avgRating' => $avgRating,
                'productVariants' => $productVariants,
                'sold_count' => $product->getSoldQuantity(), // Vẫn giữ lại tổng sold_count của sản phẩm gốc (nếu cần)
                'is_sale' => $product->is_sale,
                'stock' => $product->stock,
            ];
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function getAllCategories()
    {
        return $this->categoryRepo->getAllCategories();
    }

    public function getSuggestions(string $query, int $limit = 10)
    {
        return $this->productRepository->searchProductsByName($query, $limit);
    }

    public function getProductsByQuery(string $query)
    {
        return $this->productRepository->searchProducts($query);
    }
}
;