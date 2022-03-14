<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => number_format($this->price),
            'comment_mode' => $this->comment_mode,
            'vote_mode' => $this->vote_mode,
            'votes_average' => intval($this->votes_average),
            'comments_count' => $this->comments->count(),
            'comments' => CommentResource::collection($this->comments),
        ];
    }
}
