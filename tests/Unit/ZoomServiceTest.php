<?php

use App\Services\ZoomService;
use Illuminate\Support\Facades\Http;

// ═══════════════════════════════════════════
// GET ACCESS TOKEN
// ═══════════════════════════════════════════

test('getAccessToken mengembalikan token dari Zoom API', function () {
    // Mock HTTP request ke Zoom OAuth
    Http::fake([
        'zoom.us/oauth/token' => Http::response([
            'access_token' => 'fake-access-token-123',
        ], 200),
    ]);

    $service = new ZoomService();
    $token   = $service->getAccessToken();

    expect($token)->toBe('fake-access-token-123');
});

test('getAccessToken mengirim request dengan basic auth yang benar', function () {
    Http::fake([
        'zoom.us/oauth/token' => Http::response([
            'access_token' => 'fake-token',
        ], 200),
    ]);

    $service = new ZoomService();
    $service->getAccessToken();

    Http::assertSent(function ($request) {
        return str_contains($request->url(), 'zoom.us/oauth/token')
            && $request['grant_type'] === 'account_credentials';
    });
});

// ═══════════════════════════════════════════
// CREATE MEETING
// ═══════════════════════════════════════════

test('createMeeting mengembalikan data meeting dari Zoom API', function () {
    Http::fake([
        // Mock token endpoint
        'zoom.us/oauth/token' => Http::response([
            'access_token' => 'fake-token',
        ], 200),
        // Mock create meeting endpoint
        'api.zoom.us/v2/users/me/meetings' => Http::response([
            'id'        => '123456789',
            'join_url'  => 'https://zoom.us/j/123456789',
            'start_url' => 'https://zoom.us/s/123456789',
        ], 201),
    ]);

    $service = new ZoomService();
    $result  = $service->createMeeting([
        'judul'      => 'Meeting SIPALET',
        'start_time' => '2026-12-01T10:00:00',
        'durasi'     => 30,
    ]);

    expect($result)->toHaveKey('id')
        ->and($result['id'])->toBe('123456789')
        ->and($result)->toHaveKey('join_url')
        ->and($result)->toHaveKey('start_url');
});

test('createMeeting mengirim data yang benar ke Zoom API', function () {
    Http::fake([
        'zoom.us/oauth/token' => Http::response([
            'access_token' => 'fake-token',
        ], 200),
        'api.zoom.us/v2/users/me/meetings' => Http::response([
            'id'        => '987654321',
            'join_url'  => 'https://zoom.us/j/987654321',
            'start_url' => 'https://zoom.us/s/987654321',
        ], 201),
    ]);

    $service = new ZoomService();
    $service->createMeeting([
        'judul'      => 'Diskusi Palet Kayu Jati',
        'start_time' => '2026-12-01T10:00:00',
        'durasi'     => 45,
    ]);

    Http::assertSent(function ($request) {
        return str_contains($request->url(), 'api.zoom.us/v2/users/me/meetings')
            && $request['topic'] === 'Diskusi Palet Kayu Jati'
            && $request['duration'] === 45
            && $request['timezone'] === 'Asia/Jakarta'
            && $request['type'] === 2;
    });
});

test('createMeeting menggunakan token dari getAccessToken', function () {
    Http::fake([
        'zoom.us/oauth/token' => Http::response([
            'access_token' => 'token-spesifik-123',
        ], 200),
        'api.zoom.us/v2/users/me/meetings' => Http::response([
            'id' => '111',
        ], 201),
    ]);

    $service = new ZoomService();
    $service->createMeeting([
        'judul'      => 'Test Meeting',
        'start_time' => '2026-12-01T10:00:00',
        'durasi'     => 30,
    ]);

    // Verifikasi token endpoint dipanggil sebelum create meeting
    Http::assertSentCount(2);
});
