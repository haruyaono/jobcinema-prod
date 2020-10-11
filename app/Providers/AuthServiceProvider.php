<?php

namespace App\Providers;

use App\Job\JobItems\JobItem;
use App\Policies\JobItemPolicy;
use App\Providers\CustomProvider\CustomAuthServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        JobItem::class => JobItemPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('custom_auth', function ($app, array $config) {
            return new CustomAuthServiceProvider($this->app['hash'], $config['model']);
        });
    }
}
