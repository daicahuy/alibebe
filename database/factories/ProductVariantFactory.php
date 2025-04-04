<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = $this->faker->randomNumber(50000, 5000000);
        $salePrice = $this->faker->boolean(40) ? ceil($price * 0.9) : null;

        return [
            'product_id' => Product::query()->where('type', 1)->inRandomOrder()->first()->id ?? 1,
            'sku' => $this->faker->unique()->numerify('SP-#####'),
            'price' => $price,
            'sale_price' => $salePrice,
            'thumbnail' => 'products/image_2.png',
            'is_active' => $this->faker->boolean(90)
        ];
    }
}
