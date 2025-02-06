<?php

namespace App\Providers;

use App\Clients\ElasticSearchClient;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\ProductSearchRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\ProductSearchRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ProductRepositoryInterface::class,ProductRepository::class);
        $this->app->bind(ElasticSearchClient::class, fn ($app) => new ElasticSearchClient());
        $this->app->bind(ProductSearchRepositoryInterface::class, ProductSearchRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
