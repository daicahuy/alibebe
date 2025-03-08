<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batchSize = 20;
        $insertData = [];
        
        $tags = Tag::pluck('id')->toArray();
        $products = Product::pluck('id')->toArray();

        foreach ($products as $productId) {
            $assignedTags = (array) array_rand(array_flip($tags), rand(1, 3));
            
            foreach ($assignedTags as $tagId) {
                $insertData[] = [
                    'tag_id' => $tagId,
                    'product_id' => $productId,
                ];
            }

            if (count($insertData) >= $batchSize) {
                DB::table('product_tag')->insert($insertData);
                $insertData = [];
            }
        }

        if (!empty($insertData)) {
            DB::table('product_tag')->insert($insertData);
        }
    }
}
