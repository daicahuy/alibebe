<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    }

    public function fakeCategory()
    {  

        $categories = [  
            [  
                'parent_id' => null,  
                'icon' => 'categories/category_accessory.svg',  
                'name' => 'Phụ kiện đi kèm',  
                'slug' => 'phu-kien-di-kem',  
                'ordinal' => 1,  
                'is_active' => 0,  
                'created_at' => now(),  
                'updated_at' => now(),  
            ],  
            [  
                'parent_id' => null,  
                'icon' => 'categories/category_laptop.svg',
                'name' => 'Laptop',  
                'slug' => 'laptop',  
                'ordinal' => 2,  
                'is_active' => 1,  
                'created_at' => now(),  
                'updated_at' => now(),  
            ],  
            [  
                'parent_id' => null,  
                'icon' => 'categories/category_pc.svg',
                'name' => 'PC',  
                'slug' => 'pc',  
                'ordinal' => 3,  
                'is_active' => 1,  
                'created_at' => now(),  
                'updated_at' => now(),  
            ],  
            [  
                'parent_id' => null,  
                'icon' => 'categories/category_phone.svg',
                'name' => 'Điện thoại',  
                'slug' => 'dien-thoai',  
                'ordinal' => 4,  
                'is_active' => 1,  
                'created_at' => now(),  
                'updated_at' => now(),  
            ],  
            [  
                'parent_id' => null,  
                'icon' => 'categories/category_sound.svg',
                'name' => 'Âm thanh',  
                'slug' => 'am-thanh',  
                'ordinal' => 5,  
                'is_active' => 1,  
                'created_at' => now(),  
                'updated_at' => now(),  
            ],  
            [  
                'parent_id' => null,  
                'icon' => 'categories/category_tablet.svg',
                'name' => 'Máy tính bảng',  
                'slug' => 'may-tinh-bang',  
                'ordinal' => 6,  
                'is_active' => 1,  
                'created_at' => now(),  
                'updated_at' => now(),  
            ],
            [  
                'parent_id' => null,  
                'icon' => 'categories/category_tivi.svg',
                'name' => 'Tivi',  
                'slug' => 'tivi',  
                'ordinal' => 7,  
                'is_active' => 1,  
                'created_at' => now(),  
                'updated_at' => now(),  
            ],  
            [  
                'parent_id' => null,  
                'icon' => 'categories/category_watch.svg',
                'name' => 'Đồng hồ',  
                'slug' => 'dong-ho',  
                'ordinal' => 8,  
                'is_active' => 1,  
                'created_at' => now(),  
                'updated_at' => now(),  
            ], 
        ];

        DB::table('categories')->insert($categories);


    }
}
