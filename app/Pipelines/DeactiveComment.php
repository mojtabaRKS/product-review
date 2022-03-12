<?php

namespace App\Pipelines;

use App\Exceptions\CustomApiException;
use App\Pipelines\Contracts\PipelineContract;

class DeactiveComment implements PipelineContract
{
    /**
     * @param $data
     * @param callable $next
     * @return mixed
     * @throws CustomApiException
     */
    public function handle($data, $next)
    {
        //check if comment mode is deavtive and api has comment in body
        // ( its like a trick because client-side will not render its component if get deactive mode from get-options api)
        if ($data['options']->comments_mode == $data['options']::REVIEW_DEACTIVE_MODE && $data['request']->filled('comment')) {
            throw new CustomApiException(config('review_message.insert_comment.review_deactive_failed'), 422);
        }

        return $next($data);
    }
}
