<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Vote;
use App\Models\Product;

class VoteTest extends TestCase
{
    public function test_can_vote_for_product(): void
    {
        $product = Product::factory()->create([
            'vote_mode' => Product::PUBLIC_MODE,
        ]);

        $response = $this->postJson(route('api.v1.reviews.votes.store'), [
            'product_id' => $product->id,
            'rate' => 1,
        ]);

        $response->assertStatus(201);
        $response->assertExactJson([
            'code' => 201,
            'message' => trans('messages.action_successfully_done'),
            'success' => true,
            'data' => []
        ]);

        $this->assertDatabaseHas('votes', [
            'rate' => 1,
            'product_id' => $product->id,
            'status' => Vote::PENDING_STATUS,
        ]);
    }

    public function test_can_approve_vote()
    {
        $product = Product::factory()->create();
        $vote = $product->votes()->save(Vote::factory()->make());

        $response = $this->putJson(route('api.v1.reviews.votes.change-status', $vote->id), [
            'status' => Vote::APPROVED_STATUS,
        ]);

        $response->assertOk();
        $response->assertExactJson([
            'code' => 200,
            'message' => trans('messages.action_successfully_done'),
            'success'=> true,
            'data' => []
        ]);
    }
}
