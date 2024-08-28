<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */

    protected $namespaceApi = 'App\\Http\\Controllers\\Api';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */

    public function boot()
    {
        $this->configureRateLimiting();

        $this->mapApiRoutes();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespaceApi)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => ['api', 'api_version:v1'],
            'namespace'  => "{$this->namespaceApi}\V1",
            'prefix'     => 'api/v1',
        ], function ($router) {
            require base_path('routes/api_v1.php');
        });    
        // Route::group([
        //     'middleware' => ['api', 'api_version:v2'],
        //     'namespace'  => "{$this->namespaceApi}\V2",
        //     'prefix'     => 'api/v2',
        // ], function ($router) {
        //     require base_path('routes/api_v2.php');
        // });
    }
}
