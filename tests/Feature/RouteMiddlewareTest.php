<?php

use App\Models\User;

// ═══════════════════════════════════════════
// GUEST — belum login tidak bisa akses route protected
// ═══════════════════════════════════════════

test('guest tidak bisa akses client dashboard', function () {
    $this->get('/client/dashboard')
        ->assertRedirect('/login');
});

test('guest tidak bisa akses client pallet request', function () {
    $this->get('/client/pallet-request')
        ->assertRedirect('/login');
});

test('guest tidak bisa akses client pesanan', function () {
    $this->get('/client/pesanan')
        ->assertRedirect('/login');
});

test('guest tidak bisa akses client meeting', function () {
    $this->get('/client/meeting-request')
        ->assertRedirect('/login');
});

test('guest tidak bisa akses client kunjungan', function () {
    $this->get('/client/kunjungan')
        ->assertRedirect('/login');
});

test('guest tidak bisa akses client referensi', function () {
    $this->get('/client/referensi')
        ->assertRedirect('/login');
});

test('guest tidak bisa akses client informasi', function () {
    $this->get('/client/informasi')
        ->assertRedirect('/login');
});

test('guest tidak bisa akses admin dashboard', function () {
    $this->get('/admin/dashboard')
        ->assertRedirect('/login');
});

test('guest tidak bisa akses admin client', function () {
    $this->get('/admin/client')
        ->assertRedirect('/login');
});

test('guest tidak bisa akses admin pallet request', function () {
    $this->get('/admin/pallet-request')
        ->assertRedirect('/login');
});

test('guest tidak bisa akses admin hpp', function () {
    $this->get('/admin/hpp')
        ->assertRedirect('/login');
});

test('guest tidak bisa akses admin meeting', function () {
    $this->get('/admin/meeting')
        ->assertRedirect('/login');
});

test('guest tidak bisa akses admin kunjungan', function () {
    $this->get('/admin/kunjungan')
        ->assertRedirect('/login');
});

test('guest tidak bisa akses admin stok', function () {
    $this->get('/admin/stok')
        ->assertRedirect('/login');
});

// ═══════════════════════════════════════════
// CLIENT — tidak bisa akses route admin
// ═══════════════════════════════════════════

test('klien tidak bisa akses admin dashboard', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/admin/dashboard')
        ->assertStatus(403);
});

test('klien tidak bisa akses admin client', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/admin/client')
        ->assertStatus(403);
});

test('klien tidak bisa akses admin pallet request', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/admin/pallet-request')
        ->assertStatus(403);
});

test('klien tidak bisa akses admin hpp', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/admin/hpp')
        ->assertStatus(403);
});

test('klien tidak bisa akses admin meeting', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/admin/meeting')
        ->assertStatus(403);
});

test('klien tidak bisa akses admin kunjungan', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/admin/kunjungan')
        ->assertStatus(403);
});

test('klien tidak bisa akses admin stok', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/admin/stok')
        ->assertStatus(403);
});

// ═══════════════════════════════════════════
// ADMIN — bisa akses route admin
// ═══════════════════════════════════════════

test('admin bisa akses admin dashboard', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin/dashboard')
        ->assertStatus(200);
});

test('admin bisa akses admin client', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin/client')
        ->assertStatus(200);
});

test('admin bisa akses admin pallet request', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin/pallet-request')
        ->assertStatus(200);
});

test('admin bisa akses admin hpp', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin/hpp')
        ->assertStatus(200);
});

test('admin bisa akses admin meeting', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin/meeting')
        ->assertStatus(200);
});

test('admin bisa akses admin kunjungan', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin/kunjungan')
        ->assertStatus(200);
});

test('admin bisa akses admin stok', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin/stok')
        ->assertStatus(200);
});

// ═══════════════════════════════════════════
// CLIENT — bisa akses route client sendiri
// ═══════════════════════════════════════════

test('klien bisa akses client dashboard', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/client/dashboard')
        ->assertStatus(200);
});

test('klien bisa akses client referensi', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/client/referensi')
        ->assertStatus(200);
});

test('klien bisa akses client pallet request', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/client/pallet-request')
        ->assertStatus(200);
});

test('klien bisa akses client pesanan', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/client/pesanan')
        ->assertStatus(200);
});

test('klien bisa akses client meeting', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/client/meeting-request')
        ->assertStatus(200);
});

test('klien bisa akses client kunjungan', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/client/kunjungan')
        ->assertStatus(200);
});

test('klien bisa akses client informasi', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/client/informasi')
        ->assertStatus(200);
});

// ═══════════════════════════════════════════
// REDIRECT — dashboard redirect sesuai role
// ═══════════════════════════════════════════

test('dashboard redirect ke client dashboard jika role client', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/dashboard')
        ->assertRedirect('/client/dashboard');
});

test('dashboard redirect ke admin dashboard jika role admin', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/dashboard')
        ->assertRedirect('/admin/dashboard');
});
