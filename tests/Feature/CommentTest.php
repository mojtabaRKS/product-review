<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Comment;
use App\Models\Product;

class CommentTest extends TestCase
{
    public function test_can_leave_comment_for_product()
    {
        $product = Product::factory()->create([
            'comment_mode' => Product::PUBLIC_MODE,
        ]);

        $response = $this->postJson(route('api.v1.reviews.comments.store'), [
            'description' => 'New comment',
            'product_id' => $product->id,
        ]);

        $response->assertStatus(201);
        $response->assertExactJson([
            'code' => 201,
            'message' => trans('messages.action_successfully_done'),
            'success' => true,
            'data' => []
        ]);

        $this->assertDatabaseHas('comments', [
            'description' => 'New comment',
            'product_id' => $product->id,
            'status' => Comment::PENDING_STATUS,
        ]);
    }

    public function test_can_approve_comment()
    {
        $product = Product::factory()->create();
        $comment = $product->comments()->save(Comment::factory()->make());

        $response = $this->putJson(route('api.v1.reviews.comments.change-status', $comment->id), [
            'status' => Comment::APPROVED_STATUS,
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
