<?php

namespace App\Http\Controllers\Api\V1;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Api\V1\VoteService;
use App\Http\Requests\Api\V1\Vote\StoreRequest;

class VoteController extends Controller
{
    /**
     * @var VoteService $voteService
     */
    protected VoteService $voteService;

    /**
     * ReviewController constructor.
     * 
     * @param VoteService $voteService
     * @param CommentService $commentService
     */
    public function __construct(VoteService $voteService)
    {
        $this->voteService = $voteService;
    }

    /**
     * @param StoreRequest $request
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->voteService->create($request->validated());
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
