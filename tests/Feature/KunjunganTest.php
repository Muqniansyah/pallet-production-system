<?php

use App\Models\User;
use App\Models\Kunjungan;

// Helper untuk buat kunjungan
function buatKunjungan($klien, $status = 'pending')
{
    return Kunjungan::create([
        'client_id'         => $klien->id,
        'judul'             => 'Kunjungan Test',
        'tanggal_kunjungan' => now()->addDays(3)->format('Y-m-d H:i:s'),
        'status'            => $status,
    ]);
}

// ═══════════════════════════════════════════
// HALAMAN — akses halaman kunjungan
// ═══════════════════════════════════════════

test('klien dapat mengakses halaman kunjungan', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/client/kunjungan')
        ->assertStatus(200);
});

test('guest tidak bisa mengakses halaman kunjungan', function () {
    $this->get('/client/kunjungan')
        ->assertRedirect('/login');
});

// ═══════════════════════════════════════════
// STORE — klien mengajukan kunjungan
// ═══════════════════════════════════════════

test('klien dapat mengajukan kunjungan dengan data valid', function () {
    $klien = User::factory()->client()->create();

    $response = $this->actingAs($klien)->post('/client/kunjungan', [
        'judul'             => 'Kunjungan Pabrik',
        'tanggal_kunjungan' => now()->addDays(3)->format('Y-m-d H:i:s'),
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('kunjungan', [
        'client_id' => $klien->id,
        'judul'     => 'Kunjungan Pabrik',
        'status'    => 'pending',
    ]);
});

test('pengajuan kunjungan gagal jika judul tidak diisi', function () {
    $klien = User::factory()->client()->create();

    $response = $this->actingAs($klien)->post('/client/kunjungan', [
        'judul'             => '',
        'tanggal_kunjungan' => now()->addDays(3)->format('Y-m-d H:i:s'),
    ]);

    $response->assertSessionHasErrors('judul');
});

test('pengajuan kunjungan gagal jika tanggal sudah lewat', function () {
    $klien = User::factory()->client()->create();

    $response = $this->actingAs($klien)->post('/client/kunjungan', [
        'judul'             => 'Kunjungan Pabrik',
        'tanggal_kunjungan' => now()->subDays(1)->format('Y-m-d H:i:s'),
    ]);

    $response->assertSessionHasErrors('tanggal_kunjungan');
});

test('pengajuan kunjungan gagal jika tanggal tidak diisi', function () {
    $klien = User::factory()->client()->create();

    $response = $this->actingAs($klien)->post('/client/kunjungan', [
        'judul'             => 'Kunjungan Pabrik',
        'tanggal_kunjungan' => '',
    ]);

    $response->assertSessionHasErrors('tanggal_kunjungan');
});

test('klien tidak bisa mengajukan lebih dari 3 kunjungan per hari', function () {
    $klien = User::factory()->client()->create();

    // Buat 3 kunjungan hari ini
    for ($i = 0; $i < 3; $i++) {
        Kunjungan::create([
            'client_id'         => $klien->id,
            'judul'             => 'Kunjungan ' . $i,
            'tanggal_kunjungan' => now()->addDays(3)->format('Y-m-d H:i:s'),
            'status'            => 'pending',
            'created_at'        => now(),
        ]);
    }

    // Coba ajukan kunjungan ke-4
    $response = $this->actingAs($klien)->post('/client/kunjungan', [
        'judul'             => 'Kunjungan Ke-4',
        'tanggal_kunjungan' => now()->addDays(4)->format('Y-m-d H:i:s'),
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');
});

test('guest tidak bisa mengajukan kunjungan', function () {
    $this->post('/client/kunjungan', [
        'judul'             => 'Kunjungan Pabrik',
        'tanggal_kunjungan' => now()->addDays(3)->format('Y-m-d H:i:s'),
    ])->assertRedirect('/login');
});

// ═══════════════════════════════════════════
// ADMIN APPROVE — admin setujui kunjungan
// ═══════════════════════════════════════════

test('admin dapat menyetujui kunjungan', function () {
    $admin     = User::factory()->admin()->create();
    $klien     = User::factory()->client()->create();
    $kunjungan = buatKunjungan($klien);

    $response = $this->actingAs($admin)
        ->post("/admin/kunjungan/{$kunjungan->id}/approve");

    $response->assertRedirect();
    $this->assertDatabaseHas('kunjungan', [
        'id'     => $kunjungan->id,
        'status' => 'disetujui',
    ]);
});

test('admin dapat menolak kunjungan dengan keterangan', function () {
    $admin     = User::factory()->admin()->create();
    $klien     = User::factory()->client()->create();
    $kunjungan = buatKunjungan($klien);

    $response = $this->actingAs($admin)
        ->post("/admin/kunjungan/{$kunjungan->id}/reject", [
            'keterangan' => 'Jadwal pabrik sedang penuh',
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('kunjungan', [
        'id'         => $kunjungan->id,
        'status'     => 'ditolak',
        'keterangan' => 'Jadwal pabrik sedang penuh',
    ]);
});

test('admin gagal menolak kunjungan tanpa keterangan', function () {
    $admin     = User::factory()->admin()->create();
    $klien     = User::factory()->client()->create();
    $kunjungan = buatKunjungan($klien);

    $response = $this->actingAs($admin)
        ->post("/admin/kunjungan/{$kunjungan->id}/reject", [
            'keterangan' => '',
        ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');
    $this->assertDatabaseHas('kunjungan', [
        'id'     => $kunjungan->id,
        'status' => 'pending', // tidak berubah
    ]);
});

test('admin dapat menghapus kunjungan', function () {
    $admin     = User::factory()->admin()->create();
    $klien     = User::factory()->client()->create();
    $kunjungan = buatKunjungan($klien);

    $response = $this->actingAs($admin)
        ->delete("/admin/kunjungan/{$kunjungan->id}");

    $response->assertRedirect();
    $this->assertDatabaseMissing('kunjungan', [
        'id' => $kunjungan->id,
    ]);
});

test('klien tidak bisa approve kunjungan', function () {
    $klien     = User::factory()->client()->create();
    $kunjungan = buatKunjungan($klien);

    $this->actingAs($klien)
        ->post("/admin/kunjungan/{$kunjungan->id}/approve")
        ->assertStatus(403);
});

test('klien tidak bisa menghapus kunjungan via admin route', function () {
    $klien     = User::factory()->client()->create();
    $kunjungan = buatKunjungan($klien);

    $this->actingAs($klien)
        ->delete("/admin/kunjungan/{$kunjungan->id}")
        ->assertStatus(403);
});
