<?php

use App\Models\User;
use App\Models\PalletRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// ═══════════════════════════════════════════
// HALAMAN — akses halaman pallet request
// ═══════════════════════════════════════════

test('klien dapat mengakses halaman pallet request', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/client/pallet-request')
        ->assertStatus(200);
});

// ═══════════════════════════════════════════
// STORE — klien mengajukan pallet request
// ═══════════════════════════════════════════

test('klien dapat mengajukan pallet request dengan data valid', function () {
    Storage::fake('public');

    $klien = User::factory()->client()->create();
    $file  = UploadedFile::fake()->create('desain.pdf', 1024, 'application/pdf');

    $response = $this->actingAs($klien)->post('/client/pallet-request', [
        'jenis_palet'  => 'Palet Kayu Jati',
        'qty'          => 100,
        'alamat_kirim' => 'Jl. Contoh No. 1 Jakarta',
        'catatan'      => 'Kayu harus kering',
        'file_desain'  => $file,
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('pallet_requests', [
        'client_id'   => $klien->id,
        'jenis_palet' => 'Palet Kayu Jati',
        'qty'         => 100,
        'status'      => 'pending',
    ]);
});

test('pengajuan gagal jika qty kurang dari 50', function () {
    Storage::fake('public');

    $klien = User::factory()->client()->create();
    $file  = UploadedFile::fake()->create('desain.pdf', 1024, 'application/pdf');

    $response = $this->actingAs($klien)->post('/client/pallet-request', [
        'jenis_palet'  => 'Palet Kayu Jati',
        'qty'          => 10, // kurang dari minimum 50
        'alamat_kirim' => 'Jl. Contoh No. 1 Jakarta',
        'catatan'      => 'Kayu harus kering',
        'file_desain'  => $file,
    ]);

    $response->assertSessionHasErrors('qty');
    $this->assertDatabaseMissing('pallet_requests', [
        'client_id' => $klien->id,
    ]);
});

test('pengajuan gagal jika jenis palet tidak diisi', function () {
    Storage::fake('public');

    $klien = User::factory()->client()->create();
    $file  = UploadedFile::fake()->create('desain.pdf', 1024, 'application/pdf');

    $response = $this->actingAs($klien)->post('/client/pallet-request', [
        'jenis_palet'  => '',
        'qty'          => 100,
        'alamat_kirim' => 'Jl. Contoh No. 1 Jakarta',
        'catatan'      => 'Kayu harus kering',
        'file_desain'  => $file,
    ]);

    $response->assertSessionHasErrors('jenis_palet');
});

test('pengajuan gagal jika file desain tidak diunggah', function () {
    $klien = User::factory()->client()->create();

    $response = $this->actingAs($klien)->post('/client/pallet-request', [
        'jenis_palet'  => 'Palet Kayu Jati',
        'qty'          => 100,
        'alamat_kirim' => 'Jl. Contoh No. 1 Jakarta',
        'catatan'      => 'Kayu harus kering',
        // file_desain tidak dikirim
    ]);

    $response->assertSessionHasErrors('file_desain');
});

test('pengajuan gagal jika alamat kirim tidak diisi', function () {
    Storage::fake('public');

    $klien = User::factory()->client()->create();
    $file  = UploadedFile::fake()->create('desain.pdf', 1024, 'application/pdf');

    $response = $this->actingAs($klien)->post('/client/pallet-request', [
        'jenis_palet'  => 'Palet Kayu Jati',
        'qty'          => 100,
        'alamat_kirim' => '',
        'catatan'      => 'Kayu harus kering',
        'file_desain'  => $file,
    ]);

    $response->assertSessionHasErrors('alamat_kirim');
});

test('guest tidak bisa mengajukan pallet request', function () {
    $response = $this->post('/client/pallet-request', [
        'jenis_palet'  => 'Palet Kayu Jati',
        'qty'          => 100,
        'alamat_kirim' => 'Jl. Contoh No. 1',
        'catatan'      => 'Test',
    ]);

    $response->assertRedirect('/login');
});

// ═══════════════════════════════════════════
// ADMIN — approve & reject pallet request
// ═══════════════════════════════════════════

test('admin dapat menyetujui pallet request', function () {
    $admin = User::factory()->admin()->create();
    $klien = User::factory()->client()->create();

    $pallet = PalletRequest::create([
        'client_id'   => $klien->id,
        'jenis_palet' => 'Palet Kayu Jati',
        'qty'         => 100,
        'alamat_kirim' => 'Jl. Contoh No. 1',
        'catatan'     => 'Test',
        'status'      => 'pending',
    ]);

    $response = $this->actingAs($admin)
        ->post("/admin/pallet-request/{$pallet->id}/approve");

    $response->assertRedirect();
    $this->assertDatabaseHas('pallet_requests', [
        'id'     => $pallet->id,
        'status' => 'disetujui',
    ]);
});

test('admin dapat menolak pallet request dengan keterangan', function () {
    $admin = User::factory()->admin()->create();
    $klien = User::factory()->client()->create();

    $pallet = PalletRequest::create([
        'client_id'    => $klien->id,
        'jenis_palet'  => 'Palet Kayu Jati',
        'qty'          => 100,
        'alamat_kirim' => 'Jl. Contoh No. 1',
        'catatan'      => 'Test',
        'status'       => 'pending',
    ]);

    $response = $this->actingAs($admin)
        ->post("/admin/pallet-request/{$pallet->id}/reject", [
            'keterangan' => 'Stok kayu sedang habis',
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('pallet_requests', [
        'id'         => $pallet->id,
        'status'     => 'ditolak',
        'keterangan' => 'Stok kayu sedang habis',
    ]);
});

test('admin gagal menolak pallet request tanpa keterangan', function () {
    $admin = User::factory()->admin()->create();
    $klien = User::factory()->client()->create();

    $pallet = PalletRequest::create([
        'client_id'    => $klien->id,
        'jenis_palet'  => 'Palet Kayu Jati',
        'qty'          => 100,
        'alamat_kirim' => 'Jl. Contoh No. 1',
        'catatan'      => 'Test',
        'status'       => 'pending',
    ]);

    $response = $this->actingAs($admin)
        ->post("/admin/pallet-request/{$pallet->id}/reject", [
            'keterangan' => '', // kosong
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('pallet_requests', [
        'id'     => $pallet->id,
        'status' => 'pending', // status tidak berubah
    ]);
});

test('admin dapat menghapus pallet request', function () {
    $admin = User::factory()->admin()->create();
    $klien = User::factory()->client()->create();

    $pallet = PalletRequest::create([
        'client_id'    => $klien->id,
        'jenis_palet'  => 'Palet Kayu Jati',
        'qty'          => 100,
        'alamat_kirim' => 'Jl. Contoh No. 1',
        'catatan'      => 'Test',
        'status'       => 'pending',
    ]);

    $response = $this->actingAs($admin)
        ->delete("/admin/pallet-request/{$pallet->id}");

    $response->assertRedirect();
    $this->assertDatabaseMissing('pallet_requests', [
        'id' => $pallet->id,
    ]);
});

test('klien tidak bisa approve pallet request', function () {
    $klien = User::factory()->client()->create();

    $pallet = PalletRequest::create([
        'client_id'    => $klien->id,
        'jenis_palet'  => 'Palet Kayu Jati',
        'qty'          => 100,
        'alamat_kirim' => 'Jl. Contoh No. 1',
        'catatan'      => 'Test',
        'status'       => 'pending',
    ]);

    $this->actingAs($klien)
        ->post("/admin/pallet-request/{$pallet->id}/approve")
        ->assertStatus(403);
});
