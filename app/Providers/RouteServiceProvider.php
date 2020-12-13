<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapActiondRoutes();

        $this->mapOnExamRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define "action" routes (in file 'routes/action.php') for the application
     * which will be used to be called as an Action class.
     * the Controller (class Controller in file controller.js on client side) call for executing
     *  this route file through AJAX and be received a JSON Object returned.
     */
    protected function mapActiondRoutes()
    {
        Route::prefix('action')
            // We need this middleware to use some helper class such as Auth
            // This class is necessary to define Logging in user
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/action.php'));
    }

    /**
     * Define "on_exam" routes (in file 'routes/on_exam.php') for the application,
     * the Controller (class Controller in file controller.js on client side) call for executing
     *  this route file through AJAX and be received a JSON Object returned.
     */
    protected function mapOnExamRoutes()
    {
        Route::prefix('on_exam')
            // We need this middleware to use some helper class such as Auth
            // This class is necessary to define Logging in user
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/on_exam.php'));
    }
}