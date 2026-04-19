<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// controller
use App\Http\Controllers\Admin\ClientController;
/* use App\Http\Controllers\PaletDesignController; */

Route::get('/', function () {
    return view('sipalet');
});



// Route untuk menerima data real-time dari Netlify (tidak perlu auth agar iframe bisa kirim)
// Route::post('/palet/sync', [PaletDesignController::class, 'sync']);

// Route untuk mengambil data (perlu login)
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/palet/designs', [PaletDesignController::class, 'index']);
// });


// WAJIB: dashboard fallback (biar Breeze tidak error) - redirect dashboard
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect('/admin/dashboard');
    }
    return redirect('/client/dashboard');
})->middleware(['auth'])->name('dashboard');


// ADMIN dashboard
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/client', [ClientController::class, 'index']);

    Route::patch('/client/{id}/role', [ClientController::class, 'updateRole'])
        ->name('admin.client.updateRole');
});


// CLIENT dashboard
Route::middleware(['auth'])->prefix('client')->group(function () {

    Route::get('/dashboard', function () {
        return view('client.dashboard');
    });
});


// PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
