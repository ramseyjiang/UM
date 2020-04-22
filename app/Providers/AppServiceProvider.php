<?php

namespace Um\Providers;

use Illuminate\Support\ServiceProvider;
use Um\Contracts\Repositories\UserRepositoryContract;
use Um\Contracts\Services\UserServiceContract;
use Um\Repositories\UserRepository;
use Um\Services\UserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(UserServiceContract::class, UserService::class);
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
