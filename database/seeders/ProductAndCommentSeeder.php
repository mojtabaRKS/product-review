<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class ProductAndCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()->count(10)
            ->has(Comment::factory()->count(10), 'comments')
            ->has(Vote::factory()->count(10), 'votes')
            ->create();
    }
}
