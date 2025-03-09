<?php

namespace Database\Seeders;

use App\Models\Product;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductGalleriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batchSize = 20;
        $insertData = [];
        
        $productGalleries = [
            'product_galleries/lenovo_1.png',
            'product_galleries/lenovo_2.png',
            'product_galleries/lenovo_3.png',
            'product_galleries/lenovo_4.png',
        ];
        $products = Product::pluck('id')->toArray();

        foreach ($products as $productId) {
            foreach ($productGalleries as $productGallery) {
                $insertData[] = [
                    'product_id' => $productId,
                    'image' => $productGallery,
                ];

                if (count($insertData) >= $batchSize) {
                    DB::table('product_galleries')->insert($insertData);
                    $insertData = [];
                }
            }
        }

        if (!empty($insertData)) {
            DB::table('product_galleries')->insert($insertData);
        }
    }
}
