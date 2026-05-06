<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',        // minimal 1 huruf besar
                'regex:/[a-z]/',        // minimal 1 huruf kecil
                'regex:/[0-9]/',        // minimal 1 angka
                'regex:/[@$!%*#?&^]/', // minimal 1 simbol
            ],
        ], [
            'name.required'   => 'Nama lengkap wajib diisi.',
            'name.string'     => 'Nama harus berupa teks.',
            'name.max'        => 'Nama tidak boleh lebih dari 255 karakter.',

            'email.required'  => 'Alamat email wajib diisi.',
            'email.string'    => 'Email harus berupa teks.',
            'email.lowercase' => 'Email harus menggunakan huruf kecil.',
            'email.email'     => 'Format email tidak valid.',
            'email.max'       => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique'    => 'Email ini sudah terdaftar. Gunakan email lain atau masuk.',

            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal harus 8 karakter.',
            'password.regex'     => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol (contoh: !@#$%^&*).',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'client',
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/client/dashboard');
    }
}
