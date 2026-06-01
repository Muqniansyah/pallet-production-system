<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// pemanggilan models
use App\Models\Pesanan;
use App\Models\kunjungan;
use App\Models\MeetingRequest;
use App\Models\PalletRequest;

// Kolom yang boleh diisi
#[Fillable(['name', 'email', 'password', 'role'])]
// Kolom yang disembunyikan saat konversi ke array/JSON
#[Hidden(['password'])]

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Dapatkan atribut yang harus diubah tipenya (bentuk array).
     *
     * @return array<string, string>
     */

    // mengatur perubahan tipe data pada kolom saat diakses
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // menghubungkan tabel users dengan pallet request sebagai klien (relasi 1:m)
    public function palletRequests()
    {
        return $this->hasMany(PalletRequest::class, 'client_id');
    }

    // menghubungkan tabel users dengan pesanan sebagai klien (relasi 1:m)
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'client_id');
    }

    // menghubungkan tabel users dengan meetings sebagai klien (relasi 1:m)
    public function meetings()
    {
        return $this->hasMany(MeetingRequest::class, 'client_id');
    }

    // menghubungkan tabel users dengan kunjungan sebagai klien (relasi 1:m)
    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class, 'client_id');
    }
}
