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
        return [
            'google_id' => null,  
            'facebook_id' => null,  
            'phone_number' => $this->faker->numerify('09########'), 
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('123456'),
            'fullname' => $this->faker->name(),
            'avatar' => 'users/user_default', 
            'gender' => $this->faker->randomElement([UserGenderType::MALE, UserGenderType::FEMALE, UserGenderType::OTHER]),
            'birthday' => $this->faker->date(),  
            'loyalty_points' => $this->faker->numberBetween(0, 1000),  
            'role' => $this->faker->randomElement([  
                UserRoleType::CUSTOMER,
                UserRoleType::ADMIN,
                UserRoleType::EMPLOYEE
            ]),  
            'status' => $this->faker->randomElement([  
                UserStatusType::ACTIVE, 
                UserStatusType::LOCK  
            ]),  
            'code_verified_email' => Str::random(50),  
            'remember_token' => Str::random(10),  
            'email_verified_at' => now(),  
            'code_verified_at' => now(),  
        ];
    }

    public function admin(): Factory
    {
        return $this->state(function(array $attributes) {
            return [
                'fullname' => 'Admin',  
                'role' => UserRoleType::ADMIN,
                'email' => 'admin@gmail.com',  
                'password' => Hash::make('123456'),
                'status' => UserStatusType::ACTIVE
            ];
        });
    }

    public function employee(): Factory
    {
        return $this->state(function(array $attributes) {
            return [
                'role' => UserRoleType::EMPLOYEE,
                'status' => UserStatusType::ACTIVE
            ];
        });
    }

    public function customer(): Factory
    {
        return $this->state(function(array $attributes) {
            return [
                'role' => UserRoleType::CUSTOMER
            ];
        });
    }

}
