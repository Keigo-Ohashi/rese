<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\AdminService;
use App\Services\UserService;
use App\Services\ShopService;
use App\Services\ReservationService;

use App\Repositories\AreaRepository;
use App\Repositories\GenreRepository;
use App\Repositories\LikeRepository;
use App\Repositories\ShopRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\UserRepository;

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
        // wired(AdminService)
        $this->app->singleton(AdminService::class, AdminService::class);

        // wired(UserService)
        $this->app->singleton(UserService::class, UserService::class);

        // wired(ShopService)
        $this->app->singleton(ShopService::class, ShopService::class);

        // wired(ReservationService)
        $this->app->singleton(ReservationService::class, ReservationService::class);

        // Repository
        // wired(AreaRepository)
        $this->app->singleton(AreaRepository::class, AreaRepository::class);

        // wired(GenreRepository)
        $this->app->singleton(GenreRepository::class, GenreRepository::class);

        // wired(LikeRepository)
        $this->app->singleton(LikeRepository::class, LikeRepository::class);

        // wired(ShopRepository)
        $this->app->singleton(ShopRepository::class, ShopRepository::class);

        // wired(ReservationRepository)
        $this->app->singleton(ReservationRepository::class, ReservationRepository::class);

        // wired(UserRepository)
        $this->app->singleton(UserRepository::class, UserRepository::class);
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
