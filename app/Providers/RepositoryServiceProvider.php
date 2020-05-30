<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Job\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Job\Users\Repositories\UserRepository;
use App\Job\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Job\Categories\Repositories\CategoryRepository;
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
            UserRepositoryInterface::class,
            UserRepository::class
        );

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
