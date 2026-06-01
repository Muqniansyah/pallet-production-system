<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Menonaktifkan event model saat seeder berjalan
    use WithoutModelEvents;

    // Menjalankan semua seeder yang terdaftar
    public function run(): void
    {
        // menjalankan seeder AdminSeeder 
        $this->call([
            AdminSeeder::class,
        ]);
    }
}
