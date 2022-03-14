<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Vote;
use App\Models\Product;
use App\Models\Comment;

class ProductTest extends TestCase
{
    public function test_can_get_all_products_with_comments(): void
    {
        $product = Product::factory()
            ->has(Comment::factory()->state(['status' => Comment::APPROVED_STATUS]), 'comments')
            ->has(Vote::factory()->state(['status' => Vote::APPROVED_STATUS, 'rate' => 1]), 'votes')
            ->create();

        $response = $this->getJson(route('api.v1.products.index'));

        $response->assertOk();

        $response->assertExactJson([
            'code' => 200,
            'message' => trans('messages.action_successfully_done'),
            'success' => true,
            'data' => [
                [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => number_format($product->price),
                    'description' => $product->description,
                    'comment_mode' => $product->comment_mode,
                    'vote_mode' => $product->vote_mode,
                    'votes_average' => 0,
                    'comments_count' => 1,
                    'comments' => [
                        [
                            'user_id' => $product->comments->first()->user_id,
                            'description' => $product->comments->first()->description,
                            'status' => $product->comments->first()->status,
                        ],
                    ]
                ],
            ]
        ]);
    }

    public function test_can_update_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->putJson(route('api.v1.products.update', $product->id), [
            'name' => 'New name',
            'description' => 'New description',
            'price' => '100',
            'comment_mode' => Product::ORDER_MODE,
            'vote_mode' => Product::PUBLIC_MODE,
            'is_visible' => true,
        ]);

        $response->assertOk();

        $response->assertExactJson([
            'code' => 200,
            'message' => trans('messages.action_successfully_done'),
            'success' => true,
            'data' => []
        ]);

        $this->assertDatabaseHas('products',[
            'id' => $product->id,
            'name' => 'New name',
            'description' => 'New description',
            'price' => '100',
            'comment_mode' => Product::ORDER_MODE,
            'vote_mode' => Product::PUBLIC_MODE,
        ]);
    }

    public function test_can_show_single_product(): void
    {
        $product = Product::factory()
            ->has(Comment::factory()->state(['status' => Comment::APPROVED_STATUS]), 'comments')
            ->has(Vote::factory()->state(['status' => Vote::APPROVED_STATUS, 'rate' => 1]), 'votes')
            ->create();

        $response = $this->getJson(route('api.v1.products.show', $product->id));

        $response->assertOk();

        $response->assertExactJson([
            'code' => 200,
            'message' => trans('messages.action_successfully_done'),
            'success' => true,
            'data' => [
                'id' => $product->id,
                    'name' => $product->name,
                    'price' => number_format($product->price),
                    'description' => $product->description,
                    'comment_mode' => $product->comment_mode,
                    'vote_mode' => $product->vote_mode,
                    'votes_average' => 0,
                    'comments_count' => 1,
                    'comments' => [
                        [
                            'user_id' => $product->comments->first()->user_id,
                            'description' => $product->comments->first()->description,
                            'status' => $product->comments->first()->status,
                        ],
                    ]
            ]
        ]);
    }
}
