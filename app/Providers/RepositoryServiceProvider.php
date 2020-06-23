<?php

namespace App\Providers;

use App\Repositories\HomeSliderRepository;
use App\Repositories\Interfaces\HomeSliderRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(HomeSliderRepositoryInterface::class, HomeSliderRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
