<?php

namespace App\Repositories\Api\V1\Contracts;

abstract class Criteria
{
    /**
     * @param $model
     * @param Repository $repository
     *
     * @return mixed
     */
    abstract public function apply($model, Repository $repository);
}
