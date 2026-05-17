<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register our custom role middleware with short alias names
        // Now we can use ->middleware('farmer') in routes
        $middleware->alias([
            'farmer' => \App\Http\Middleware\FarmerMiddleware::class,
            'driver' => \App\Http\Middleware\DriverMiddleware::class,
            'admin'  => \App\Http\Middleware\AdminMiddleware::class,
        ]);
        $middleware->prepend(\App\Http\Middleware\SetLocale::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();