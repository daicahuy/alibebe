<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            if ($product->isSingle()) {
                $product->productStock()->create(['stock' => rand(1, 500)]);
            }
            else if ($product->isVariant()) {
                foreach ($product->productVariants as $productVariant) {
                    $productVariant->productStock()->create(['stock' => rand(1, 500)]);
                }
            }
        }
    }
}
