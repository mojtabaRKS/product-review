<?php

namespace App\Services\Api\V1;

use App\Models\Comment;
use App\Traits\HandleReview;
use App\Repositories\Api\V1\Generics\WhereAttribute;
use App\Repositories\Api\V1\Comment\CommentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Api\V1\Comment\CommentRepositoryInterface;

class CommentService
{
    use HandleReview;
    
    /**
     * @var CommentRepository $commentRepository
     */
    private CommentRepositoryInterface $commentRepository;

    /**
     * @var CommentRepository $commentRepository
     */
    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param array $data
     * @return void
     */
    public function create(array $data): void
    {
        $this->handleCanReview($data['product_id'], 'comment');

        $this->commentRepository->create(
            $this->prepareData($data)
        );
    }

    /**
     * @param int $id
     * @param array $data
     * 
     * @return void
     */
    public function changeStatus($id, array $data): void
    {
        $result = $this->commentRepository->getByCriteria([
            new WhereAttribute('id', $id)
        ])->getQueryBuilder()
            ->update(['status' => $data['status']]);

        if ($result === 0) {
            throw (new ModelNotFoundException)->setModel(Comment::class, $id);
        }
    }

    /**
     * @param array $data
     * @return array
     */
    private function prepareData(array $data): array
    {
        return [
            'product_id' => $data['product_id'],
            'user_id' => auth()->id() ?? mt_rand(1, 10),
            'description' => $data['description'],
            'status' => Comment::PENDING_STATUS
        ];
    }
}
