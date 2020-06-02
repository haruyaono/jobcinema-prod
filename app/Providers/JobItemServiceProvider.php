<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Job\Users\User;

class JobItemServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('JobItem', JobItem::class);
        $this->app->bind('user', User::class);
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
