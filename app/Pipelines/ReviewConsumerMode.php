<?php

namespace App\Pipelines;

use App\Exceptions\CustomApiException;
use App\Pipelines\Contracts\PipelineContract;

class ReviewConsumerMode implements PipelineContract
{
    /**
     * @param $data
     * @param callable $next
     * @return mixed
     * @throws CustomApiException
     */
    public function handle($data, $next)
    {
        //check if comment mode or vote mode is on `REVIEW_CONSUMER_MODE`
        if (
            $data['options']->comments_mode == $data['options']::REVIEW_CONSUMER_MODE ||
            $data['options']->vote_mode == $data['options']::REVIEW_CONSUMER_MODE
        ) {
            //check user has any order by `product_id = $request->product_id` on order service
            //for example : $userHasOrder = BOOLEAN DATA FROM ORDER SERVICE
            $userHasOrder = FALSE; #TODO: MOCK DATA INSTEAD OF ORDER SERVICE RESPONSE
            if (!$userHasOrder)
                throw new CustomApiException(config('review_message.insert_comment.review_consumer_failed'), 422);
        }

        return $next($data);
    }
}
