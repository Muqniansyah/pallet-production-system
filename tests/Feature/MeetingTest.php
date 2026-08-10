<?php

use App\Models\User;
use App\Models\MeetingRequest;
use App\Services\ZoomService;

// Helper untuk buat meeting request
function buatMeeting($klien, $status = 'pending')
{
    return MeetingRequest::create([
        'client_id'  => $klien->id,
        'judul'      => 'Meeting Test',
        'deskripsi'  => 'Deskripsi meeting test',
        'start_time' => now()->addDays(2)->format('Y-m-d H:i:s'),
        'durasi'     => 30,
        'status'     => $status,
    ]);
}

// ═══════════════════════════════════════════
// HALAMAN — akses halaman meeting
// ═══════════════════════════════════════════

test('klien dapat mengakses halaman meeting', function () {
    $klien = User::factory()->client()->create();

    $this->actingAs($klien)
        ->get('/client/meeting-request')
        ->assertStatus(200);
});

test('guest tidak bisa mengakses halaman meeting', function () {
    $this->get('/client/meeting-request')
        ->assertRedirect('/login');
});

// ═══════════════════════════════════════════
// STORE — klien mengajukan meeting
// ═══════════════════════════════════════════

test('klien dapat mengajukan meeting dengan data valid', function () {
    $klien = User::factory()->client()->create();

    $response = $this->actingAs($klien)->post('/client/meeting-request', [
        'judul'      => 'Diskusi Pesanan Palet',
        'deskripsi'  => 'Membahas spesifikasi palet kayu jati',
        'start_time' => now()->addDays(2)->format('Y-m-d H:i:s'),
        'durasi'     => 30,
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('meeting_requests', [
        'client_id' => $klien->id,
        'judul'     => 'Diskusi Pesanan Palet',
        'status'    => 'pending',
    ]);
});

test('pengajuan meeting gagal jika judul tidak diisi', function () {
    $klien = User::factory()->client()->create();

    $response = $this->actingAs($klien)->post('/client/meeting-request', [
        'judul'      => '',
        'deskripsi'  => 'Deskripsi meeting',
        'start_time' => now()->addDays(2)->format('Y-m-d H:i:s'),
        'durasi'     => 30,
    ]);

    $response->assertSessionHasErrors('judul');
});

test('pengajuan meeting gagal jika deskripsi tidak diisi', function () {
    $klien = User::factory()->client()->create();

    $response = $this->actingAs($klien)->post('/client/meeting-request', [
        'judul'      => 'Diskusi Palet',
        'deskripsi'  => '',
        'start_time' => now()->addDays(2)->format('Y-m-d H:i:s'),
        'durasi'     => 30,
    ]);

    $response->assertSessionHasErrors('deskripsi');
});

test('pengajuan meeting gagal jika waktu sudah lewat', function () {
    $klien = User::factory()->client()->create();

    $response = $this->actingAs($klien)->post('/client/meeting-request', [
        'judul'      => 'Diskusi Palet',
        'deskripsi'  => 'Deskripsi meeting',
        'start_time' => now()->subDays(1)->format('Y-m-d H:i:s'), // kemarin
        'durasi'     => 30,
    ]);

    $response->assertSessionHasErrors('start_time');
});

test('pengajuan meeting gagal jika durasi tidak valid', function () {
    $klien = User::factory()->client()->create();

    $response = $this->actingAs($klien)->post('/client/meeting-request', [
        'judul'      => 'Diskusi Palet',
        'deskripsi'  => 'Deskripsi meeting',
        'start_time' => now()->addDays(2)->format('Y-m-d H:i:s'),
        'durasi'     => 60, // bukan 15, 30, atau 40
    ]);

    $response->assertSessionHasErrors('durasi');
});

test('klien tidak bisa mengajukan lebih dari 3 meeting per hari', function () {
    $klien = User::factory()->client()->create();

    // Buat 3 meeting hari ini
    MeetingRequest::factory()->count(3)->create([
        'client_id'  => $klien->id,
        'judul'      => 'Meeting Test',
        'deskripsi'  => 'Deskripsi',
        'start_time' => now()->addDays(2)->format('Y-m-d H:i:s'),
        'durasi'     => 30,
        'status'     => 'pending',
        'created_at' => now(),
    ]);

    // Coba ajukan meeting ke-4
    $response = $this->actingAs($klien)->post('/client/meeting-request', [
        'judul'      => 'Meeting Ke-4',
        'deskripsi'  => 'Deskripsi meeting ke-4',
        'start_time' => now()->addDays(3)->format('Y-m-d H:i:s'),
        'durasi'     => 30,
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');
});

test('guest tidak bisa mengajukan meeting', function () {
    $this->post('/client/meeting-request', [
        'judul'      => 'Diskusi Palet',
        'deskripsi'  => 'Deskripsi',
        'start_time' => now()->addDays(2)->format('Y-m-d H:i:s'),
        'durasi'     => 30,
    ])->assertRedirect('/login');
});

// ═══════════════════════════════════════════
// ADMIN APPROVE — admin setujui meeting
// ═══════════════════════════════════════════

test('admin dapat menyetujui meeting', function () {
    $admin   = User::factory()->admin()->create();
    $klien   = User::factory()->client()->create();
    $meeting = buatMeeting($klien);

    // Mock ZoomService agar tidak hit API Zoom sungguhan
    $this->mock(ZoomService::class, function ($mock) {
        $mock->shouldReceive('createMeeting')
            ->once()
            ->andReturn([
                'id'        => 'zoom123',
                'join_url'  => 'https://zoom.us/j/123',
                'start_url' => 'https://zoom.us/s/123',
            ]);
    });

    $response = $this->actingAs($admin)
        ->post("/admin/meeting/{$meeting->id}/approve");

    $response->assertRedirect();
    $this->assertDatabaseHas('meeting_requests', [
        'id'             => $meeting->id,
        'status'         => 'disetujui',
        'zoom_meeting_id' => 'zoom123',
    ]);
});

test('admin dapat menolak meeting dengan keterangan', function () {
    $admin   = User::factory()->admin()->create();
    $klien   = User::factory()->client()->create();
    $meeting = buatMeeting($klien);

    $response = $this->actingAs($admin)
        ->post("/admin/meeting/{$meeting->id}/reject", [
            'keterangan' => 'Jadwal bentrok dengan meeting lain',
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('meeting_requests', [
        'id'         => $meeting->id,
        'status'     => 'ditolak',
        'keterangan' => 'Jadwal bentrok dengan meeting lain',
    ]);
});

test('admin gagal menolak meeting tanpa keterangan', function () {
    $admin   = User::factory()->admin()->create();
    $klien   = User::factory()->client()->create();
    $meeting = buatMeeting($klien);

    $response = $this->actingAs($admin)
        ->post("/admin/meeting/{$meeting->id}/reject", [
            'keterangan' => '',
        ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');
    $this->assertDatabaseHas('meeting_requests', [
        'id'     => $meeting->id,
        'status' => 'pending', // tidak berubah
    ]);
});

test('admin dapat menghapus meeting', function () {
    $admin   = User::factory()->admin()->create();
    $klien   = User::factory()->client()->create();
    $meeting = buatMeeting($klien);

    $response = $this->actingAs($admin)
        ->delete("/admin/meeting/{$meeting->id}");

    $response->assertRedirect();
    $this->assertDatabaseMissing('meeting_requests', [
        'id' => $meeting->id,
    ]);
});

test('klien tidak bisa approve meeting', function () {
    $klien   = User::factory()->client()->create();
    $meeting = buatMeeting($klien);

    $this->actingAs($klien)
        ->post("/admin/meeting/{$meeting->id}/approve")
        ->assertStatus(403);
});

test('klien tidak bisa menghapus meeting via admin route', function () {
    $klien   = User::factory()->client()->create();
    $meeting = buatMeeting($klien);

    $this->actingAs($klien)
        ->delete("/admin/meeting/{$meeting->id}")
        ->assertStatus(403);
});
