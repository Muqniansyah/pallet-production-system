<?php

use App\Models\User;
use App\Models\Hpp;
use App\Models\Pesanan;
use App\Models\PalletRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// Helper untuk buat pallet request
function buatPalletRequestHpp($klien)
{
    return PalletRequest::create([
        'client_id'    => $klien->id,
        'jenis_palet'  => 'Palet Kayu Jati',
        'qty'          => 100,
        'alamat_kirim' => 'Jl. Contoh No. 1',
        'catatan'      => 'Test',
        'status'       => 'disetujui',
    ]);
}

// Helper untuk buat pesanan
function buatPesananHpp($klien, $pallet, $status = 'deal')
{
    return Pesanan::create([
        'client_id'         => $klien->id,
        'pallet_request_id' => $pallet->id,
        'nama_project'      => 'Project HPP ' . uniqid(),
        'qty'               => $pallet->qty,
        'status'            => $status,
    ]);
}

// ═══════════════════════════════════════════
// HALAMAN — akses halaman HPP
// ═══════════════════════════════════════════

test('admin dapat mengakses halaman hpp', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin/hpp')
        ->assertStatus(200);
});

test('guest tidak bisa mengakses halaman hpp', function () {
    $this->get('/admin/hpp')
        ->assertRedirect('/login');
});

test('klien tidak bisa mengakses halaman hpp', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/admin/hpp')
        ->assertStatus(403);
});

// ═══════════════════════════════════════════
// STORE — admin upload HPP
// ═══════════════════════════════════════════

test('admin dapat mengupload hpp untuk pesanan yang sudah deal', function () {
    Storage::fake('public');

    $admin   = User::factory()->admin()->create();
    $klien   = User::factory()->client()->create();
    $pallet  = buatPalletRequestHpp($klien);
    $pesanan = buatPesananHpp($klien, $pallet, 'deal');
    $file    = UploadedFile::fake()->create('hpp.pdf', 1024, 'application/pdf');

    $response = $this->actingAs($admin)
        ->post('/admin/hpp/upload', [
            'pesanan_id' => $pesanan->id,
            'file_hpp'   => $file,
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('hpps', [
        'pesanan_id' => $pesanan->id,
    ]);
});

test('upload hpp gagal jika pesanan tidak dipilih', function () {
    Storage::fake('public');

    $admin = User::factory()->admin()->create();
    $file  = UploadedFile::fake()->create('hpp.pdf', 1024, 'application/pdf');

    $response = $this->actingAs($admin)
        ->post('/admin/hpp/upload', [
            'pesanan_id' => '',
            'file_hpp'   => $file,
        ]);

    $response->assertSessionHasErrors('pesanan_id');
});

test('upload hpp gagal jika file tidak diunggah', function () {
    $admin   = User::factory()->admin()->create();
    $klien   = User::factory()->client()->create();
    $pallet  = buatPalletRequestHpp($klien);
    $pesanan = buatPesananHpp($klien, $pallet, 'deal');

    $response = $this->actingAs($admin)
        ->post('/admin/hpp/upload', [
            'pesanan_id' => $pesanan->id,
            // file_hpp tidak dikirim
        ]);

    $response->assertSessionHasErrors('file_hpp');
});

test('upload hpp gagal jika format file tidak valid', function () {
    Storage::fake('public');

    $admin   = User::factory()->admin()->create();
    $klien   = User::factory()->client()->create();
    $pallet  = buatPalletRequestHpp($klien);
    $pesanan = buatPesananHpp($klien, $pallet, 'deal');
    $file    = UploadedFile::fake()->create('hpp.txt', 100, 'text/plain'); // format salah

    $response = $this->actingAs($admin)
        ->post('/admin/hpp/upload', [
            'pesanan_id' => $pesanan->id,
            'file_hpp'   => $file,
        ]);

    $response->assertSessionHasErrors('file_hpp');
});

test('upload hpp gagal jika pesanan belum berstatus deal', function () {
    Storage::fake('public');

    $admin   = User::factory()->admin()->create();
    $klien   = User::factory()->client()->create();
    $pallet  = buatPalletRequestHpp($klien);
    $pesanan = buatPesananHpp($klien, $pallet, 'pending'); // belum deal
    $file    = UploadedFile::fake()->create('hpp.pdf', 1024, 'application/pdf');

    $response = $this->actingAs($admin)
        ->post('/admin/hpp/upload', [
            'pesanan_id' => $pesanan->id,
            'file_hpp'   => $file,
        ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');
    $this->assertDatabaseMissing('hpps', [
        'pesanan_id' => $pesanan->id,
    ]);
});

test('upload hpp gagal jika hpp sudah pernah diupload', function () {
    Storage::fake('public');

    $admin   = User::factory()->admin()->create();
    $klien   = User::factory()->client()->create();
    $pallet  = buatPalletRequestHpp($klien);
    $pesanan = buatPesananHpp($klien, $pallet, 'deal');

    // Upload HPP pertama
    Hpp::create([
        'pesanan_id' => $pesanan->id,
        'file_hpp'   => 'hpp_files/test.pdf',
    ]);

    // Coba upload HPP kedua untuk pesanan yang sama
    $file = UploadedFile::fake()->create('hpp2.pdf', 1024, 'application/pdf');

    $response = $this->actingAs($admin)
        ->post('/admin/hpp/upload', [
            'pesanan_id' => $pesanan->id,
            'file_hpp'   => $file,
        ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');

    // Pastikan hanya ada 1 HPP untuk pesanan ini
    $this->assertEquals(1, Hpp::where('pesanan_id', $pesanan->id)->count());
});

test('klien tidak bisa upload hpp', function () {
    Storage::fake('public');

    $klien   = User::factory()->client()->create();
    $pallet  = buatPalletRequestHpp($klien);
    $pesanan = buatPesananHpp($klien, $pallet, 'deal');
    $file    = UploadedFile::fake()->create('hpp.pdf', 1024, 'application/pdf');

    $this->actingAs($klien)
        ->post('/admin/hpp/upload', [
            'pesanan_id' => $pesanan->id,
            'file_hpp'   => $file,
        ])
        ->assertStatus(403);
});

test('guest tidak bisa upload hpp', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('hpp.pdf', 1024, 'application/pdf');

    $this->post('/admin/hpp/upload', [
        'pesanan_id' => 1,
        'file_hpp'   => $file,
    ])->assertRedirect('/login');
});
