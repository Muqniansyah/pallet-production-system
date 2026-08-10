<?php

use App\Models\User;
use App\Models\ProdukKayu;
use App\Models\StokKayu;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// Helper untuk buat produk kayu
function buatProduk($admin)
{
    $produk = ProdukKayu::create([
        'admin_id'    => $admin->id,
        'nama_produk' => 'Kayu Test ' . uniqid(),
        'gambar'      => null,
        'satuan'      => 'PCS',
        'keterangan'  => 'Keterangan test',
    ]);

    StokKayu::create([
        'produk_kayu_id' => $produk->id,
        'admin_id'       => $admin->id,
        'stok'           => 100,
    ]);

    return $produk;
}

// ═══════════════════════════════════════════
// HALAMAN — akses halaman stok
// ═══════════════════════════════════════════

test('admin dapat mengakses halaman stok', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin/stok')
        ->assertStatus(200);
});

test('guest tidak bisa mengakses halaman stok', function () {
    $this->get('/admin/stok')
        ->assertRedirect('/login');
});

test('klien tidak bisa mengakses halaman stok', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/admin/stok')
        ->assertStatus(403);
});

// ═══════════════════════════════════════════
// STORE — admin tambah produk baru
// ═══════════════════════════════════════════

test('admin dapat menambahkan produk kayu baru', function () {
    Storage::fake('public');

    $admin  = User::factory()->admin()->create();
    $gambar = UploadedFile::fake()->image('kayu.jpg');

    $response = $this->actingAs($admin)
        ->post('/admin/stok', [
            'nama_produk' => 'Kayu Jati Premium',
            'stok'        => 50,
            'gambar'      => $gambar,
            'keterangan'  => 'Kayu jati berkualitas tinggi',
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('produk_kayu', [
        'nama_produk' => 'Kayu Jati Premium',
    ]);
});

test('tambah produk gagal jika nama produk sudah ada', function () {
    Storage::fake('public');

    $admin  = User::factory()->admin()->create();
    $gambar = UploadedFile::fake()->image('kayu.jpg');

    // Buat produk pertama
    buatProduk($admin);
    $namaProduk = ProdukKayu::first()->nama_produk;

    // Coba tambah produk dengan nama yang sama
    $response = $this->actingAs($admin)
        ->post('/admin/stok', [
            'nama_produk' => $namaProduk,
            'stok'        => 50,
            'gambar'      => $gambar,
            'keterangan'  => 'Keterangan',
        ]);

    $response->assertSessionHasErrors('nama_produk');
});

test('tambah produk gagal jika nama produk tidak diisi', function () {
    Storage::fake('public');

    $admin  = User::factory()->admin()->create();
    $gambar = UploadedFile::fake()->image('kayu.jpg');

    $response = $this->actingAs($admin)
        ->post('/admin/stok', [
            'nama_produk' => '',
            'stok'        => 50,
            'gambar'      => $gambar,
            'keterangan'  => 'Keterangan',
        ]);

    $response->assertSessionHasErrors('nama_produk');
});

test('tambah produk gagal jika gambar tidak diunggah', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)
        ->post('/admin/stok', [
            'nama_produk' => 'Kayu Baru',
            'stok'        => 50,
            'keterangan'  => 'Keterangan',
        ]);

    $response->assertSessionHasErrors('gambar');
});

test('tambah produk gagal jika stok negatif', function () {
    Storage::fake('public');

    $admin  = User::factory()->admin()->create();
    $gambar = UploadedFile::fake()->image('kayu.jpg');

    $response = $this->actingAs($admin)
        ->post('/admin/stok', [
            'nama_produk' => 'Kayu Baru',
            'stok'        => -1,
            'gambar'      => $gambar,
            'keterangan'  => 'Keterangan',
        ]);

    $response->assertSessionHasErrors('stok');
});

// ═══════════════════════════════════════════
// UPDATE — admin update produk
// ═══════════════════════════════════════════

test('admin dapat mengupdate produk kayu', function () {
    Storage::fake('public');

    $admin  = User::factory()->admin()->create();
    $produk = buatProduk($admin);

    $response = $this->actingAs($admin)
        ->put("/admin/stok/{$produk->id}", [
            'nama_produk' => 'Kayu Jati Updated',
            'stok'        => 200,
            'keterangan'  => 'Keterangan updated',
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('produk_kayu', [
        'id'          => $produk->id,
        'nama_produk' => 'Kayu Jati Updated',
    ]);
    $this->assertDatabaseHas('stok_kayu', [
        'produk_kayu_id' => $produk->id,
        'stok'           => 200,
    ]);
});

// ═══════════════════════════════════════════
// DESTROY — admin hapus produk
// ═══════════════════════════════════════════

test('admin dapat menghapus produk kayu', function () {
    $admin  = User::factory()->admin()->create();
    $produk = buatProduk($admin);

    $response = $this->actingAs($admin)
        ->delete("/admin/stok/{$produk->id}");

    $response->assertRedirect();
    $this->assertDatabaseMissing('produk_kayu', [
        'id' => $produk->id,
    ]);
});

test('klien tidak bisa menghapus produk kayu', function () {
    $admin  = User::factory()->admin()->create();
    $klien  = User::factory()->client()->create();
    $produk = buatProduk($admin);

    $this->actingAs($klien)
        ->delete("/admin/stok/{$produk->id}")
        ->assertStatus(403);
});

// ═══════════════════════════════════════════
// TAMBAH STOK — admin tambah stok produk
// ═══════════════════════════════════════════

test('admin dapat menambah stok produk', function () {
    $admin  = User::factory()->admin()->create();
    $produk = buatProduk($admin);
    $stokAwal = $produk->stok->stok;

    $response = $this->actingAs($admin)
        ->post('/admin/stok/tambah', [
            'produk_kayu_id' => $produk->id,
            'jumlah'         => 50,
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('stok_kayu', [
        'produk_kayu_id' => $produk->id,
        'stok'           => $stokAwal + 50,
    ]);
});

test('tambah stok gagal jika jumlah kurang dari 1', function () {
    $admin  = User::factory()->admin()->create();
    $produk = buatProduk($admin);

    $response = $this->actingAs($admin)
        ->post('/admin/stok/tambah', [
            'produk_kayu_id' => $produk->id,
            'jumlah'         => 0,
        ]);

    $response->assertSessionHasErrors('jumlah');
});

test('tambah stok gagal jika produk tidak dipilih', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)
        ->post('/admin/stok/tambah', [
            'produk_kayu_id' => '',
            'jumlah'         => 50,
        ]);

    $response->assertSessionHasErrors('produk_kayu_id');
});

test('klien tidak bisa menambah stok', function () {
    $admin  = User::factory()->admin()->create();
    $klien  = User::factory()->client()->create();
    $produk = buatProduk($admin);

    $this->actingAs($klien)
        ->post('/admin/stok/tambah', [
            'produk_kayu_id' => $produk->id,
            'jumlah'         => 50,
        ])
        ->assertStatus(403);
});
