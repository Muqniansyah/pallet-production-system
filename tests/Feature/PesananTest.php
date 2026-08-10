<?php

use App\Models\User;
use App\Models\Pesanan;
use App\Models\PalletRequest;
use App\Models\ProdukKayu;

// Helper untuk buat pallet request
function buatPalletRequest($klien, $status = 'disetujui')
{
    return PalletRequest::create([
        'client_id'    => $klien->id,
        'jenis_palet'  => 'Palet Kayu Jati',
        'qty'          => 100,
        'alamat_kirim' => 'Jl. Contoh No. 1',
        'catatan'      => 'Test',
        'status'       => $status,
    ]);
}

// Helper untuk buat pesanan
function buatPesanan($klien, $pallet, $status = 'pending')
{
    return Pesanan::create([
        'client_id'         => $klien->id,
        'pallet_request_id' => $pallet->id,
        'nama_project'      => 'Project Test ' . uniqid(),
        'qty'               => $pallet->qty,
        'status'            => $status,
    ]);
}

// ═══════════════════════════════════════════
// HALAMAN — akses halaman pesanan
// ═══════════════════════════════════════════

test('klien dapat mengakses halaman pesanan', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/client/pesanan')
        ->assertStatus(200);
});

test('guest tidak bisa mengakses halaman pesanan', function () {
    $this->get('/client/pesanan')
        ->assertRedirect('/login');
});

// ═══════════════════════════════════════════
// ADMIN STORE — admin membuat pesanan baru
// ═══════════════════════════════════════════

test('admin dapat membuat pesanan dari pallet request', function () {
    $admin  = User::factory()->admin()->create();
    $klien  = User::factory()->client()->create();
    $pallet = buatPalletRequest($klien);

    $response = $this->actingAs($admin)
        ->post('/admin/pesanan', [
            'pallet_request_id' => $pallet->id,
            'nama_project'      => 'Project Gudang A',
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('pesanan', [
        'pallet_request_id' => $pallet->id,
        'nama_project'      => 'Project Gudang A',
        'status'            => 'pending',
    ]);
});

test('admin gagal membuat pesanan jika nama project sudah dipakai', function () {
    $admin  = User::factory()->admin()->create();
    $klien  = User::factory()->client()->create();
    $pallet = buatPalletRequest($klien);

    // Buat pesanan pertama
    Pesanan::create([
        'client_id'         => $klien->id,
        'pallet_request_id' => $pallet->id,
        'nama_project'      => 'Project Duplikat',
        'qty'               => 100,
        'status'            => 'pending',
    ]);

    // Buat pallet request kedua
    $pallet2 = buatPalletRequest($klien);

    // Coba buat pesanan dengan nama project yang sama
    $response = $this->actingAs($admin)
        ->post('/admin/pesanan', [
            'pallet_request_id' => $pallet2->id,
            'nama_project'      => 'Project Duplikat',
        ]);

    $response->assertSessionHasErrors('nama_project');
});

test('admin gagal membuat pesanan jika pallet request sudah punya pesanan', function () {
    $admin  = User::factory()->admin()->create();
    $klien  = User::factory()->client()->create();
    $pallet = buatPalletRequest($klien);

    // Buat pesanan pertama dari pallet yang sama
    buatPesanan($klien, $pallet);

    // Coba buat pesanan kedua dari pallet yang sama
    $response = $this->actingAs($admin)
        ->post('/admin/pesanan', [
            'pallet_request_id' => $pallet->id,
            'nama_project'      => 'Project Baru',
        ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');
});

test('klien tidak bisa membuat pesanan', function () {
    $klien  = User::factory()->client()->create();
    $pallet = buatPalletRequest($klien);

    $this->actingAs($klien)
        ->post('/admin/pesanan', [
            'pallet_request_id' => $pallet->id,
            'nama_project'      => 'Project Test',
        ])
        ->assertStatus(403);
});

// ═══════════════════════════════════════════
// CLIENT DEAL — klien konfirmasi pesanan
// ═══════════════════════════════════════════

test('klien dapat konfirmasi deal pesanan', function () {
    $klien  = User::factory()->client()->create();
    $pallet = buatPalletRequest($klien);
    $pesanan = buatPesanan($klien, $pallet);

    $response = $this->actingAs($klien)
        ->post("/client/pesanan/{$pesanan->id}/deal");

    $response->assertRedirect();
    $this->assertDatabaseHas('pesanan', [
        'id'     => $pesanan->id,
        'status' => 'deal',
    ]);
});

test('klien tidak bisa deal pesanan milik klien lain', function () {
    $klien1  = User::factory()->client()->create();
    $klien2  = User::factory()->client()->create();
    $pallet  = buatPalletRequest($klien1);
    $pesanan = buatPesanan($klien1, $pallet);

    // klien2 coba deal pesanan milik klien1
    $this->actingAs($klien2)
        ->post("/client/pesanan/{$pesanan->id}/deal")
        ->assertStatus(404);
});

// ═══════════════════════════════════════════
// CLIENT CANCEL — klien batalkan pesanan
// ═══════════════════════════════════════════

test('klien dapat membatalkan pesanan', function () {
    $klien   = User::factory()->client()->create();
    $pallet  = buatPalletRequest($klien);
    $pesanan = buatPesanan($klien, $pallet);

    $response = $this->actingAs($klien)
        ->patch("/client/pesanan/{$pesanan->id}/cancel");

    $response->assertRedirect();
    $this->assertDatabaseHas('pesanan', [
        'id'     => $pesanan->id,
        'status' => 'batal',
    ]);
});

test('klien tidak bisa membatalkan pesanan milik klien lain', function () {
    $klien1  = User::factory()->client()->create();
    $klien2  = User::factory()->client()->create();
    $pallet  = buatPalletRequest($klien1);
    $pesanan = buatPesanan($klien1, $pallet);

    $this->actingAs($klien2)
        ->patch("/client/pesanan/{$pesanan->id}/cancel")
        ->assertStatus(404);
});

test('guest tidak bisa membatalkan pesanan', function () {
    $klien   = User::factory()->client()->create();
    $pallet  = buatPalletRequest($klien);
    $pesanan = buatPesanan($klien, $pallet);

    $this->patch("/client/pesanan/{$pesanan->id}/cancel")
        ->assertRedirect('/login');
});

// ═══════════════════════════════════════════
// ADMIN UPDATE STATUS — admin update status pesanan
// ═══════════════════════════════════════════

test('admin dapat mengubah status pesanan', function () {
    $admin   = User::factory()->admin()->create();
    $klien   = User::factory()->client()->create();
    $pallet  = buatPalletRequest($klien);
    $pesanan = buatPesanan($klien, $pallet);

    $response = $this->actingAs($admin)
        ->post("/admin/pesanan/{$pesanan->id}/deal");

    $response->assertRedirect();
    $this->assertDatabaseHas('pesanan', [
        'id'     => $pesanan->id,
        'status' => 'deal',
    ]);
});

test('klien tidak bisa mengubah status pesanan via admin route', function () {
    $klien   = User::factory()->client()->create();
    $pallet  = buatPalletRequest($klien);
    $pesanan = buatPesanan($klien, $pallet);

    $this->actingAs($klien)
        ->post("/admin/pesanan/{$pesanan->id}/deal")
        ->assertStatus(403);
});
