<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::query()->where('id', '<>', 1)->pluck('id')->toArray();
        $batchSize = 20;
        $insertData = [];

        foreach ($userIds as $index => $userId) {
            for ($i = 0; $i < rand(2, 4); $i++) {
                $insertData[] = [
                    'user_id' => $userId,
                    'address' => fake()->address(),  
                    'phone_number' => fake()->numerify('09########'),  
                    'fullname' => fake()->name(),  
                    'is_default' => $i === 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (count($insertData) >= $batchSize) {
                DB::table('user_addresses')->insert($insertData);
                $insertData = [];
            }
        }

        if (!empty($insertData)) {
            DB::table('user_addresses')->insert($insertData);
        }
    }
}
