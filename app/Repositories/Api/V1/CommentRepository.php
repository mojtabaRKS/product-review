<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    /**
     * @var Comment
     */
    private $comment;

    /**
     * CommentsRepository constructor.
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param $preparedCommentData
     * @return mixed
     */
    public function create($preparedCommentData)
    {
        return $this->comment->create($preparedCommentData);
    }

    /**
     * @return mixed
     */
    public function getAllPendingComments()
    {
        return $this->comment
            ->select(['id', 'product_id', 'user_id', 'comment', 'vote', 'status'])
            ->pending()
            ->get();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function changeReviewStatus($request)
    {
        $comment = $this->comment->find($request->review_id);
        $comment->status = $request->status;
        $comment->save();
        return $comment;
    }

    /**
     * @return mixed
     */
    public function voteAverageCalculator()
    {
        return $this->comment->select('vote', 'status')->passed()->avg('vote');
    }

    /**
     * @param int $count
     * @return mixed
     */
    public function lastComments($count = 10)
    {
        return $this->comment
            ->select('id', 'product_id', 'user_id', 'comment', 'vote', 'updated_at')
            ->passed()
            ->orderBy('updated_at', 'desc')
            ->take($count)
            ->get();
    }

    /**
     * @return mixed
     */
    public function commentsCount()
    {
        return $this->comment->passed()->count();
    }
}
