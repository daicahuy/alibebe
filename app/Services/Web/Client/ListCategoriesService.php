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
            $childProductCount = 0;
            // $parentProductCount = $category->products()->count();
            // $childProductCount += $parentProductCount;
            foreach ($category->categories as $childCategory) {
                if ($childCategory->is_active == 1) {
                    $childProductCount += $childCategory->products()->count();
                }
                $category->child_products_count = $childProductCount;
                // $category->products_count = $parentProductCount;
            }
        }

        return $categories;
    }

    public function getAllReviews()
    {
        $listStar = $this->reviewRepo->getAllReviews();
        return $listStar;
    }

    public function listVariantAttributes($category = null)
    {
        $variantAttributes = $this->attributeValueRepo->getVariantAttributesWithCounts($category);


        // dd($variantAttributes);
        $groupedAttributes = $variantAttributes->groupBy('attribute.name');

        return $groupedAttributes;

    }

    public function listProductCate($category, $perpage, $sortBy , $currentFilters  )
    {
        $listProductCate = $this->productRepo->getAllProductCate($category, $perpage, $sortBy, $currentFilters);

        return $listProductCate;

    }

    // public function isChecked($listVariantAttributes, $currentFilters)
    // {
    //     \Log::info('--- isChecked() method START ---');
    //     \Log::info('Current Filters (RAW in Service): ' . json_encode($currentFilters)); // Log RAW $currentFilters
    
    //     foreach ($listVariantAttributes as $attrName => $attrValues) {
    //         \Log::info('Processing Attribute (RAW Name): ' . $attrName); // Log RAW Attribute Name
    
    //         // **LẤY GIÁ TRỊ FILTER REQUEST TRỰC TIẾP TỪ $currentFilters, KHÔNG SLUG, KHÔNG LOWERCASE**
    //         $filterValuesRequest = $currentFilters[$attrName] ?? []; // **SỬ DỤNG $attrName TRỰC TIẾP làm key**
    //         \Log::info('Filter Values Request (RAW): ' . json_encode($filterValuesRequest)); // Log RAW $filterValuesRequest
    
    //         foreach ($attrValues as $attrValue) {
    //             \Log::info('  Checking Attribute Value (RAW): ' . $attrValue->value); // Log RAW Attribute Value
    
    //             // **SO SÁNH TRỰC TIẾP, KHÔNG TRIM, KHÔNG LOWERCASE**
    //             $isCheckedResult = in_array($attrValue->value, $filterValuesRequest);
    //             \Log::info('  in_array() result (RAW compare): ' . ($isCheckedResult ? 'true' : 'false')); // Log kết quả so sánh RAW
    
    //             if ($isCheckedResult) {
    //                 $attrValue->isChecked = true;
    //                 \Log::info('  Setting isChecked to true for (RAW): ' . $attrValue->value);
    //             } else {
    //                 $attrValue->isChecked = false;
    //                 \Log::info('  Setting isChecked to false for (RAW): ' . $attrValue->value);
    //             }
    //         }
    //         \Log::info('Finished processing Attribute (RAW Name): ' . $attrName);
    //     }
    
    //     \Log::info('--- isChecked() method END ---');
    //     return $listVariantAttributes;
    // }
    public function detailModal($id)
    {
        try {
            $product = $this->productRepo->detailModal($id);

            if (!$product) {
                throw new ModelNotFoundException('Không tìm thấy sản phẩm.');
            }
            // dd($product);
            $productVariants = $product->productVariants->map(function ($variant) { //sản phẩm biến thể
                return [
                    // 'sku' => $variant->sku,
                    'id' => $variant->id, // id biến thể
                    'price' => $variant->price,
                    'sale_price' => $variant->sale_price,
                    'thumbnail' => Storage::url($variant->thumbnail),
                    'attribute_values' => $variant->attributeValues->map(function ($attributeValue) { //bảng attribute_values (giá trị thuộc tính, xanh 4GB..)
                        return [
                            'id' => $attributeValue->id, //id giá trị thuộc tính
                            // 'attribute_id' => $attributeValue->attribute_id,//id liên kết thuộc tính
                            'attribute_value' => $attributeValue->value,            //Giá trị thuộc tính 
                            'attributes_name' => $attributeValue->attribute->name, //tên thuộc tính (table attributes)
                        ];
                    }),


                ];
            });
            // dd($productVariants);

            return [
                'id' => $product->id, //id sản phẩm
                'name' => $product->name,
                'price' => $product->price,
                'thumbnail' => Storage::url($product->thumbnail),
                'description' => $product->description,
                'categories' => $product->categories->pluck('name')->implode(', '),
                'brand' => $product->brand ? $product->brand->name : null,
                'productVariants' => $productVariants,
            ];
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }




}