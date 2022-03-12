<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Request;

class ReviewCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return responseApi(
            'success',
            NULL,
            '',
            $this->collection->transform(function ($comment) {
                return [
                    'id' => $comment->id,
                    'product_id' => $comment->option->id,
                    'user_id' => $comment->user_id,
                    'comment' => $comment->comment,
                    'vote' => $comment->vote,
                    'status' => $comment->status
                ];
            }),
        );
    }
}
