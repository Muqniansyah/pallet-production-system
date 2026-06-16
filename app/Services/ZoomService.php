<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZoomService
{
    // Mengambil access token dari Zoom API menggunakan kredensial aplikasi
    public function getAccessToken()
    {
        $response = Http::withBasicAuth(
            config('services.zoom.client_id'),
            config('services.zoom.client_secret')
        )->asForm()->post('https://zoom.us/oauth/token', [
            'grant_type' => 'account_credentials',
            'account_id' => config('services.zoom.account_id'),
        ]);

        // Mengembalikan access token dari response Zoom API
        return $response->json()['access_token'];
    }

    // Membuat meeting baru di Zoom menggunakan data dari request
    public function createMeeting($data)
    {
        // Ambil access token terlebih dahulu
        $token = $this->getAccessToken();

        // Kirim request ke Zoom API untuk membuat meeting
        $response = Http::withToken($token)->post(
            'https://api.zoom.us/v2/users/me/meetings',
            [
                'topic' => $data['judul'],
                'type' => 2, // tipe 2 = scheduled meeting (dijadwalkan pada waktu tertentu)
                'start_time' => $data['start_time'],
                'duration' => $data['durasi'],
                'timezone' => 'Asia/Jakarta',
            ]
        );

        // Mengembalikan data meeting yang berhasil dibuat dari response Zoom API
        return $response->json();
    }
}
