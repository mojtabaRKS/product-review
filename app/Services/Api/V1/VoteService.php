<?php

namespace App\Services\Api\V1;

use App\Models\Vote;
use App\Traits\HandleReview;
use App\Repositories\Api\V1\Vote\VoteRepository;
use App\Repositories\Api\V1\Generics\WhereAttribute;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Api\V1\Vote\VoteRepositoryInterface;

class VoteService
{
    use HandleReview;
    /**
     * @var VoteRepository $voteRepository
     */
    private VoteRepositoryInterface $voteRepository;

    /**
     * @param VoteRepository $voteRepository
     */
    public function __construct(VoteRepositoryInterface $voteRepository)
    {
        $this->voteRepository = $voteRepository;
    }

    /**
     * @param array $data
     * @return void
     */
    public function create(array $data): void
    {
        $this->handleCanReview($data['product_id'], 'vote');

        $this->voteRepository->create(
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
        $result = $this->voteRepository->getByCriteria([
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
            'rate' => $data['rate'],
            'status' => Vote::PENDING_STATUS
        ];
    }
}
