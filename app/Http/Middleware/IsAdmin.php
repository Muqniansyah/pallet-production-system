<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    // Memeriksa apakah pengguna yang mengakses memiliki role admin
    public function handle(Request $request, Closure $next): Response
    {
        // Tolak akses dengan error 403 jika bukan admin
        if (auth()->user()->role != 'admin') {
            abort(403);
        }
        // Lanjutkan request jika pengguna adalah admin
        return $next($request);
    }
}
