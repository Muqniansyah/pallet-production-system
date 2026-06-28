<!DOCTYPE html>
<!-- Bahasa halaman -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Pengaturan dasar halaman -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Token CSRF keamanan untuk form dan request -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- judul -->
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- icon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- navigasi -->
        @include('layouts.navigation')

        <!-- sidebar dan konten -->
        <div class="flex">
            <!-- sidebar -->
            @auth
            @if(auth()->user()->role === 'admin')
            <x-sidebar-admin />
            @else
            <x-sidebar-client />
            @endif
            @endauth

            <!-- menampilkan konten halaman yang menggunakan layout app -->
            <main class="flex-1 p-6 min-w-0 overflow-hidden">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>
