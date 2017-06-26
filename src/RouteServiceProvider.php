<?php namespace Iw\Api;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Iw\Api\Http\Middleware\AuthToken;
use Iw\Api\Http\Middleware\DataRequired;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * All of the short-hand keys for middlewares.
     *
     * @var array
     */
    protected $middleware = [
      'auth_token' => AuthToken::class,
      'data_required' => DataRequired::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        foreach($this->middleware as $name => $class) {
            $this->middleware($name, $class);
        }
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {

    }
}
