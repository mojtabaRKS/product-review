<?php

namespace App\Services\Api\V1;

use App\Models\Vote;
use App\Repositories\Api\V1\Vote\VoteRepository;
use App\Repositories\Api\V1\Vote\VoteRepositoryInterface;

class VoteService
{
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
        $this->voteRepository->create(
            $this->prepareData($data)
        );
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
