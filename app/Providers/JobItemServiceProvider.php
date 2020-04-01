<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
