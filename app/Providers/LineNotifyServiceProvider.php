<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LineNotifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'lineNotify',
            'App\Http\Components\LineNotify'
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
