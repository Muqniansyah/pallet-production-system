<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PalletRequest;
use App\Models\MeetingRequest;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // riwayat pallet
        $requests = PalletRequest::where('client_id', $userId)
            ->latest()
            ->take(5) // ambil 5 terbaru
            ->get();

        // riwayat meeting
        $meetings = MeetingRequest::where('client_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // HITUNG HPP TERUNGGAH
        $hppCount = Order::where('client_id', $userId)
            ->whereHas('hpp') // hanya order yang punya HPP
            ->count();

        // TOTAL PROJECT
        $totalProject = PalletRequest::where('client_id', $userId)
            ->where('status', 'approved')
            ->count();

        // PESANAN AKTIF
        $activeOrders = Order::where('client_id', $userId)
            ->where('status', 'deal')
            ->count();

        return view('client.dashboard', compact(
            'requests',
            'meetings',
            'hppCount',
            'totalProject',
            'activeOrders'
        ));
    }
}
