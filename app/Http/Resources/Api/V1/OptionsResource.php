<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class OptionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     */
    public function toArray($request)
    {
        return responseApi('success', NULL, NULL, [
            'is_visible' => $this->is_visible ?? false,
            'options' =>
                (isset($this->is_visible) && $this->is_visible) ? [
                    'comments' => $this->full_comments_mode,
                    'vote' => $this->full_vote_mode,
                ] : NULL,
            'summery' =>
                (isset($this->is_visible) && $this->is_visible) ? [
                    'comments' => $this->comments->pluck('comment'),
                    'comments_count' => $this->comments_count,
                    'vote' => $this->vote_avg
                ] : NULL,
        ]);
    }
}
