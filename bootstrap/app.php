<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\ClientMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'clientMW' => \App\Http\Middleware\ClientMiddleware::class,
            'driverMW' => \App\Http\Middleware\DriverMiddleware::class,
            'adminMW' => \App\Http\Middleware\AdminMiddleware::class,
            'eitherCorD' => \App\Http\Middleware\EitherClientOrDriverMiddleware::class,
            'Unauth' => \App\Http\Middleware\UnAuthenticatedMiddleware::class,
            'eitherDorA' => \App\Http\Middleware\EitherAdminOrDriverMiddleware::class,
            'Dpending' => \App\Http\Middleware\DriverPendingMiddleware::class,
            'Drejected' => \App\Http\Middleware\DriverRejectedMiddleware::class,



        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
