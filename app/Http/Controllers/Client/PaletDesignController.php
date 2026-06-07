<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

// pemanggilan model
use App\Models\PaletDesign;

class PaletDesignController extends Controller
{
    // Menerima dan menyimpan data desain palet dari Netlify secara real-time
    public function sync(Request $request): JsonResponse
    {
        // Ambil origin dari header request
        $origin = $request->headers->get('Origin') ?? '';

        // Daftar origin yang diizinkan mengakses endpoint ini
        $allowedOrigins = [
            'https://courageous-rolypoly-532571.netlify.app',
            'http://localhost:8000',
            'http://127.0.0.1:8000',
        ];

        // Tolak request jika origin tidak diizinkan
        // Jika tidak ada origin (Postman, server-to-server) tetap diizinkan
        if ($origin && !in_array($origin, $allowedOrigins)) {
            return response()->json(['error' => 'Origin tidak diizinkan'], 403);
        }

        // Ambil seluruh data dari request
        $payload = $request->all();

        // Ambil session_id dari payload atau gunakan session Laravel
        $sessionId = $payload['session_id'] ?? session()->getId();

        // Map payload dari netlify ke kolom database
        $data = [
            'user_id'                  => Auth::id() ?? null,
            'session_id'               => $sessionId,
            'last_updated_at'          => now(),

            // Dimensi utama
            'dimensi_panjang'          => $payload['dimensi']['panjang'] ?? null,
            'dimensi_lebar'            => $payload['dimensi']['lebar'] ?? null,

            // Papan atas
            'papan_atas_tebal'         => $payload['papan_atas']['tebal'] ?? null,
            'papan_atas_lebar'         => $payload['papan_atas']['lebar'] ?? null,
            'papan_atas_jumlah'        => $payload['papan_atas']['jumlah'] ?? null,
            'papan_atas_gap'           => $payload['papan_atas']['gap'] ?? null,
            'papan_atas_arah'          => $payload['papan_atas']['arah'] ?? null,

            // Lapisan tengah
            'lapisan_tengah_tipe'      => $payload['lapisan_tengah']['tipe'] ?? null,
            'lapisan_tengah_tinggi'    => $payload['lapisan_tengah']['tinggi'] ?? null,
            'lapisan_tengah_lebar'     => $payload['lapisan_tengah']['lebar'] ?? null,
            'lapisan_tengah_jumlah'    => $payload['lapisan_tengah']['jumlah'] ?? null,
            'lapisan_tengah_susunan'   => $payload['lapisan_tengah']['susunan'] ?? null,
            'lapisan_tengah_arah'      => $payload['lapisan_tengah']['arah'] ?? null,

            // Papan bawah
            'papan_bawah_tebal'        => $payload['papan_bawah']['tebal'] ?? null,
            'papan_bawah_lebar'        => $payload['papan_bawah']['lebar'] ?? null,
            'papan_bawah_jumlah'       => $payload['papan_bawah']['jumlah'] ?? null,
            'papan_bawah_arah'         => $payload['papan_bawah']['arah'] ?? null,
            'papan_bawah_pola'         => $payload['papan_bawah']['pola'] ?? null,
            'papan_bawah_gap_manual'   => $payload['papan_bawah']['gap_manual'] ?? null,

            // Kalibrasi & tracking
            'kalibrasi_lebar_tangan'   => $payload['kalibrasi']['lebar_tangan'] ?? null,
            'mode_tracking'            => $payload['mode_tracking'] ?? null,

            // Gesture ML result
            'gesture_x'                => $payload['gesture']['x'] ?? null,
            'gesture_y'                => $payload['gesture']['y'] ?? null,
            'gesture_z'                => $payload['gesture']['z'] ?? null,

            // Output kalkulasi
            'hasil_kalkulasi'          => $payload['hasil_kalkulasi'] ?? null,

            // Simpan seluruh raw payload sebagai backup
            'raw_payload'              => $payload,
        ];

        // Update data jika session_id sudah ada, insert baru jika belum
        $record = PaletDesign::updateOrCreate(
            ['session_id' => $sessionId],
            $data
        );

        // Kembalikan response sukses beserta ID dan waktu update
        return response()->json([
            'status'  => 'ok',
            'id'      => $record->id,
            'updated' => $record->last_updated_at,
        ], 200);
    }

    // Mengambil 100 data desain palet terbaru
    public function index(): JsonResponse
    {
        $designs = PaletDesign::orderBy('last_updated_at', 'desc')
            ->limit(100)
            ->get();

        // Kembalikan data desain dalam format JSON
        return response()->json($designs);
    }
}
