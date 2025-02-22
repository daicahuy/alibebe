<?php

namespace Database\Seeders;

use App\Enums\UserGenderType;
use App\Enums\UserRoleType;
use App\Enums\UserStatusType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->fakeAdmin();
        $this->fakeCustomer();
    }

    private function fakeAdmin()
    {
        DB::table('users')->insert([
            'phone_number' => '0987654321',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'fullname' => 'Admin',
            'gender' => UserGenderType::MALE,
            'role' => UserRoleType::ADMIN,
            'status' => UserStatusType::ACTIVE,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function fakeCustomer()
    {
        $users = [];

        $firstNames = ['Nguyễn', 'Trần', 'Lê', 'Phạm', 'Hoàng'];
        $middleNames = ['Văn', 'Thị', 'Hữu', 'Minh', 'Anh', 'Thành', 'Mỹ'];
        $lastNames = [
            'Trinh',
            'Huệ',
            'Hoa',
            'Quỳnh',
            'Thắm',
            'Duyên',
            'Diệu',
            'Nga',
            'Thúy',
            'Hường',
            'Thu',
            'Hà',
            'Linh',
            'My',
            'Huy',
            'Sơn',
            'Mạnh',
            'Quân',
            'Tùng',
            'Bảo',
            'Ánh',
            'Trung'
        ];


        $userAddresses = [];

        $homeNumbers = [
            'Số nhà 80',
            'Số nhà 76',
            'Số nhà 21',
            'Số nhà 100',
            'Số nhà 23',
            'Số nhà 98',
            'Số nhà 142',
            'Số nhà 124B',
            'Số nhà 52A',
            'Số nhà 75',
            'Số nhà 22',
            'Số nhà 100',
            'Số nhà 01',
            'Số nhà 2',
            'Số nhà 80',
        ];

        $streets = [
            'Đường Điện Biên Phủ',
            'Đường Hoàng Diệu',
            'Đường Nguyễn Chí Thanh',
            'Đường Yên Sở',
            'Đường Phạm Văn Đồng',
            'Thôn Hạ',
            'Phố Nhổn',
            'KĐT Mỹ Đình',
            'Đường Tố Hữu',
            'Đường Mễ Trì'
        ];

        $wards = [
            'Phường 1',
            'Phường 2',
            'Phường 3',
            'Phường 4',
            'Phường 5',
            'Phường 6',
            'Phường 7',
            'Phường 8',
            'Phường 9',
            'Phường 10',
            'Đan Phượng',
            'Bắc Từ Liêm',
            'Nam Từ Liêm',
            'Mỹ Đình',
            'Hoàn Kiếm'
        ];

        $districts = [
            'Ba Đình',
            'Hoàn Kiếm',
            'Hai Bà Trưng',
            'Thanh Xuân',
            'Cầu Giấy',
            'Bình Thạnh',
            'Gò Vấp',
            'Thủ Đức',
            'Tân Bình',
            'Tân Phú'
        ];

        $cities = [
            'Hà Nội',
            'Hồ Chí Minh',
            'Đà Nẵng',
            'Hải Phòng',
            'Cần Thơ',
            'Huế',
            'Nha Trang',
            'Vũng Tàu',
            'Bình Dương',
            'Đồng Nai'
        ];


        for ($i = 2; $i <= 51; $i++) {
            $users[] = [
                'phone_number' => fake()->unique()->numerify('09########'),
                'email' => fake()->unique()->userName() . '@gmail.com',
                'password' => Hash::make('123456789'),
                'fullname' => fake()->randomElement($firstNames)
                    . ' ' . fake()->randomElement($middleNames)
                    . ' ' . fake()->randomElement($lastNames),
                'gender' => UserGenderType::getRandomValue(),
                'loyalty_points' => fake()->randomElement([0, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000]),
                'role' => UserRoleType::CUSTOMER,
                'status' => UserStatusType::getRandomValue(),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $userAddresses[] = [
                "user_id" => $i,
                "address" => fake()->randomElement($homeNumbers)
                    . ' ' . fake()->randomElement($streets)
                    . ', ' . fake()->randomElement($wards)
                    . ', ' . fake()->randomElement($districts)
                    . ', ' . fake()->randomElement($cities),
                "id_default" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $userAddresses[] = [
                "user_id" => $i,
                "address" => fake()->randomElement($homeNumbers)
                    . ' ' . fake()->randomElement($streets)
                    . ', ' . fake()->randomElement($wards)
                    . ', ' . fake()->randomElement($districts)
                    . ', ' . fake()->randomElement($cities),
                "id_default" => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('users')->insert($users);
        DB::table('user_addresses')->insert($userAddresses);
    }
}
