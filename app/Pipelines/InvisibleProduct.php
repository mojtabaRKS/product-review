<?php

namespace App\Pipelines;

use App\Exceptions\CustomApiException;
use App\Pipelines\Contracts\PipelineContract;

class InvisibleProduct implements PipelineContract
{
    /**
     * @param $data
     * @param callable $next
     * @return mixed
     * @throws CustomApiException
     */
    public function handle($data, $next)
    {
        if (is_null($data['options'])) {
            throw new CustomApiException(config('review_message.insert_comment.product_visibility_failed'), 422);
        }

        return $next($data);
    }
}
