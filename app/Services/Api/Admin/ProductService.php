<?php

namespace App\Services\Api\Admin;

use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductStockRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Throw_;

class ProductService
{
    protected ProductRepository $productRepository;
    protected CategoryRepository $categoryRepository;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function storeSingle($data)
    {
        try {
            // Upload image
            $data['product']['thumbnail'] = Storage::put('products', $data['product']['thumbnail']);

            // Upload galleries
            $productGalleries = [];
            foreach ($data['product_galleries'] as $productGallery) {
                $productGalleries[] = Storage::put('product_galleries', $productGallery);
            }
            $data['product_galleries'] = $productGalleries;

            DB::beginTransaction();

            $product = $this->productRepository->create($data['product']);
            $product->productStock()->create($data['product_stocks']);
            $product->categories()->attach($this->attachCategory($data['category_id']));
            $product->attributeValues()->attach($data['product_specifications']);
            $product->tags()->attach($data['tags'] ?? []);
            $product->productAccessories()->attach($data['product_accessories'] ?? []);

            $data['product_galleries'] = array_map(function ($image) use ($product) {
                return [
                    'product_id' => $product->id,
                    'image' => $image
                ];
            }, $data['product_galleries']);
            $product->productGallery()->insert($data['product_galleries']);
            
            DB::commit();

            return ['success' => true, 'message' => 'Thêm sản phẩm mới thành công !'];
        }
        catch (\Throwable $e) {
            DB::rollBack();
            Log::error(
                __CLASS__ . '@' . __FUNCTION__,
                ['error' => $e->getMessage()]
            );

            return ['success' => false, 'message' => 'Lỗi hệ thống! Vui lòng thử lại sau ít phút.'];
            
        }
    }

    public function storeVariant($data)
    {
        try {
            // Upload image
            $data['product']['thumbnail'] = Storage::put('products', $data['product']['thumbnail']);

            // Upload galleries
            foreach ($data['product_galleries'] as $index => $productGallery) {
                $data['product_galleries'][$index] = Storage::put('product_galleries', $productGallery);
            }

            // Upload product variants image
            foreach ($data['product_variants'] as $index => $productVariant) {
                $data['product_variants'][$index]['info']['thumbnail'] = Storage::put('product_variants', $productVariant['info']['thumbnail']);
            }

            DB::beginTransaction();

            $product = $this->productRepository->create($data['product']);
            $product->categories()->attach($this->attachCategory($data['category_id']));
            $product->attributeValues()->attach($data['product_specifications']);
            $product->tags()->attach($data['tags'] ?? []);
            $product->productAccessories()->attach($data['product_accessories'] ?? []);

            $data['product_galleries'] = array_map(function ($image) use ($product) {
                return [
                    'product_id' => $product->id,
                    'image' => $image
                ];
            }, $data['product_galleries']);
            $product->productGallery()->insert($data['product_galleries']);

            foreach ($data['product_variants'] as $productVariant) {
                $productVariantNew = $product->productVariants()->create($productVariant['info']);
                $productVariantNew->attributeValues()->attach($productVariant['variant']);
                $productVariantNew->productStock()->create($productVariant['product_stocks']);
            }

            DB::commit();

            return ['success' => true, 'message' => 'Thêm sản phẩm mới thành công !'];
        }
        catch (\Throwable $e) {
            DB::rollBack();
            Log::error(
                __CLASS__ . '@' . __FUNCTION__,
                ['error' => $e->getMessage()]
            );

            return ['success' => false, 'message' => 'Lỗi hệ thống! Vui lòng thử lại sau ít phút.'];
        }
    }

    public function attachCategory($id)
    {
        $category = $this->categoryRepository->findWithChild($id, false);

        if (!empty($category->categories)) {
            $categoryChilds = [];
            
            foreach ($category->categories as $categoryChild) {
                $categoryChilds[] = $categoryChild->id;
            }

            return [$category->id, ...$categoryChilds];
        }

        return [$category->id];
    }
}