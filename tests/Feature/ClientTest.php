<?php

use App\Models\User;

// ═══════════════════════════════════════════
// HALAMAN — akses halaman kelola klien
// ═══════════════════════════════════════════

test('admin dapat mengakses halaman kelola klien', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin/client')
        ->assertStatus(200);
});

test('guest tidak bisa mengakses halaman kelola klien', function () {
    $this->get('/admin/client')
        ->assertRedirect('/login');
});

test('klien tidak bisa mengakses halaman kelola klien', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/admin/client')
        ->assertStatus(403);
});

// ═══════════════════════════════════════════
// UPDATE ROLE — admin ubah role user
// ═══════════════════════════════════════════

test('admin dapat mengubah role client menjadi admin', function () {
    $admin = User::factory()->admin()->create();
    $klien = User::factory()->client()->create();

    $response = $this->actingAs($admin)
        ->patch("/admin/client/{$klien->id}/role", [
            'role' => 'admin',
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('users', [
        'id'   => $klien->id,
        'role' => 'admin',
    ]);
});

test('admin dapat mengubah role admin menjadi client', function () {
    $admin      = User::factory()->admin()->create();
    $adminLain  = User::factory()->admin()->create();

    $response = $this->actingAs($admin)
        ->patch("/admin/client/{$adminLain->id}/role", [
            'role' => 'client',
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('users', [
        'id'   => $adminLain->id,
        'role' => 'client',
    ]);
});

test('update role gagal jika role tidak valid', function () {
    $admin = User::factory()->admin()->create();
    $klien = User::factory()->client()->create();

    $response = $this->actingAs($admin)
        ->patch("/admin/client/{$klien->id}/role", [
            'role' => 'superadmin', // role tidak valid
        ]);

    $response->assertSessionHasErrors('role');
    $this->assertDatabaseHas('users', [
        'id'   => $klien->id,
        'role' => 'client', // tidak berubah
    ]);
});

test('update role gagal jika role kosong', function () {
    $admin = User::factory()->admin()->create();
    $klien = User::factory()->client()->create();

    $response = $this->actingAs($admin)
        ->patch("/admin/client/{$klien->id}/role", [
            'role' => '',
        ]);

    $response->assertSessionHasErrors('role');
});

test('klien tidak bisa mengubah role user lain', function () {
    $klien      = User::factory()->client()->create();
    $klienLain  = User::factory()->client()->create();

    $this->actingAs($klien)
        ->patch("/admin/client/{$klienLain->id}/role", [
            'role' => 'admin',
        ])
        ->assertStatus(403);
});
