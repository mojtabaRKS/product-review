<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

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
            'description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(Comment::ALL_STATUSES),
        ];
    }
}
