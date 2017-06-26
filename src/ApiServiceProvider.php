<?php

namespace Iw\Api;

use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    public function boot()
    {


        $this->publishes([
          __DIR__.'/../resources/config/iw_api.php' => config_path('iw_api.php'),
        ]);
    }


    public function register()
    {

        $this->app->register('Spatie\Fractal\FractalServiceProvider');
        $this->app->register('Iw\Api\RouteServiceProvider');
    }
}
