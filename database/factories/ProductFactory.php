<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
use App\Models\Category;
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'name' => $this->faker->word(),
        'price' => $this->faker->randomFloat(2, 1000, 50000),
        'barcode' => $this->faker->unique()->ean13(),
        'category_id' => Category::inRandomOrder()->first()->id,
    ];
    }
}
