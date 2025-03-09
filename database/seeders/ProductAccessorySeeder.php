<?php

namespace Database\Seeders;

use App\Models\Product;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAccessorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batchSize = 20;
        $insertData = [];

        $products = Product::pluck('id')->toArray();

        foreach ($products as $productId) {
            $assignedProducts = (array) array_rand(array_flip($products), rand(1, 3));
            
            foreach ($assignedProducts as $productAccessoryId) {
                $insertData[] = [
                    'product_accessory_id' => $productAccessoryId,
                    'product_id' => $productId,
                ];
            }

            if (count($insertData) >= $batchSize) {
                DB::table('product_accessory')->insert($insertData);
                $insertData = [];
            }
        }

        if (!empty($insertData)) {
            DB::table('product_accessory')->insert($insertData);
        }
    }
}
