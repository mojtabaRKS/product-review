<?php

namespace App\Repositories\Api\V1\Product\Criteria;

use App\Models\Vote;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Api\V1\Contracts\Criteria;
use App\Repositories\Api\V1\Contracts\RepositoryInterface;

class WithVotesAverage extends Criteria
{
    /**
     * @param Builder $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->withAvg([
            'votes' => function ($query) {
                return $query->where('status', Vote::APPROVED_STATUS);
            },            
        ], 'rate');
    }
}
