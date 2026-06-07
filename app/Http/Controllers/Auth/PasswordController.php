<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

// redirect halaman dan menangkap data inputan form
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

// enkripsi dan validasi password
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    // Memperbarui sandi pengguna yang sedang masuk atau login
    public function update(Request $request): RedirectResponse
    {
        // Validasi sandi lama dan sandi baru
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // Simpan sandi baru yang sudah dienkripsi
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
