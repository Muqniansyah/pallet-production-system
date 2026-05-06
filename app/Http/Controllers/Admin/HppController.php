<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Hpp;
use App\Models\PalletRequest;

class HppController extends Controller
{
    // tampil halaman
    public function index()
    {
        $clients = User::where('role', 'client')->get();

        // Untuk DROPDOWN upload HPP: hanya deal & belum punya HPP
        $ordersForUpload = Order::with('client')
            ->where('status', 'deal')
            ->whereDoesntHave('hpp')
            ->latest()
            ->get();

        // untuk tabel riwayat pesanan: semua order tampil
        $orders = Order::with('client')->latest()->paginate(5, ['*'], 'orders_page');

        // untuk tabel hpp riwayat
        $hpps = Hpp::with('order.client')->latest()->paginate(5, ['*'], 'hpps_page');

        // ambil request palet yang SUDAH DISETUJUI CLIENT
        $requests = PalletRequest::with('client')
            ->where('status', 'approved')
            ->whereDoesntHave('order')
            ->get();

        return view('admin.hpp', compact('clients', 'orders', 'ordersForUpload', 'hpps', 'requests'));
    }

    // upload HPP
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'file_hpp' => 'required|mimes:pdf,xlsx,xls|max:5120'
        ]);

        $order = Order::findOrFail($request->order_id);

        // hanya boleh upload kalau deal
        if ($order->status !== 'deal') {
            return back()->with('error', 'Order belum deal!');
        }

        // anti double HPP
        if (Hpp::where('order_id', $request->order_id)->exists()) {
            return back()->with('error', 'HPP sudah pernah diupload!');
        }

        $file = $request->file('file_hpp')->store('hpp_files', 'public');

        Hpp::create([
            'order_id' => $request->order_id,
            'file_hpp' => $file
        ]);

        return back()->with('success', 'HPP berhasil diupload');
    }
}
