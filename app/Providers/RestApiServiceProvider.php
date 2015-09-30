<?php

namespace App\Providers;

use App\RestApi;
use Illuminate\Support\ServiceProvider;

class RestApiServiceProvider extends ServiceProvider
{
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
        $this->app->bind('App\RestApi', function () {
            return new RestApi(app('Game'));
        });
    }
}
