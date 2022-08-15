<?php

namespace App\Providers;

use App\Cache\PostCache;
use App\Cache\UserCache;
use App\Contracts\PostRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var array|string[]
     */
    public array $bindings = [
        PostRepositoryInterface::class => PostCache::class,
        UserRepositoryInterface::class => UserCache::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();
    }
}
