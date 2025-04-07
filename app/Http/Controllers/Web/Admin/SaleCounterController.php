<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Enums\ProductType;
use Illuminate\Support\Facades\Storage;

class SaleCounterController extends Controller
{
    public function index()
    {
        $products = Product::with([
            'productVariants.productStock',
            'categories',
            'productStock',
            'productVariants.attributeValues.attribute'
        ])
        ->where('is_active', true)
        ->orderByDesc('created_at')
        ->paginate(12);

        $formattedProducts = $products->map(function ($product) {
            return $this->formatProductData($product);
        });

        dd($products);

        return view('admin.pages.pos.index', [
            'products' => $formattedProducts,
            'pagination' => $products
        ]);
    }

    private function formatProductData($product)
    {
        $data = [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'thumbnail' => Storage::url($product->thumbnail),
            'type' => $product->type,
            'price' => $product->display_price,
            'original_price' => $product->original_price,
            'is_sale' => $product->is_sale,
            'stock' => $product->total_stock_quantity,
            'variants' => [],
            'min_price' => $product->display_price,
            'max_stock' => 0,
            'category' => optional($product->categories->first())->name,
            'average_rating' => $product->average_rating,
            'total_sold' => $product->total_sold
        ];

        if ($product->isVariant()) {
            $variants = $product->productVariants->map(function ($variant) {
                return [
                    'id' => $variant->id,
                    'price' => $variant->display_price,
                    'original_price' => $variant->original_price,
                    'is_sale' => $variant->is_sale,
                    'stock' => $variant->productStock->stock ?? 0,
                    'attributes' => $variant->attributeValues->map(function ($av) {
                        return [
                            'name' => $av->attribute->name,
                            'value' => $av->attribute_value
                        ];
                    }),
                    'thumbnail' => Storage::url($variant->thumbnail)
                ];
            })->toArray();

            $data['variants'] = $variants;
            $data['min_price'] = collect($variants)->min('price') ?? 0;
            $data['max_stock'] = collect($variants)->sum('stock');
        } else {
            $data['max_stock'] = $product->productStock->stock ?? 0;
        }

        return $data;
    }
}