<?php

namespace App\Repositories\Api\V1\Product\Criteria;

use App\Repositories\Api\V1\Contracts\Criteria;
use App\Repositories\Api\V1\Contracts\RepositoryInterface;

class WhereIsVisible extends Criteria
{
    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
       /* if is admin then return all products */

        // if (auth()->user()->isAdmin()) {
            return $model;
        // }

        /* if is user then return only visible products */

        // return $model->where('is_visible', true);
    }
}
