<?php

namespace App\Providers;

use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }
}
