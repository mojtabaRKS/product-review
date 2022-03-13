<?php

namespace App\Services\Api\V1;

use App\Models\Product;
use Illuminate\Support\Collection;
use App\Repositories\Api\V1\Generics\WhereAttribute;
use App\Repositories\Api\V1\Product\ProductRepository;
use App\Repositories\Api\V1\Product\Criteria\WithComments;
use App\Repositories\Api\V1\Product\Criteria\WhereIsVisible;
use App\Repositories\Api\V1\Product\Criteria\WithCommentsCount;
use App\Repositories\Api\V1\Product\Criteria\WithLast3Comments;
use App\Repositories\Api\V1\Product\Criteria\WithVotesAverage;
use App\Repositories\Api\V1\Product\ProductRepositoryInterface;

class ProductService
{
    /**
     * @var ProductRepository
     */
    private ProductRepositoryInterface $productRepository;

    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->productRepository->getByCriteria([
            WithCommentsCount::class,
            WithVotesAverage::class,
            WhereIsVisible::class,
            WithLast3Comments::class,
        ])->all();
    }

    /**
     * @param int $id
     *
     * @return Product
     */
    public function find($id): Product
    {
        return $this->productRepository->getByCriteria([
            WithComments::class,
            WithCommentsCount::class,
            WithVotesAverage::class,
            new WhereAttribute('id', $id),
        ])->firstOrFail();
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return void
     */
    public function update($id, array $data): void
    {
        $product = $this->productRepository->getByCriteria([
            new WhereAttribute('id', $id),
        ])->firstOrFail();

        $this->productRepository->update($product, $data);
    }
}
