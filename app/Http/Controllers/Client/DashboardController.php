<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

// pemanggilan model
use App\Models\PalletRequest;
use App\Models\MeetingRequest;
use App\Models\Pesanan;

// pemanggilan pagination
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends Controller
{
    public function index()
    {
        // ambil id yang sedang login
        $userId = auth()->id();

        // riwayat pengajuan palet — untuk tabel dashboard (5 terbaru)
        $requests = PalletRequest::where('client_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // riwayat meeting 
        $meetings = MeetingRequest::where('client_id', $userId)
            ->latest()
            ->get();

        // CARD Total HPP Yang Sudah Diunggah - jumlah pesanan client yang punya relasi HPP.
        $hppCount = Pesanan::where('client_id', $userId)
            ->whereHas('hpp')
            ->count();

        // CARD Total project pengajuan palet dengan status disetujui
        $totalProject = PalletRequest::where('client_id', $userId)
            ->where('status', 'disetujui')
            ->count();

        // CARD pesanan aktif klien - jumlah pesanan client dengan status deal.
        $activePesanan = Pesanan::where('client_id', $userId)
            ->where('status', 'deal')
            ->count();

        // LOG AKTIVITAS
        $requestLogs = PalletRequest::where('client_id', $userId)
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'waktu' => $item->created_at,
                    'kegiatan' => 'Pengajuan ' . $item->jenis_palet,
                    'kode' => '#REQ-' . $item->id,
                    'status' => $item->status,
                    'icon' => '📝'
                ];
            });

        $meetingLogs = $meetings->map(function ($item) {
            return [
                'waktu' => $item->created_at,
                'kegiatan' => 'Meeting: ' . $item->judul,
                'kode' => '#MTG-' . $item->id,
                'status' => $item->status,
                'icon' => '📅'
            ];
        });

        // gabungkan & sort
        $allLogs = collect()
            ->merge($requestLogs)
            ->merge($meetingLogs)
            ->sortByDesc('waktu');

        // manual pagination
        $perPage = 3;
        $currentPage = request()->get('page', 1);
        $pagedLogs = $allLogs->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $logs = new LengthAwarePaginator(
            $pagedLogs,
            $allLogs->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // mengembalikkan ke tampilan
        return view('client.dashboard', compact(
            'requests',
            'meetings',
            'logs',
            'hppCount',
            'totalProject',
            'activePesanan'
        ));
    }
}
