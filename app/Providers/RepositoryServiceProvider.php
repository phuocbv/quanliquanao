<?php

namespace Laraspace\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected static $repositories = [
        'user' => [
            \Laraspace\Repositories\Contracts\UserRepositoryInterface::class,
            \Laraspace\Repositories\UserRepositoryEloquent::class
        ],
        'supplier' => [
            \Laraspace\Repositories\Contracts\SupplierRepositoryInterface::class,
            \Laraspace\Repositories\SupplierRepositoryEloquent::class
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        foreach (static::$repositories as $repository) {
            $this->app->singleton(
                $repository[0],
                $repository[1]
            );
        }
    }
}
