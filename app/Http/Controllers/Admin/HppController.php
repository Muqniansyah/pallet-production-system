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
        $orders = Order::with('client')->latest()->get();
        $hpps = Hpp::with('order.client')->latest()->get();

        // ambil request palet yang SUDAH DISETUJUI CLIENT
        $requests = PalletRequest::with('client')
            ->where('status', 'approved')
            ->get();

        return view('admin.hpp', compact('clients', 'orders', 'hpps', 'requests'));
    }

    // upload HPP
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'file_hpp' => 'required|mimes:pdf,xlsx,xls|max:5120'
        ]);

        $order = Order::findOrFail($request->order_id);

        // 🔥 hanya boleh upload kalau deal
        if ($order->status !== 'deal') {
            return back()->with('error', 'Order belum deal!');
        }

        $file = $request->file('file_hpp')->store('hpp_files', 'public');

        Hpp::create([
            'order_id' => $request->order_id,
            'file_hpp' => $file
        ]);

        return back()->with('success', 'HPP berhasil diupload');
    }
}
