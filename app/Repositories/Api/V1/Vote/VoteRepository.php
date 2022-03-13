<?php

namespace App\Repositories\Api\V1\Vote;

use App\Models\Vote;
use App\Repositories\Api\V1\Contracts\Repository;

class VoteRepository extends Repository implements VoteRepositoryInterface
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Vote::class;
    }
}