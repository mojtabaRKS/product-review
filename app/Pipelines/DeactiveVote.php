<?php

namespace App\Pipelines;

use App\Exceptions\CustomApiException;
use App\Pipelines\Contracts\PipelineContract;

class DeactiveVote implements PipelineContract
{
    /**
     * @param $data
     * @param callable $next
     * @return mixed
     * @throws CustomApiException
     */
    public function handle($data, $next)
    {
        //check if vote mode is deavtive and api has vote in body
        // ( its like a trick because client-side will not render its component if get deactive mode from get-options api)
        if ($data['options']->vote_mode == $data['options']::REVIEW_DEACTIVE_MODE && $data['request']->filled('vote')) {
            throw new CustomApiException(config('review_message.insert_comment.review_deactive_failed'), 422);
        }

        return $next($data);
    }
}
