<?php

// FILE: app/Http/Controllers/PaletDesignController.php

namespace App\Http\Controllers;

use App\Models\PaletDesign;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PaletDesignController extends Controller
{
    /**
     * Terima data real-time dari PaletView (Netlify) via postMessage bridge.
     * Upsert berdasarkan session_id — satu sesi = satu record yang terus diupdate.
     */
    public function sync(Request $request): JsonResponse
    {
        // // Validasi origin — hanya izinkan dari netlify milik kamu
        // $allowedOrigins = [
        //     'https://courageous-rolypoly-532571.netlify.app',
        //     'http://localhost:8000',   // untuk development
        //     'http://127.0.0.1:8000',  // untuk development
        // ];

        // $origin = $request->headers->get('Origin') ?? '';
        // if (!in_array($origin, $allowedOrigins)) {
        //     return response()->json(['error' => 'Origin tidak diizinkan'], 403);
        // }

        $origin = $request->headers->get('Origin') ?? '';
        $allowedOrigins = [
            'https://courageous-rolypoly-532571.netlify.app',
            'http://localhost:8000',
            'http://127.0.0.1:8000',
        ];

        // Kalau ada origin tapi tidak diizinkan, baru tolak
        // Kalau tidak ada origin (Postman, server-to-server) → izinkan
        if ($origin && !in_array($origin, $allowedOrigins)) {
            return response()->json(['error' => 'Origin tidak diizinkan'], 403);
        }


        $payload = $request->all();

        // Ambil atau buat session_id
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

        // Upsert: update jika session_id sudah ada, insert jika belum
        $record = PaletDesign::updateOrCreate(
            ['session_id' => $sessionId],
            $data
        );

        return response()->json([
            'status'  => 'ok',
            'id'      => $record->id,
            'updated' => $record->last_updated_at,
        ], 200);
    }

    /**
     * Ambil semua desain palet milik user yang login (untuk ditampilkan di dashboard).
     */
    // public function index(): JsonResponse
    // {
    //     $designs = PaletDesign::where('user_id', Auth::id())
    //         ->orderBy('last_updated_at', 'desc')
    //         ->get();

    //     return response()->json($designs);
    // }
    public function index(): JsonResponse
    {
        // Jika tidak login, kembalikan array kosong (bukan 401)
        // supaya dashboard tidak error, hanya tampil tabel kosong
        // if (!Auth::check()) {
        //     return response()->json([]);
        // }

        // $designs = PaletDesign::where('user_id', Auth::id())
        //     ->orderBy('last_updated_at', 'desc')
        //     ->get();

        // return response()->json($designs);

        $designs = PaletDesign::orderBy('last_updated_at', 'desc')
            ->limit(100)
            ->get();

        return response()->json($designs);
    }
}
