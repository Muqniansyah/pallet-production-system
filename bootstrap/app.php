<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    // Mendaftarkan file route yang digunakan aplikasi
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust semua proxy (untuk Railway/hosting)
        $middleware->trustProxies(at: '*');

        // Mendaftarkan alias middleware
        $middleware->alias([
            'isAdmin' => \App\Http\Middleware\IsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Penanganan error aplikasi (menggunakan bawaan Laravel)
    })->create();
