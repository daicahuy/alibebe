<?php

namespace App\Services\Web\Client;

use App\Models\ProductVariant;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class DetailProductService
{
    protected $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProductDetail(int $id, array $columns = ['*'])
    {
        $product = $this->productRepository->findById($id, $columns);

        $product->related_products = $this->productRepository->getRelatedProducts($product);

        $totalReviews = $product->reviews->count();

        $averageRating = $totalReviews > 0 ? round($product->reviews->avg('rating'), 1) : 0;

        $product->totalReviews = $totalReviews;
        $product->averageRating = $averageRating;

        return $product;
    }
    public function detailModal($id)
    {
        try {
            $product = $this->productRepository->detailModal($id) ?? 0;

            if (!$product) {
                throw new ModelNotFoundException('Không tìm thấy sản phẩm.');
            }
            $avgRating = $product->reviews->avg('rating');
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
                            'attributes_slug' => $attributeValue->attribute->slug, //tên thuộc tính (table attributes)
                        ];
                    }),
                    'product_stock' => $variant->productStock ? //hAS ONE :))))
                         [
                            "product_id" => $variant->productStock->product_id,
                            'product_variant_id' => $variant->productStock->product_variant_id,            
                            'stock' => $variant->productStock->stock, 
                        ] : [],
                    


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
                // 'reviews' => $product->reviews ? $product->reviews : null,
                'avgRating' => $avgRating,
                'productVariants' => $productVariants,
            ];
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
