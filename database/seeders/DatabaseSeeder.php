<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\UserGenderType;
use App\Enums\UserRoleType;
use App\Enums\UserStatusType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            UserAddressSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            TagSeeder::class,
            AttributeSeeder::class,
            AttributeValueSeeder::class,
            PaymentSeeder::class,
            OrderStatusSeeder::class,
            ProductSeeder::class,
            CategoryProductSeeder::class,
            ProductAccessorySeeder::class,
            ProductTagSeeder::class,
            AttributeValueProductSeeder::class,
            ProductGalleriesSeeder::class,
            ProductVariantSeeder::class,
            AttributeValueProductVariantSeeder::class,
            ProductStockSeeder::class,
            OrderSeeder::class,
        ]);

        //comment
        //coupon
        //order -> chua xong
        //review
    }
}
