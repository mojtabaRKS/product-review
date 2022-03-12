<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\InsertReviewRequest;
use App\Http\Requests\Api\v1\ChangeReviewStatusRequest;

class CommentController extends Controller
{
    /**
     * @var CommentService
     */
    private $commentService;

    /**
     * CommentController constructor.
     * @param CommentService $commentService
     */
    public function __construct(CommentService $commentService)
    {
        parent::__construct();
        $this->commentService = $commentService;
    }

    /**
     * @param InsertReviewRequest $request
     * @return JsonResponse
     */
    public function store(InsertReviewRequest $request): JsonResponse
    {
        try {
            $response = $this->commentService->insertComment($request);
            return $this->setMetaData($response->toArray())->successResponse();
        } catch (Exception $e) {
            return ($this->exceptionHandler->exceptionHandler($e));
        }
    }

    /**
     * @return JsonResponse
     */
    public function getAllPendingComments(): JsonResponse
    {
        try {
            $response = $this->commentService->getAllPendingComments();
            return $this->setMetaData($response->toArray())->successResponse();
        } catch (Exception $e) {
            return ($this->exceptionHandler->exceptionHandler($e));
        }
    }

    /**
     * @param ChangeReviewStatusRequest $request
     * @return JsonResponse
     */
    public function changeReviewStatus(ChangeReviewStatusRequest $request): JsonResponse
    {
        try {
            $response = $this->commentService->changeReviewStatus($request);
            return $this->setMetaData($response->toArray())->successResponse();
        } catch (Exception $e) {
            return ($this->exceptionHandler->exceptionHandler($e));
        }
    }
}
