<?php

namespace Database\Factories;

use App\Enums\UserGenderType;
use App\Enums\UserRoleType;
use App\Enums\UserStatusType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstNames = ['Nguyễn', 'Trần', 'Lê', 'Phạm', 'Hoàng'];
        $middleNames = ['Văn', 'Thị', 'Hữu', 'Minh', 'Anh', 'Thành', 'Mỹ'];
        $lastNames = ['Trinh', 'Huệ', 'Hoa', 'Quỳnh', 'Thắm', 'Duyên', 'Diệu', 'Nga', 'Thúy', 'Hường', 'Thu', 'Hà', 'Linh', 'My', 'Huy', 'Sơn', 'Mạnh', 'Quân', 'Tùng', 'Bảo', 'Ánh', 'Trung'];
        
        return [
            'phone_number' => $this->faker->unique()->numerify('09########'),
            'email' => $this->faker->unique()->userName() . '@gmail.com',
            'password' => Hash::make('123456'),
            'fullname' => $this->faker->randomElement($firstNames) . ' ' . $this->faker->randomElement($middleNames) . ' ' . $this->faker->randomElement($lastNames),
            'gender' => UserGenderType::getRandomValue(),
            'role' => UserRoleType::CUSTOMER,
            'status' => UserStatusType::getRandomValue(),
            'verified_at' => now(),
        ];
    }

}
