<?php

namespace App\Providers;

use App\Cache\PostCache;
use App\Contracts\PostRepositoryInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    public $bindings = [
        PostRepositoryInterface::class => PostCache::class,
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
