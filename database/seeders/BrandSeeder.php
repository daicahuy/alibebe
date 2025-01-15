<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $this->fakeBrand();
        
    }

    public function fakeBrand()
    {
        $brands = [
            [
                'name' => 'Apple Ios',
                'slug' => 'apple-ios',
                'logo' => 'brands/brand_apple_ios.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Apple Watch',
                'slug' => 'apple-watch',
                'logo' => 'brands/brand_apple_watch.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Asus',
                'slug' => 'asus',
                'logo' => 'brands/brand_asus.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dell',
                'slug' => 'dell',
                'logo' => 'brands/brand_dell.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hp',
                'slug' => 'hp',
                'logo' => 'brands/brand_hp.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lenovo',
                'slug' => 'lenovo',
                'logo' => 'brands/brand_lenovo.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'LG',
                'slug' => 'lg',
                'logo' => 'brands/brand_lg.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Macbook',
                'slug' => 'macbook',
                'logo' => 'brands/brand_macbook.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nokia',
                'slug' => 'nokia',
                'logo' => 'brands/brand_nokia.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Oppo',
                'slug' => 'oppo',
                'logo' => 'brands/brand_oppo.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Realme',
                'slug' => 'realme',
                'logo' => 'brands/brand_realme.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Samsung',
                'slug' => 'samsung',
                'logo' => 'brands/brand_samsung.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sony',
                'slug' => 'sony',
                'logo' => 'brands/brand_sony.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TCL',
                'slug' => 'tcl',
                'logo' => 'brands/brand_tcl.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vivo',
                'slug' => 'vivo',
                'logo' => 'brands/brand_vivo.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xiaomi',
                'slug' => 'xiaomi',
                'logo' => 'brands/brand_xiaomi.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ];

        DB::table('brands')->insert($brands);
    }
}
