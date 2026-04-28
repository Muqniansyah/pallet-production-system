<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\PalletRequest;

class OrderController extends Controller
{
    public function index()
    {
        $clients = User::where('role', 'client')->get();
        $orders = Order::with('client')->latest()->get();

        return view('admin.hpp.index', compact('clients', 'orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pallet_request_id' => 'required|exists:pallet_requests,id',
            'nama_project' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
        ]);

        $palletRequest = PalletRequest::findOrFail($request->pallet_request_id);

        Order::create([
            'client_id' => $palletRequest->client_id, // otomatis
            'pallet_request_id' => $palletRequest->id,
            'nama_project' => $request->nama_project,
            'qty' => $request->qty,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Order berhasil dibuat dari request');
    }

    public function updateStatus($id, $status)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'status' => $status
        ]);

        return back()->with('success', 'Status diperbarui');
    }
}
