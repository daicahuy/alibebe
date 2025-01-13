<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->fakeTag();
    }

    public function fakeTag()
    {
        $tags = [  
            [  
                'name' => 'Smartphone',  
                'slug' => 'smartphone',  
                'created_at' => now(),  
                'updated_at' => now(),  
            ],  
            [  
                'name' => 'Tablet',  
                'slug' => 'tablet',  
                'created_at' => now(),  
                'updated_at' => now(),  
            ],  
            [  
                'name' => 'Laptop',  
                'slug' => 'laptop',  
                'created_at' => now(),  
                'updated_at' => now(),  
            ],  
            [  
                'name' => 'TV',  
                'slug' => 'tv',  
                'created_at' => now(),  
                'updated_at' => now(),  
            ],  
            [  
                'name' => 'Audio',  
                'slug' => 'audio',  
                'created_at' => now(),  
                'updated_at' => now(),  
            ],  
            [  
                'name' => 'Gaming',  
                'slug' => 'gaming',  
                'created_at' => now(),  
                'updated_at' => now(),  
            ],  
            [  
                'name' => 'Photography',  
                'slug' => 'photography',  
                'created_at' => now(),  
                'updated_at' => now(),  
            ],  
            [  
                'name' => 'Smart Home',  
                'slug' => 'smart-home',  
                'created_at' => now(),  
                'updated_at' => now(),  
            ],  
            [  
                'name' => 'Wearable',  
                'slug' => 'wearable',  
                'created_at' => now(),  
                'updated_at' => now(),  
            ],  
            [  
                'name' => 'Accessories',  
                'slug' => 'accessories',  
                'created_at' => now(),  
                'updated_at' => now(),  
            ],  
        ];  

        DB::table('tags')->insert($tags); 
    }
}
