<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

// redirect halaman dan menangkap data inputan form
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

// pemanggilan requests
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    // Menampilkan halaman edit profil pengguna
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    // Memperbarui informasi profil pengguna
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Isi data profil dengan input yang sudah divalidasi
        $request->user()->fill($request->validated());

        // Simpan perubahan ke database
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // Menghapus akun pengguna yang sedang login / masuk
    public function destroy(Request $request): RedirectResponse
    {
        // Validasi konfirmasi password sebelum hapus akun
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Simpan data pengguna sebelum logout agar tidak null saat dihapus
        $user = $request->user();

        // Logout pengguna sebelum akun dihapus
        Auth::logout();

        // Hapus akun dari database
        $user->delete();

        // Hapus sesi yang aktif
        $request->session()->invalidate();
        // Regenerasi token CSRF untuk keamanan
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
