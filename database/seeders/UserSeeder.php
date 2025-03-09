<?php

namespace Database\Seeders;

use App\Enums\UserGenderType;
use App\Enums\UserRoleType;
use App\Enums\UserStatusType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->fakeAdmin();
        $this->fakeEmployee(50);
        $this->fakeCustomer(500);
    }

    private function fakeAdmin()
    {
        DB::table('users')->insert([
            'phone_number' => '0987654321',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'fullname' => 'Admin',
            'avatar' => 'users/user_default.jpg',
            'birthday' => '2004-01-01',
            'gender' => UserGenderType::MALE,
            'role' => UserRoleType::ADMIN,
            'status' => UserStatusType::ACTIVE,
            'code_verified_email' => Str::random(50),
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function fakeCustomer(int $quantity)
    {
        $batchSize = 100;
        $insertData = [];
        $password = Hash::make('123456');

        for ($i = 0; $i < $quantity; $i++) {
            $insertData[] = [
                'google_id' => null,  
                'facebook_id' => null,  
                'phone_number' => fake()->unique()->numerify('09########'), 
                'email' => fake()->word(5) . $i . '@gmail.com',
                'password' => $password,
                'fullname' => fake()->name(),
                'avatar' => 'users/user_default.jpg', 
                'gender' => fake()->randomElement([UserGenderType::MALE, UserGenderType::FEMALE, UserGenderType::OTHER]),
                'birthday' => fake()->date(),  
                'loyalty_points' => fake()->numberBetween(0, 1000),  
                'role' => UserRoleType::CUSTOMER,  
                'status' => fake()->randomElement([  
                    UserStatusType::ACTIVE,
                    UserStatusType::LOCK
                ]),
                'code_verified_email' => Str::random(50),
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
                'code_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($insertData) >= $batchSize) {
                DB::table('users')->insert($insertData);
                $insertData = [];
            }
        }

        if (!empty($insertData)) {
            DB::table('users')->insert($insertData);
        }
    }

    private function fakeEmployee(int $quantity)
    {
        $batchSize = 100;
        $insertData = [];
        $password = Hash::make('123456');

        for ($i = 0; $i < $quantity; $i++) {
            $insertData[] = [
                'google_id' => null,  
                'facebook_id' => null,  
                'phone_number' => fake()->unique()->numerify('09########'), 
                'email' => 'employee' . $i . '@alibebe.com.vn',
                'password' => $password,
                'fullname' => fake()->name(),
                'avatar' => 'users/user_default.jpg', 
                'gender' => fake()->randomElement([UserGenderType::MALE, UserGenderType::FEMALE, UserGenderType::OTHER]),
                'birthday' => fake()->date(),  
                'loyalty_points' => fake()->numberBetween(0, 1000),  
                'role' => UserRoleType::EMPLOYEE,  
                'status' => UserStatusType::ACTIVE,
                'code_verified_email' => Str::random(50),
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
                'code_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($insertData) >= $batchSize) {
                DB::table('users')->insert($insertData);
                $insertData = [];
            }
        }

        if (!empty($insertData)) {
            DB::table('users')->insert($insertData);
        }
    }
}
