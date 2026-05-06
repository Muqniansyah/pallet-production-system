<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PalletRequest;
use App\Models\MeetingRequest;
use App\Models\Hpp;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // TOTAL PESANAN (semua order)
        $totalOrders = Order::count();

        // TOTAL PENGAJUAN (pallet request)
        $totalRequests = PalletRequest::count();

        // Client aktif = punya order / pesanan yang masih berjalan
        $activeClients = User::where('role', 'client')
            ->whereHas('orders', function ($q) {
                $q->where('status', 'deal');
            })
            ->count();

        // LOG AKTIVITAS — hapus take(5), ambil semua untuk pagination
        $orders = Order::with('client')->latest()->get()->map(function ($item) {
            return [
                'waktu' => $item->created_at,
                'kegiatan' => 'Order ' . $item->nama_project . ' oleh ' . ($item->client->name ?? 'Client'),
                'kode' => '#ORD-' . $item->id,
                'status' => $item->status,
                'icon' => '📦'
            ];
        });

        $requests = PalletRequest::with('client')->latest()->get()->map(function ($item) {
            return [
                'waktu' => $item->created_at,
                'kegiatan' => 'Pengajuan ' . $item->jenis_palet . ' oleh ' . ($item->client->name ?? 'Client'),
                'kode' => '#REQ-' . $item->id,
                'status' => $item->status,
                'icon' => '📝'
            ];
        });

        $meetings = MeetingRequest::with('user')->latest()->get()->map(function ($item) {
            return [
                'waktu' => $item->created_at,
                'kegiatan' => 'Meeting: ' . $item->title . ' dengan ' . ($item->user->name ?? 'Client Tidak Dikenal'),
                'kode' => '#MTG-' . $item->id,
                'status' => $item->status,
                'icon' => '📅'
            ];
        });

        $hpps = Hpp::with('order.client')->latest()->get()->map(function ($item) {
            return [
                'waktu' => $item->created_at,
                'kegiatan' => 'HPP: ' . ($item->order->nama_project ?? '-') .
                    ' (' . ($item->order->client->name ?? 'Client') . ')',
                'kode' => '#HPP-' . $item->id,
                'status' => 'uploaded',
                'icon' => '💰'
            ];
        });

        // gabungkan semua & sort
        $allLogs = collect()
            ->merge($orders)
            ->merge($requests)
            ->merge($meetings)
            ->merge($hpps)
            ->sortByDesc('waktu');

        // manual pagination
        $perPage = 10;
        $currentPage = request()->get('page', 1);
        $pagedLogs = $allLogs->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $logs = new LengthAwarePaginator(
            $pagedLogs,
            $allLogs->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRequests',
            'activeClients',
            'logs'
        ));
    }
}
