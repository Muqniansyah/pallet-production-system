<?php

use App\Models\User;

// ═══════════════════════════════════════════
// HALAMAN AUTH — apakah halaman bisa diakses
// ═══════════════════════════════════════════

test('halaman login dapat diakses', function () {
    $response = $this->get('/login');
    $response->assertStatus(200);
});

test('halaman register dapat diakses', function () {
    $response = $this->get('/register');
    $response->assertStatus(200);
});

// ═══════════════════════════════════════════
// REGISTER — pendaftaran akun baru
// ═══════════════════════════════════════════

test('klien baru dapat mendaftar', function () {
    $response = $this->post('/register', [
        'name'                  => 'Klien Baru',
        'email'                 => 'klien@example.com',
        'password'              => 'Password1!',
        'password_confirmation' => 'Password1!',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('users', [
        'email' => 'klien@example.com',
        'role'  => 'client',
    ]);
});

test('register gagal jika email sudah terdaftar', function () {
    User::factory()->create(['email' => 'duplikat@example.com']);

    $response = $this->post('/register', [
        'name'                  => 'Klien Dua',
        'email'                 => 'duplikat@example.com',
        'password'              => 'Password1!',
        'password_confirmation' => 'Password1!',
    ]);

    $response->assertSessionHasErrors('email');
});

test('register gagal jika password tidak memenuhi syarat', function () {
    $response = $this->post('/register', [
        'name'                  => 'Klien Test',
        'email'                 => 'test@example.com',
        'password'              => '12345678', // tidak ada huruf besar, simbol
        'password_confirmation' => '12345678',
    ]);

    $response->assertSessionHasErrors('password');
});

test('register gagal jika konfirmasi password tidak cocok', function () {
    $response = $this->post('/register', [
        'name'                  => 'Klien Test',
        'email'                 => 'test@example.com',
        'password'              => 'Password1!',
        'password_confirmation' => 'BedaPassword1!',
    ]);

    $response->assertSessionHasErrors('password');
});

// ═══════════════════════════════════════════
// LOGIN — masuk ke sistem
// ═══════════════════════════════════════════

test('klien dapat login dengan kredensial yang benar', function () {
    $klien = User::factory()->client()->create([
        'email'    => 'klien@example.com',
        'password' => bcrypt('Password1!'),
    ]);

    $response = $this->post('/login', [
        'email'    => 'klien@example.com',
        'password' => 'Password1!',
    ]);

    $response->assertRedirect('/client/dashboard');
    $this->assertAuthenticatedAs($klien);
});

test('admin dapat login dengan kredensial yang benar', function () {
    $admin = User::factory()->admin()->create([
        'email'    => 'admin@example.com',
        'password' => bcrypt('Password1!'),
    ]);

    $response = $this->post('/login', [
        'email'    => 'admin@example.com',
        'password' => 'Password1!',
    ]);

    $response->assertRedirect('/admin/dashboard');
    $this->assertAuthenticatedAs($admin);
});

test('login gagal dengan password salah', function () {
    User::factory()->client()->create([
        'email'    => 'klien@example.com',
        'password' => bcrypt('Password1!'),
    ]);

    $response = $this->post('/login', [
        'email'    => 'klien@example.com',
        'password' => 'passwordsalah',
    ]);

    $response->assertSessionHasErrors();
    $this->assertGuest();
});

test('login gagal dengan email yang tidak terdaftar', function () {
    $response = $this->post('/login', [
        'email'    => 'tidakada@example.com',
        'password' => 'Password1!',
    ]);

    $response->assertSessionHasErrors();
    $this->assertGuest();
});

// ═══════════════════════════════════════════
// MIDDLEWARE GUEST — sudah login tidak bisa akses login/register
// ═══════════════════════════════════════════

test('user yang sudah login tidak bisa akses halaman login', function () {
    $klien = User::factory()->client()->create();

    $response = $this->actingAs($klien)->get('/login');
    $response->assertRedirect();
});

test('user yang sudah login tidak bisa akses halaman register', function () {
    $klien = User::factory()->client()->create();

    $response = $this->actingAs($klien)->get('/register');
    $response->assertRedirect();
});

// ═══════════════════════════════════════════
// LOGOUT — keluar dari sistem
// ═══════════════════════════════════════════

test('user dapat logout', function () {
    $klien = User::factory()->client()->create();

    $response = $this->actingAs($klien)->post('/logout');

    $response->assertRedirect('/');
    $this->assertGuest();
});
