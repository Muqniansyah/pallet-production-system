<?php

use Illuminate\Support\Facades\Route;

// Profile Controller
use App\Http\Controllers\ProfileController;

// Auth Controller
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;

// route di dalamnya hanya bisa diakses oleh pengguna yang belum login
Route::middleware('guest')->group(function () {
    // daftar / register
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // masuk / login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// route di dalamnya hanya bisa diakses oleh pengguna yang sudah login.
Route::middleware('auth')->group(function () {
    // ganti password
    Route::put('password', [PasswordController::class, 'update'])
        ->name('password.update');

    // hapus akun
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // keluar / logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
