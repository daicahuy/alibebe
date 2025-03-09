<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batchSize = 20;
        $insertData = [];
        
        $categories = Category::pluck('id')->toArray();
        $products = Product::pluck('id')->toArray();

        foreach ($products as $productId) {
            $assignedCategories = (array) array_rand(array_flip($categories), rand(1, 3));
            
            foreach ($assignedCategories as $categoryId) {
                $insertData[] = [
                    'category_id' => $categoryId,
                    'product_id' => $productId,
                ];
            }

            if (count($insertData) >= $batchSize) {
                DB::table('category_product')->insert($insertData);
                $insertData = [];
            }
        }

        if (!empty($insertData)) {
            DB::table('category_product')->insert($insertData);
        }
    }
}
