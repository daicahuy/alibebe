<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductVariant;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeValueProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $attributeValues = [
            [33, 9],
            [33, 8],
            [34, 9],
            [34, 8],
            [35, 9],
            [35, 8],
        ];

        $products = Product::query()->where('type', 1)->get();

        foreach ($products as $product) {
            foreach ($product->productVariants as $index => $productVariant) {
                $productVariant->attributeValues()->attach($attributeValues[$index]);
            }
        }
    }
}
