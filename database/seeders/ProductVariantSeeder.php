<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::where('type', 1)->get();

        foreach ($products as $product) {
            $insertProductVariants = [];
            $priceRandom = fake()->numberBetween(50000, 10000000);
            for ($i = 0; $i < 6; $i++) {
                $price = fake()->numberBetween($priceRandom, $priceRandom + 100000);
                $insertProductVariants[] = [
                    'product_id' => $product->id,
                    'sku' => fake()->unique()->numerify('SPBT-#####'),
                    'price' => $price,
                    'sale_price' => $product->is_sale ? ($price * 0.9) : null,
                    'thumbnail' => fake()->randomElement(['product_variants/product_variant_1.jpg', 'product_variants/product_variant_2.jpg', 'product_variants/product_variant_3.jpg']),
                    'is_active' => fake()->boolean(90),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            ProductVariant::query()->insert($insertProductVariants);
        }
    }
}