<?php

namespace App\Http\Controllers\Api\V1;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Api\V1\CommentService;
use App\Http\Requests\Api\V1\Comment\StoreRequest;
use App\Http\Requests\Api\V1\Comment\changeStatusRequest;

class CommentController extends Controller
{
    /**
     * @var CommentService $commentService
     */
    protected CommentService $commentService;

    /**
     * ReviewController constructor.
     * 
     * @param CommentService $commentService
     */
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * @param StoreRequest $request
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->commentService->create($request->validated());
            DB::commit();
            return $this->successReponse(
                trans('messages.action_successfully_done'),
                Response::HTTP_CREATED
            );
        } catch (Throwable $exception) {
            DB::rollBack();
            return $this->failureResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }

    /**
     * @param int $id
     * @param changeStatusRequest $request
     */
    public function changeStatus($id, changeStatusRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->commentService->changeStatus($id, $request->validated());
            DB::commit();
            return $this->successReponse(
                trans('messages.action_successfully_done'),
                Response::HTTP_CREATED
            );
        } catch (Throwable $exception) {
            DB::rollBack();
            return $this->failureResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }
}
