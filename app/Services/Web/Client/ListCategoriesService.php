<?php

namespace App\Services\Web\Client;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Repositories\AttributeRepository;
use App\Repositories\AttributeValueRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ReviewRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PHPUnit\Event\Runtime\PHP;

class ListCategoriesService
{

    // Gọi ra cate
    protected CategoryRepository $categoryRepo;
    protected ProductRepository $productRepo;
    protected AttributeValueRepository $attributeValueRepo;
    protected ReviewRepository $reviewRepo;


    // Khởi tạo
    public function __construct(CategoryRepository $categoryRepo, ProductRepository $productRepo, AttributeValueRepository $attributeValueRepo, ReviewRepository $reviewRepo)
    {
        $this->categoryRepo = $categoryRepo;
        $this->productRepo = $productRepo;
        $this->attributeValueRepo = $attributeValueRepo;
        $this->reviewRepo = $reviewRepo;

    }

    public function listParentCate()
    {
        // Lấy danh sách category 

        $categories = $this->categoryRepo->getAllParentCate();

        foreach ($categories as $category) {
            // Đếm sản phẩm active của danh mục cha
            $parentProductCount = $category->products()
                ->where('is_active', 1)
                ->count();

            // Đếm sản phẩm active từ các danh mục con
            $childProductCount = 0;
            foreach ($category->categories as $childCategory) {
                $childProductCount += $childCategory->products()
                    ->where('is_active', 1)
                    ->count();
            }

            $category->products_count = $parentProductCount;
            $category->child_products_count = $childProductCount;
        }

        return $categories;
    }

    public function getAllReviews($category = null)
    {
        // $listStar = $this->reviewRepo->getAllReviews($category = null);
        // return $listStar;

        // $data = $this->reviewRepo->getAllReviews();
        // $listStar = $data->pluck('rating')->unique()->sortByDesc(function ($rating) {
        //     return $rating;
        // })->values();
        // return $listStar;

        if ($category) {
            return $this->reviewRepo->getCategoryProductRatings($category);
        }
        $ratings = $this->reviewRepo->getAllReviews()->pluck('rating')->toArray();
        // dd($ratings);
        return $ratings;
    }

    public function listVariantAttributes($category = null)
    {
        $variantAttributes = $this->attributeValueRepo->getVariantAttributesWithCounts($category);


        // dd($variantAttributes);
        $groupedAttributes = $variantAttributes->groupBy('attribute.name');

        return $groupedAttributes;

    }

    public function listProductCate($perpage, $sortBy, $filters)
    {
        $listProductCate = $this->productRepo->getAllProductCate($perpage, $sortBy, $filters);

        return $listProductCate;

    }


    public function detailModal($id)
    {
        try {
            $product = $this->productRepo->detailModal($id) ?? 0;

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



}