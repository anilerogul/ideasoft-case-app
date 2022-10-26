<?php
namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_id' => Category::inRandomOrder()->value('id'),
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'stock' => $this->faker->randomNumber(2),
        ];
    }
}
