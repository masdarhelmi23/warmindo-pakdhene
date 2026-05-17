<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // REVISI FIX: Menggunakan class konfigurasi Middleware internal yang benar
        $middleware->alias([
            'role'        => \App\Http\Middleware\CheckRole::class,
            'sudah_login' => \App\Http\Middleware\RedirectIfLoggedIn::class,
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();