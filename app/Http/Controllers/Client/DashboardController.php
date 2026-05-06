<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PalletRequest;
use App\Models\MeetingRequest;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // riwayat pallet — untuk tabel dashboard (5 terbaru)
        $requests = PalletRequest::where('client_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // riwayat meeting — untuk log
        $meetings = MeetingRequest::where('client_id', $userId)
            ->latest()
            ->get();

        // HITUNG HPP TERUNGGAH
        $hppCount = Order::where('client_id', $userId)
            ->whereHas('hpp')
            ->count();

        // TOTAL PROJECT
        $totalProject = PalletRequest::where('client_id', $userId)
            ->where('status', 'approved')
            ->count();

        // PESANAN AKTIF
        $activeOrders = Order::where('client_id', $userId)
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
                'kegiatan' => 'Meeting: ' . $item->title,
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

        return view('client.dashboard', compact(
            'requests',
            'meetings',
            'logs',
            'hppCount',
            'totalProject',
            'activeOrders'
        ));
    }
}
