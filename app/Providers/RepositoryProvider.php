<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Api\V1\Product\ProductRepository;
use App\Repositories\Api\V1\Product\ProductRepositoryInterface;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }
}
