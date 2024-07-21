<?php

namespace App\Providers;

use App\Interfaces\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;

class ProductRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
