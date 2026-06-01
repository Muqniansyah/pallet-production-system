<?php

namespace Database\Seeders;

// Import kelas yang dibutuhkan untuk seeder
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Pemanggilan model User
use App\Models\User;

// Untuk enkripsi password
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    // Membuat akun admin default jika belum ada
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
    }
}
