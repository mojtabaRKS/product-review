<?php

namespace App\Providers;

use App\Repositories\Api\V1\CommentRepository;
use App\Repositories\Api\V1\CommentRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Api\V1\Product\ProductRepository;
use App\Repositories\Api\V1\Product\ProductRepositoryInterface;
use App\Repositories\Api\V1\Vote\VoteRepository;
use App\Repositories\Api\V1\Vote\VoteRepositoryInterface;

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
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(VoteRepositoryInterface::class, VoteRepository::class);
    }
}
