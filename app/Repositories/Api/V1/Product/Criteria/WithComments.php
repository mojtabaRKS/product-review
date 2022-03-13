<?php

namespace App\Repositories\Api\V1\Product\Criteria;

use App\Models\Comment;
use App\Repositories\Api\V1\Contracts\Criteria;
use App\Repositories\Api\V1\Contracts\RepositoryInterface;

class WithComments extends Criteria
{
    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->with(['comments' => function ($query) {
            $query->latest();
        }]);
    }
}
