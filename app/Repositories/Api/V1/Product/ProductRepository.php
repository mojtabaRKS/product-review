<?php

namespace App\Repositories\Api\V1\Product;

use App\Models\Product;
use App\Repositories\Api\V1\Contracts\Repository;
use App\Repositories\Api\V1\Product\ProductRepositoryInterface;

class ProductRepository extends Repository implements ProductRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Product::class;
    }
}