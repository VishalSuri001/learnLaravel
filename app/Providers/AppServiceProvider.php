<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Service Providers
        // $this->app->bind( 'App\Libraries\Notifications', function($app){
        //     return new \App\Libraries\Notifications;
        // });

        // Interface service container binding
        // $this->app->bind( 'App\Libraries\NotificationsInterface', function($app){
        //     return new \App\Libraries\Notifications;
        // });
    }
}
