<?php

namespace App\Traits;

use App\Models\Product;
use Exception;
use App\Services\Api\V1\ProductService;

trait HandleReview
{
    public function handleCanReview($product_id, $entity)
    {
        $productService = app()->make(ProductService::class);
        $product = $productService->findByAttribute('id', $product_id);

        $mode = $product->{$entity . '_mode'};

        if ($mode === Product::PUBLIC_MODE) {
            return true;
        }

        if ($mode === Product::ORDER_MODE && /* a query if user ordered this product*/ true) {
            return true;
        }

        throw new Exception("you can't make $entity for this product !");
    }
}
