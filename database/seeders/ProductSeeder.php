<?php

namespace Database\Seeders;

use App\Enums\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->fakeSingleProduct();
    }

    public function fakeSingleProduct()
    {

        $singleProducts = [
            [
                'brand_id' => 1,
                'name' => 'iPhone 16 Pro Max 256GB | Chính hãng VN/A',
                'name_link' => NULL,
                'slug' => 'iphone-16-pro-max-256gb-chinh-hang-vna',
                'video' => NULL,
                'content' => NULL,
                'thumbnail' => 'products/product_iphone-16-pro-max.webp',
                'sku' => NULL,
                'price' => rand(2000000, 45000000),
                'sale_price' => NULL,
                'sale_price_start_at' => NULL,
                'sale_price_end_at' => NULL,
                'type' => ProductType::SINGLE,
                'is_active' => 1,
                'start_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_id' => 1,
                'name' => 'iPhone 14 128GB | Chính hãng VN/A',
                'name_link' => NULL,
                'slug' => 'iphone-14-128gb-chinh-hang-vna',
                'video' => NULL,
                'content' => NULL,
                'thumbnail' => 'products/product_iphone-14_1.webp',
                'sku' => NULL,
                'price' => rand(2000000, 45000000),
                'sale_price' => NULL,
                'sale_price_start_at' => NULL,
                'sale_price_end_at' => NULL,
                'type' => ProductType::SINGLE,
                'is_active' => 1,
                'start_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_id' => 2,
                'name' => 'Apple Watch Series 9 45mm (GPS) viền nhôm dây cao su | Chính hãng Apple Việt Nam',
                'name_link' => NULL,
                'slug' => 'apple-watch-series-9-45mm-gps-vien-nhom-day-cao-su-chinh-hang-apple-viet-nam',
                'video' => NULL,
                'content' => NULL,
                'thumbnail' => 'products/product_apple_lte_3__1.webp',
                'sku' => NULL,
                'price' => rand(6000000, 12000000),
                'sale_price' => NULL,
                'sale_price_start_at' => NULL,
                'sale_price_end_at' => NULL,
                'type' => ProductType::SINGLE,
                'is_active' => 1,
                'start_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_id' => 2,
                'name' => 'Apple Watch SE 2 2023 40mm (GPS) viền nhôm | Chính hãng Apple Việt Nam',
                'name_link' => NULL,
                'slug' => 'apple-watch-se-2-2023-40mm-gps-vien-nhom-chinh-hang-apple-viet-nam',
                'video' => NULL,
                'content' => NULL,
                'thumbnail' => 'products/product_apple-watch-se-2023-40mm.webp',
                'sku' => NULL,
                'price' => rand(6000000, 12000000),
                'sale_price' => NULL,
                'sale_price_start_at' => NULL,
                'sale_price_end_at' => NULL,
                'type' => ProductType::SINGLE,
                'is_active' => 1,
                'start_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_id' => 3,
                'name' => 'Laptop ASUS TUF Gaming A15 FA506NFR-HN006W',
                'name_link' => NULL,
                'slug' => 'laptop-asus-tuf-gaming-a15-fa506nfr-hn006w',
                'video' => NULL,
                'content' => NULL,
                'thumbnail' => 'products/product_text_ng_n_1__5_13.webp',
                'sku' => NULL,
                'price' => rand(18000000, 50000000),
                'sale_price' => NULL,
                'sale_price_start_at' => NULL,
                'sale_price_end_at' => NULL,
                'type' => ProductType::SINGLE,
                'is_active' => 1,
                'start_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_id' => 3,
                'name' => 'Laptop ASUS Vivobook 14 OLED A1405ZA-KM264W',
                'name_link' => NULL,
                'slug' => 'laptop-asus-vivobook-14-oled-a1405za-km264w',
                'video' => NULL,
                'content' => NULL,
                'thumbnail' => 'products/product_text_d_i_4__2_3.webp',
                'sku' => NULL,
                'price' => rand(18000000, 50000000),
                'sale_price' => NULL,
                'sale_price_start_at' => NULL,
                'sale_price_end_at' => NULL,
                'type' => ProductType::SINGLE,
                'is_active' => 1,
                'start_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_id' => 4,
                'name' => 'Laptop Dell Inspiron 15 3530 N5I7240W1',
                'name_link' => NULL,
                'slug' => 'laptop-dell-inspiron-15-3530-n5i7240w1',
                'video' => NULL,
                'content' => NULL,
                'thumbnail' => 'products/product_text_d_i_6_16.webp',
                'sku' => NULL,
                'price' => rand(1000000, 88000000),
                'sale_price' => NULL,
                'sale_price_start_at' => NULL,
                'sale_price_end_at' => NULL,
                'type' => ProductType::SINGLE,
                'is_active' => 1,
                'start_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_id' => 4,
                'name' => 'Laptop Dell Inspiron 15 3520 6R6NK - Nhập khẩu chính hãng',
                'name_link' => NULL,
                'slug' => 'laptop-dell-inspiron-15-3520-6r6nk-nhap-khau-chinh-hang',
                'video' => NULL,
                'content' => NULL,
                'thumbnail' => 'products/product_text_ng_n_7__2_79.webp',
                'sku' => NULL,
                'price' => rand(1000000, 88000000),
                'sale_price' => NULL,
                'sale_price_start_at' => NULL,
                'sale_price_end_at' => NULL,
                'type' => ProductType::SINGLE,
                'is_active' => 1,
                'start_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($singleProducts);
    }
}
