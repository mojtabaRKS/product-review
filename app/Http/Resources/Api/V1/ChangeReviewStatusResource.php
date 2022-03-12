<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChangeReviewStatusResource extends JsonResource
{

    /**
     * @var int|mixed
     */
    private $statusCode;

    public function __construct($resource, $statusCode = 200)
    {
        parent::__construct($resource);
        $this->statusCode = $statusCode;
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return responseApi('success', NULL, config('review_message.review.update_success'));

    }

    /**
     * @param Request $request
     * @return JsonResponse|object
     */
    public function toResponse($request)
    {
        return parent::toResponse($request)->setStatusCode($this->statusCode);
    }
}
