<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $this->fakeAttributeValue();
    }

    public function fakeAttributeValue()
    {
        $attributeValues = [
            // Kích thước màn hình  
            [
                'attribute_id' => 1,
                'value' => '6.1 inch',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 1,
                'value' => '6.7 inch',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 1,
                'value' => '7.9 inch',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],

            // Bộ nhớ RAM  
            [
                'attribute_id' => 2,
                'value' => '4GB',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 2,
                'value' => '8GB',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 2,
                'value' => '16GB',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],

            // Bộ nhớ trong  
            [
                'attribute_id' => 3,
                'value' => '64GB',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 3,
                'value' => '128GB',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 3,
                'value' => '256GB',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],

            // Hệ điều hành  
            [
                'attribute_id' => 4,
                'value' => 'iOS',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 4,
                'value' => 'Android',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 4,
                'value' => 'Windows',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],

            // Camera  
            [
                'attribute_id' => 5,
                'value' => '12MP',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 5,
                'value' => '48MP',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 5,
                'value' => '64MP',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],

            // Kích thước  
            [
                'attribute_id' => 6,
                'value' => '120 x 80 x 10 mm',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 6,
                'value' => '150 x 90 x 15 mm',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 6,
                'value' => '180 x 120 x 20 mm',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],

            // Trọng lượng  
            [
                'attribute_id' => 7,
                'value' => '150g',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 7,
                'value' => '200g',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 7,
                'value' => '250g',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],

            // Độ phân giải màn hình  
            [
                'attribute_id' => 8,
                'value' => '1920 x 1080',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 8,
                'value' => '2560 x 1440',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 8,
                'value' => '3840 x 2160',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],

            // Công nghệ màn hình  
            [
                'attribute_id' => 9,
                'value' => 'IPS',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 9,
                'value' => 'OLED',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 9,
                'value' => 'AMOLED',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],

            // Bộ xử lý  
            [
                'attribute_id' => 10,
                'value' => 'Intel Core i5',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 10,
                'value' => 'Intel Core i7',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 10,
                'value' => 'AMD Ryzen 5',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],

            // Màu sắc
            [
                'attribute_id' => 11,
                'value' => 'Màu đỏ',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 11,
                'value' => 'Màu xanh',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 11,
                'value' => 'Màu vàng',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 11,
                'value' => 'Màu đen',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'attribute_id' => 11,
                'value' => 'Màu trắng',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]
        ];

        DB::table('attribute_values')->insert($attributeValues);
    }
}
