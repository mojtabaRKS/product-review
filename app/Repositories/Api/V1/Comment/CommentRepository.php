<?php

namespace App\Repositories\Api\V1\Comment;

use App\Models\Comment;
use App\Repositories\Api\V1\Contracts\Repository;

class CommentRepository extends Repository implements CommentRepositoryInterface
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Comment::class;
    }
}