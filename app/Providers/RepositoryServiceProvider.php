<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Job\Categories\Repositories\CategoryRepository;
use App\Job\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Job\JobItems\Repositories\Interfaces\JobItemRepositoryInterface;
use App\Job\JobItems\Repositories\JobItemRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );

        $this->app->bind(
            JobItemRepositoryInterface::class,
            JobItemRepository::class
        );
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
