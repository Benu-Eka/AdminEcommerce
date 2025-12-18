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
    $middleware->validateCsrfTokens(except: [
        'admin/chat/send', // Sesuaikan URL route Anda
    ]);
})
->withMiddleware(function (Middleware $middleware) {
    $middleware->validateCsrfTokens(except: [
        'admin/logout', // Tambahkan ini agar logout tidak butuh token CSRF
    ]);
})
    ->withMiddleware(function (Middleware $middleware) {
        // 1. DAFTARKAN MIDDLEWARE SEBAGAI ALIAS (UNTUK ROUTE)
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminRoleMiddleware::class,
        ]);

        // 2. DAFTARKAN MIDDLEWARE SECARA GLOBAL (JIKA PERLU)
        // $middleware->web(append: [
        //     \App\Http\Middleware\AdminRoleMiddleware::class,
        // ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
