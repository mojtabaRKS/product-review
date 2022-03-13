<?php

namespace Database\Factories;

use App\Models\Vote;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vote::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'user_id' => $this->faker->randomNumber(),
            'rate' => $this->faker->randomNumber(1),
            'status' => $this->faker->randomElement(Vote::ALL_STATUSES),
        ];
    }
}
