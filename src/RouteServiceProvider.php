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
     * @return void
     */
    public function boot()
    {
        parent::boot();

        foreach($this->middleware as $name => $class) {
            $this->app['router']->aliasMiddleware($name, $class);
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
