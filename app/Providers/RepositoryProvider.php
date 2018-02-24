<?php

namespace App\Providers;

use App\Infrastracture\Repositories\EloquentItemRepository;
use App\Repositories\ItemRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ItemRepository::class, EloquentItemRepository::class);
    }
}
