<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->fakeAttribute();
    }

    public function fakeAttribute()
    {
        $attributes = [
            [
                'name' => 'Kích thước màn hình',  
                'slug' => 'kich-thuoc-man-hinh',  
                'is_variant' => 1,  
                'is_active' => 1,  
                'created_at' => now(),  
                'updated_at' => now(), 
            ],  
            [  
                'name' => 'Bộ nhớ RAM',  
                'slug' => 'bo-nho-ram',  
                'is_variant' => 1,  
                'is_active' => 1,  
                'created_at' => now(),  
                'updated_at' => now(), 
            ],  
            [  
                'name' => 'Bộ nhớ trong',  
                'slug' => 'bo-nho-trong',  
                'is_variant' => 0,  
                'is_active' => 1,  
                'created_at' => now(),  
                'updated_at' => now(), 
            ],  
            [  
                'name' => 'Hệ điều hành',  
                'slug' => 'he-dieu-hanh',  
                'is_variant' => 0,  
                'is_active' => 1,  
                'created_at' => now(),  
                'updated_at' => now(), 
            ],  
            [  
                'name' => 'Camera',  
                'slug' => 'camera',  
                'is_variant' => 0,  
                'is_active' => 1,  
                'created_at' => now(),  
                'updated_at' => now(), 
            ],  
            [  
                'name' => 'Kích thước',  
                'slug' => 'kich-thuoc',  
                'is_variant' => 0,  
                'is_active' => 1,  
                'created_at' => now(),  
                'updated_at' => now(), 
            ],  
            [  
                'name' => 'Trọng lượng',  
                'slug' => 'trong-luong',  
                'is_variant' => 0,  
                'is_active' => 1,  
                'created_at' => now(),  
                'updated_at' => now(), 
            ],  
            [  
                'name' => 'Độ phân giải màn hình',  
                'slug' => 'do-phan-giai-man-hinh',  
                'is_variant' => 0,  
                'is_active' => 1,  
                'created_at' => now(),  
                'updated_at' => now(), 
            ],  
            [  
                'name' => 'Công nghệ màn hình',  
                'slug' => 'cong-nghe-man-hinh',  
                'is_variant' => 0,  
                'is_active' => 1,  
                'created_at' => now(),  
                'updated_at' => now(), 
            ],  
            [  
                'name' => 'Bộ xử lý',  
                'slug' => 'bo-xu-ly',  
                'is_variant' => 0,  
                'is_active' => 1,  
                'created_at' => now(),  
                'updated_at' => now(), 
            ],
            [
                'name' => 'Màu sắc',  
                'slug' => 'mau-sac',  
                'is_variant' => 1,  
                'is_active' => 1,  
                'created_at' => now(),  
                'updated_at' => now(), 
            ], 
        ];  

        DB::table('attributes')->insert($attributes);  
    }
}
