<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Product;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeValueProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batchSize = 20;
        $insertData = [];
        
        $attributeValues = AttributeValue::whereHas('attribute', function ($query) {
            return $query->where('is_variant', 0)->where('is_active', 1);
        })->where('is_active', 1)->pluck('id')->toArray();

        $products = Product::pluck('id')->toArray();

        foreach ($products as $productId) {
            $assignedAttributeValues = (array) array_rand(array_flip($attributeValues), rand(4, 6));
            
            foreach ($assignedAttributeValues as $attributeValueId) {
                $insertData[] = [
                    'attribute_value_id' => $attributeValueId,
                    'product_id' => $productId,
                ];
            }

            if (count($insertData) >= $batchSize) {
                DB::table('attribute_value_product')->insert($insertData);
                $insertData = [];
            }
        }

        if (!empty($insertData)) {
            DB::table('attribute_value_product')->insert($insertData);
        }
    }
}
