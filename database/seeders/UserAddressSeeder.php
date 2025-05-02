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
        $users = User::query()->where('id', '<>', 1)->get();
        $batchSize = 20;
        $insertData = [];

        foreach ($users as $index => $user) {
            for ($i = 0; $i < rand(1, 2); $i++) {
                $insertData[] = [
                    'user_id' => $user->id,
                    'address' => fake()->address(),  
                    'phone_number' => $user->phone_number,  
                    'fullname' => $user->fullname,  
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
