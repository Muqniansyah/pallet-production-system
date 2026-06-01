<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    // Mendaftarkan service ke dalam container aplikasi
    public function register(): void
    {
        //
    }

    // Dijalankan saat aplikasi pertama kali booting
    public function boot(): void
    {
        // Menggunakan styling Tailwind CSS untuk pagination
        Paginator::useTailwind();
    }
}
