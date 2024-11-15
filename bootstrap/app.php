<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use \Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::namespace('\App\Http\Controllers\API')
                ->prefix('api')
                ->middleware(['api'])
                ->group(base_path('routes/api.php'));

            Route::namespace('\App\Http\Controllers\Api')
                ->name('client.')
                ->prefix('/api/client')
                ->middleware(['auth:api', \App\Http\Middleware\ClientMiddleware::class])
                ->group(base_path('routes/client.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
