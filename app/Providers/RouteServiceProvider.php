<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

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

        //
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

        Route::middleware(['web', 'hakakses:mahasiswa'])
             ->namespace($this->namespace)
             ->group(base_path('routes/web/mahasiswa.php'));

        Route::middleware(['web', 'hakakses:panitia'])
             ->namespace($this->namespace)
             ->group(base_path('routes/web/panitia.php'));

        Route::middleware(['web', 'hakakses:root'])
             ->namespace($this->namespace)
             ->group(base_path('routes/web/root.php'));
        
        Route::middleware(['web', 'dosen'])
             ->namespace($this->namespace)
             ->group(base_path('routes/web/wd3dosen.php'));
        
        Route::middleware(['web', 'hakakses:admin'])
             ->namespace($this->namespace)
             ->group(base_path('routes/web/admin.php'));
        
             Route::middleware(['web', 'hakakses:ketua kpu'])
             ->namespace($this->namespace)
             ->group(base_path('routes/web/ketuakpu.php'));
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
}
