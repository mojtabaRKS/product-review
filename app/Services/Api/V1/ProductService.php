<?php

namespace App\Services\Api\V1;

use Illuminate\Support\Collection;
use App\Repositories\Api\V1\Product\Criteria\WithComments;
use App\Repositories\Api\V1\Product\ProductRepositoryInterface;

class ProductService
{
    /**
     * @param ProductRepositoryInterface $productRepository
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
        return $this->productRepository
            ->getByCriteria([
                WithLast3Comments::class,
            ])->all();
    }
}