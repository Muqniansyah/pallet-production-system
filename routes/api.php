<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaletDesignController;

// Yang lama (biarkan kalau ada):
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Tambahkan ini:
Route::post('/palet/sync', [PaletDesignController::class, 'sync']);
// Route::middleware('web')->get('/palet/designs', [PaletDesignController::class, 'index']);
Route::middleware(['web'])->get('/palet/designs', [PaletDesignController::class, 'index']);
