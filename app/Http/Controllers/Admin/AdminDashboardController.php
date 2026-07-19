<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

// pemanggilan model
use App\Models\Pesanan;
use App\Models\PalletRequest;
use App\Models\MeetingRequest;
use App\Models\Kunjungan;
use App\Models\Hpp;
use App\Models\User;

// pemanggilan pagination
use Illuminate\Pagination\LengthAwarePaginator;

class AdminDashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Statistik Dashboard
        |--------------------------------------------------------------------------
        */

        // Total seluruh pesanan
        $totalPesanan = Pesanan::count();

        // Total seluruh pengajuan pallet
        $totalRequests = PalletRequest::count();

        /*
        |--------------------------------------------------------------------------
        | Client Aktif
        |--------------------------------------------------------------------------
        |
        | Client dianggap aktif apabila memiliki
        | pesanan dengan status "deal"
        |
        | Query ini dijalankan menggunakan PostgreSQL
        | melalui Eloquent ORM Laravel.
        |
        */

        $activeClients = User::where('role', 'client')
            ->whereHas('pesanan', function ($query) {
                $query->where('status', 'deal');
            })
            ->count();

        // Riwayat Aktivitas Pesanan
        $pesanan = Pesanan::with('client')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'waktu' => $item->created_at,

                    'kegiatan' => 'Pesanan ' .
                        $item->nama_project .
                        ' oleh ' .
                        ($item->client->name ?? 'Client'),

                    'kode' => '#ORD-' . $item->id,
                    'status' => $item->status,
                    'icon' => '📦',
                ];
            });

        // Riwayat Pengajuan Pallet
        $requests = PalletRequest::with('client')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'waktu' => $item->created_at,
                    'kegiatan' => 'Pengajuan ' .
                        $item->jenis_palet .
                        ' oleh ' .
                        ($item->client->name ?? 'Client'),

                    'kode' => '#REQ-' . $item->id,
                    'status' => $item->status,
                    'icon' => '📝',
                ];
            });

        // Riwayat Meeting
        $meetings = MeetingRequest::with('user')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'waktu' => $item->created_at,
                    'kegiatan' => 'Meeting: ' .
                        $item->judul .
                        ' dengan ' .
                        ($item->user->name ?? 'Client Tidak Dikenal'),

                    'kode' => '#MTG-' . $item->id,
                    'status' => $item->status,
                    'icon' => '📅',
                ];
            });

        // Riwayat Kunjungan
        $kunjungan = Kunjungan::with('client')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'waktu' => $item->created_at,
                    'kegiatan' => 'Kunjungan: ' .
                        $item->judul .
                        ' oleh ' .
                        ($item->client->name ?? 'Client'),
                    'kode' => '#KJG-' . $item->id,
                    'status' => $item->status,
                    'icon' => '🏙',
                ];
            });

        // Riwayat Upload HPP
        $hpps = Hpp::with('pesanan.client')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'waktu' => $item->created_at,

                    'kegiatan' => 'HPP: ' .
                        ($item->pesanan->nama_project ?? '-') .
                        ' (' .
                        ($item->pesanan->client->name ?? 'Client') .
                        ')',

                    'kode' => '#HPP-' . $item->id,
                    'status' => 'uploaded',
                    'icon' => '💰',
                ];
            });

        // Gabungkan Seluruh Aktivitas & sort
        $allLogs = collect()
            ->merge($pesanan)
            ->merge($requests)
            ->merge($meetings)
            ->merge($kunjungan)
            ->merge($hpps)
            ->sortByDesc('waktu');

        // manual pagination
        $perPage = 10;
        $currentPage = request()->get('page', 1);
        $pagedLogs = $allLogs
            ->slice(($currentPage - 1) * $perPage, $perPage)
            ->values();

        $logs = new LengthAwarePaginator(
            $pagedLogs,
            $allLogs->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        // mengembalikan ke tampilan
        return view('admin.dashboard', compact(
            'totalPesanan',
            'totalRequests',
            'activeClients',
            'logs'
        ));
    }
}
