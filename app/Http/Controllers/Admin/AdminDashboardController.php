<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PalletRequest;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // TOTAL PESANAN (semua order)
        $totalOrders = Order::count();

        // TOTAL PENGAJUAN (pallet request)
        $totalRequests = PalletRequest::count();

        // CLIENT AKTIF
        // definisi: user role client yang punya aktivitas
        $activeClients = User::where('role', 'client')
            ->whereHas('palletRequests') // pernah ajukan
            ->count();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRequests',
            'activeClients'
        ));
    }
}
