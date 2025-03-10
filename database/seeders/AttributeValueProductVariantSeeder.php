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
            [33, 4],
            [33, 5],
            [34, 4],
            [34, 5],
            [35, 4],
            [35, 5],
        ];

        $products = Product::query()->where('type', 1)->get();

        foreach ($products as $product) {
            foreach ($product->productVariants as $index => $productVariant) {
                $productVariant->attributeValues()->attach($attributeValues[$index]);
            }
        }
    }
}
