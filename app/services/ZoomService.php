<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZoomService
{
    public function getAccessToken()
    {
        $response = Http::withBasicAuth(
            config('services.zoom.client_id'),
            config('services.zoom.client_secret')
        )->asForm()->post('https://zoom.us/oauth/token', [
            'grant_type' => 'account_credentials',
            'account_id' => config('services.zoom.account_id'),
        ]);

        return $response->json()['access_token'];
    }

    public function createMeeting($data)
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)->post(
            'https://api.zoom.us/v2/users/me/meetings',
            [
                'topic' => $data['title'],
                'type' => 2,
                'start_time' => $data['start_time'],
                'duration' => $data['duration'],
                'timezone' => 'Asia/Jakarta',
            ]
        );

        return $response->json();
    }
}
