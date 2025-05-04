<?php

namespace App\Services\Api\Admin;

use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductStockRepository;
use App\Repositories\ProductVariantRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Throw_;

class ProductService
{
    protected CategoryRepository $categoryRepository;
    protected ProductRepository $productRepository;
    protected ProductVariantRepository $productVariantRepository;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        ProductVariantRepository $productVariantRepository,
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->productVariantRepository = $productVariantRepository;
    }

    public function getAllByIds(array $productIds)
    {
        try {
            $data = $this->productRepository->getAllByIds($productIds, ['id', 'name', 'sku', 'thumbnail'])->toArray();

            return ['success' => true, 'data' => $data];
        }
        catch (\Throwable $e) {
            Log::error(
                __CLASS__ . '@' . __FUNCTION__,
                ['error' => $e->getMessage()]
            );

            return ['success' => false, 'message' => 'Lỗi hệ thống! Vui lòng thử lại sau ít phút.'];
        }
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
            $product->categories()->attach([$data['category_id']]);
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
            $product->categories()->attach([$data['category_id']]);
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

    public function updateSingle($product, $data)
    {
        try {
            $oldThumbnail = $product->thumbnail;
            $oldGalleries = $product->productGallery;

            // Upload image
            if (isset($data['product']['thumbnail'])) {
                $data['product']['thumbnail'] = Storage::put('products', $data['product']['thumbnail']);
            }

            // Upload galleries
            if (isset($data['product_galleries'])) {
                $productGalleries = [];

                foreach ($data['product_galleries'] as $productGallery) {
                    $productGalleries[] = Storage::put('product_galleries', $productGallery);
                }

                $data['product_galleries'] = $productGalleries;
            }

            DB::beginTransaction();

            $product->update($data['product']);
            $product->categories()->sync([$data['category_id']]);
            $product->attributeValues()->sync($data['product_specifications']);
            $product->tags()->sync($data['tags'] ?? []);
            $product->productAccessories()->sync($data['product_accessories'] ?? []);

            if (isset($data['product_galleries'])) {
                $data['product_galleries'] = array_map(function ($image) use ($product) {
                    return [
                        'product_id' => $product->id,
                        'image' => $image
                    ];
                }, $data['product_galleries']);
                $product->productGallery()->delete();
                $product->productGallery()->insert($data['product_galleries']);
            }
            
            DB::commit();

            return ['success' => true, 'message' => 'Cập nhật sản phẩm thành công !'];
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

    public function updateVariant($product, $data)
    {
        try {
            $oldThumbnail = $product->thumbnail;
            $oldGalleries = $product->productGallery;
            $oldVariantThumbnails = $product->productVariants()->pluck('thumbnail', 'id');

            $dataVariantThumnailsUpdate = [];

            // Upload image
            if (isset($data['product']['thumbnail'])) {
                $data['product']['thumbnail'] = Storage::put('products', $data['product']['thumbnail']);
            }

            // Upload galleries
            if (isset($data['product_galleries'])) {
                $productGalleries = [];

                foreach ($data['product_galleries'] as $productGallery) {
                    $productGalleries[] = Storage::put('product_galleries', $productGallery);
                }

                $data['product_galleries'] = $productGalleries;
            }

            // Upload product variants image
            foreach ($data['product_variants'] as $index => $productVariant) {
                if (isset($productVariant['info']['thumbnail'])) {
                    $dataVariantThumnailsUpdate[] = $productVariant['id'];
                    $data['product_variants'][$index]['info']['thumbnail'] = Storage::put('product_variants', $productVariant['info']['thumbnail']);
                }
            }

            DB::beginTransaction();

            $product->update($data['product']);
            $product->categories()->sync([$data['category_id']]);
            $product->attributeValues()->sync($data['product_specifications']);
            $product->tags()->sync($data['tags'] ?? []);
            $product->productAccessories()->sync($data['product_accessories'] ?? []);
            foreach ($data['product_variants'] as $variant) {
                $this->productVariantRepository->findById($variant['id'])->update($variant['info']);
            }

            if (isset($data['product_galleries'])) {
                $data['product_galleries'] = array_map(function ($image) use ($product) {
                    return [
                        'product_id' => $product->id,
                        'image' => $image
                    ];
                }, $data['product_galleries']);
                $product->productGallery()->delete();
                $product->productGallery()->insert($data['product_galleries']);
            }

            DB::commit();

            return ['success' => true, 'message' => 'Cập nhật sản phẩm thành công !'];
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
}