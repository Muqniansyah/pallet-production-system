<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    // Mengizinkan semua pengguna untuk mengakses request ini
    public function authorize(): bool
    {
        return true;
    }

    // Aturan validasi input login
    public function rules(): array
    {
        return [
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    // Pesan validasi dalam bahasa Indonesia (DITAMBAHKAN — tidak ada di versi asli Breeze)
    public function messages(): array
    {
        return [
            'email.required'    => 'Alamat email wajib diisi.',
            'email.string'      => 'Email harus berupa teks.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.string'   => 'Password harus berupa teks.',
        ];
    }

    // Memproses autentikasi login dengan email dan password
    public function authenticate(): void
    {
        // Pastikan belum melebihi batas percobaan login
        $this->ensureIsNotRateLimited();

        // Gagalkan login jika email atau password salah
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            // Tambah hitungan percobaan login yang gagal
            RateLimiter::hit($this->throttleKey());

            // Tampilkan pesan error jika email atau password salah
            throw ValidationException::withMessages([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ]);
        }

        // Reset hitungan percobaan login setelah berhasil
        RateLimiter::clear($this->throttleKey());
    }

    // Memastikan login tidak melebihi batas percobaan (maksimal 5 kali)
    public function ensureIsNotRateLimited(): void
    {
        // Lanjutkan jika belum melebihi batas percobaan
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        // Jalankan event Lockout saat batas percobaan terlampaui
        event(new Lockout($this));

        // Ambil sisa waktu tunggu dalam detik
        $seconds = RateLimiter::availableIn($this->throttleKey());

        // Tampilkan pesan error beserta sisa waktu tunggu
        throw ValidationException::withMessages([
            'email' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam ' . $seconds . ' detik.',
        ]);
    }

    // Membuat kunci unik untuk rate limiter berdasarkan email dan IP
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
