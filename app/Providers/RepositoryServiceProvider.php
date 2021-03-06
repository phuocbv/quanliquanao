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
        'product' => [
            \Laraspace\Repositories\Contracts\ProductRepositoryInterface::class,
            \Laraspace\Repositories\ProductRepositoryEloquent::class
        ],
        'brand' => [
            \Laraspace\Repositories\Contracts\BrandRepositoryInterface::class,
            \Laraspace\Repositories\BrandRepositoryEloquent::class
        ],
        'color' => [
            \Laraspace\Repositories\Contracts\ColorRepositoryInterface::class,
            \Laraspace\Repositories\ColorRepositoryEloquent::class
        ],
        'size' => [
            \Laraspace\Repositories\Contracts\SizeRepositoryInterface::class,
            \Laraspace\Repositories\SizeRepositoryEloquent::class
        ],
        'category' => [
            \Laraspace\Repositories\Contracts\CategoryRepositoryInterface::class,
            \Laraspace\Repositories\CategoryRepositoryEloquent::class
        ],
        [
            \Laraspace\Repositories\Contracts\EspPricingDefaultRepositoryInterface::class,
            \Laraspace\Repositories\EspPricingDefaultRepositoryEloquent::class
        ],
        [
            \Laraspace\Repositories\Contracts\SupplierPricingRepositoryInterface::class,
            \Laraspace\Repositories\SupplierPricingRepositoryEloquent::class
        ],
        [
            \Laraspace\Repositories\Contracts\ProductSizeRepositoryInterface::class,
            \Laraspace\Repositories\ProductSizeRepositoryEloquent::class
        ],
        [
            \Laraspace\Repositories\Contracts\ProductColorRepositoryInterface::class,
            \Laraspace\Repositories\ProductColorRepositoryEloquent::class
        ],
        [
            \Laraspace\Repositories\Contracts\EspPricingRepositoryInterface::class,
            \Laraspace\Repositories\EspPricingRepositoryEloquent::class
        ],
        [
            \Laraspace\Repositories\Contracts\AttributeValueRepositoryInterface::class,
            \Laraspace\Repositories\AttributeValueRepositoryEloquent::class
        ]
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
