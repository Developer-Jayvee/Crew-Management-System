<?php

namespace App\Providers;

use App\Helpers\Helpers;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('helper-service', function ($app) {
            return new Helpers();
        });
    }

    public function boot()
    {
        //
    }
}