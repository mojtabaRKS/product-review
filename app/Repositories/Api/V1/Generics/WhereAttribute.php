<?php

namespace App\Repositories\Api\V1\Generics;

use App\Repositories\Api\V1\Contracts\Criteria;
use App\Repositories\Api\V1\Contracts\Repository;

class WhereAttribute extends Criteria
{
    /**
     * @var string
     */
    private $attribute;

    /**
     * @var string
     */
    private $value;

    /**
     * @param string $attribute
     * @param string $value
     */
    public function __construct(string $attribute, string $value)
    {
        $this->attribute = $attribute;
        $this->value = $value;
    }

    /**
     * @param $model
     * @param Repository $repository
     *
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        return $model->where($this->attribute, $this->value);
    }
}