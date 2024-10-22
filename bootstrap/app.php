<?php

use App\Http\Middleware\ApiAuth;
use App\Http\Middleware\ChangeLang;
use App\Http\Middleware\isAdmin;
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
        $middleware->alias([
            'isAdmin'=>isAdmin::class,
            'ApiAuth'=>ApiAuth::class
        ]);
        $middleware->web(append:ChangeLang::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
