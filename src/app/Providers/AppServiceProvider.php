<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\ShopService;

use App\Repositories\AreaRepository;
use App\Repositories\GenreRepository;
use App\Repositories\ShopRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Service
        // wired(ShopService)
        $this->app->singleton(ShopService::class, ShopService::class);

        // Repository
        // wired(AreaRepository)
        $this->app->singleton(AreaRepository::class, AreaRepository::class);

        // wired(GenreRepository)
        $this->app->singleton(GenreRepository::class, GenreRepository::class);

        // wired(ShopRepository)
        $this->app->singleton(ShopRepository::class, ShopRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
