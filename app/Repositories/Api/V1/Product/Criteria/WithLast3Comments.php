<?php

namespace App\Repositories\Api\V1\Product\Criteria;

use App\Models\Comment;
use App\Repositories\Api\V1\Contracts\Criteria;
use App\Repositories\Api\V1\Contracts\RepositoryInterface;

class WithLast3Comments extends Criteria
{
    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->with(['comments' => function ($query) {
            $query->where('status', Comment::APPROVED_STATUS)
                ->latest()
                ->limit(3);
        }]);
    }
}
