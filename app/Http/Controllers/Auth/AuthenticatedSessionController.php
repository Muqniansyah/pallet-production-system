<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

// redirect halaman dan menangkap data inputan form
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

// pemanggilan requests
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    // Menampilkan halaman masuk atau login
    public function create(): View
    {
        return view('auth.login');
    }

    // Memproses login dan redirect berdasarkan role
    public function store(LoginRequest $request): RedirectResponse
    {
        // Autentikasi pengguna
        $request->authenticate();

        // Regenerasi sesi untuk keamanan
        $request->session()->regenerate();

        // Redirect berdasarkan role setelah login berhasil
        if (Auth::user()->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        }

        return redirect()->intended('/client/dashboard');
    }

    // Menghapus sesi login dan redirect ke halaman utama
    public function destroy(Request $request): RedirectResponse
    {
        // Logout pengguna
        Auth::guard('web')->logout();

        // Hapus sesi yang aktif
        $request->session()->invalidate();

        // Regenerasi token CSRF untuk keamanan
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
