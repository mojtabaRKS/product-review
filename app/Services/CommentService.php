<?php

namespace App\Services;

use App\Pipelines\DeactiveVote;
use Illuminate\Pipeline\Pipeline;
use App\Pipelines\DeactiveComment;
use App\Pipelines\InvisibleProduct;
use App\Pipelines\ReviewConsumerMode;
use App\Exceptions\CustomApiException;
use App\Repositories\CommentRepository;
use Illuminate\Contracts\Container\BindingResolutionException;

class CommentService
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * CommentService constructor.
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @throws BindingResolutionException
     * @throws CustomApiException
     */
    public function insertComment($request)
    {
        //create passable array
        $data = [
            'request' => $request,
            'options' => (app()->make(OptionsService::class))->returnOptionsIfVisible($request->product_id)
        ];

        return app(Pipeline::class)
            ->send($data)
            ->through([
                InvisibleProduct::class,
                ReviewConsumerMode::class,
                DeactiveComment::class,
                DeactiveVote::class,
            ])
            ->then(function ($data) {
                return $this->commentRepository->create([
                    'product_id' => $data['request']->product_id,
                    'user_id' => NULL, #TODO: FILL WHEN USER IS LOGGED_IN AND RECEIVE FROM AUTH SERVICE
                    'comment' => $data['request']->comment,
                    'vote' => $data['request']->vote
                ]);
            });
    }

    /**
     * @return mixed
     */
    public function getAllPendingComments()
    {
        return $this->commentRepository->getAllPendingComments();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function changeReviewStatus($request)
    {
        return $this->commentRepository->changeReviewStatus($request);
    }

}
