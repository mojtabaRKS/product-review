<?php

namespace App\Repositories\Api\V1\Contracts;

use App\Repositories\V1\Criteria\Criteria;

interface CriteriaInterface
{
    /**
     * @param bool $status
     *
     * @return $this
     */
    public function skipCriteria(bool $status = true): self;

    /**
     * @return mixed
     */
    public function getCriteria();

    /**
     * @param Criteria $criteria
     *
     * @return $this
     */
    public function getByCriteria(Criteria $criteria): self;

    /**
     * @param Criteria $criteria
     *
     * @return $this
     */
    public function pushCriteria(Criteria $criteria): self;

    /**
     * @return $this
     */
    public function applyCriteria(): self;
}
