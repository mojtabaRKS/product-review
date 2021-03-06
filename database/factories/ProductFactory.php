<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numerify("#######"),
            'is_visible' => $this->faker->boolean(),
            'comment_mode' => $this->faker->randomElement(Product::MODES),
            'vote_mode' => $this->faker->randomElement(Product::MODES),
        ];
    }
}
