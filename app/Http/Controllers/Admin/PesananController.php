<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\PalletRequest;

class PesananController extends Controller
{
    public function index()
    {
        $clients = User::where('role', 'client')->get();
        $pesanan = Pesanan::with('client')->latest()->get();

        return view('admin.hpp.index', compact('clients', 'pesanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pallet_request_id' => 'required|exists:pallet_requests,id',
            'nama_project' => 'required|string|max:255',
        ]);

        // cegah double pesanan
        if (Pesanan::where('pallet_request_id', $request->pallet_request_id)->exists()) {
            return back()->with('error', 'Pesanan sudah pernah dibuat!');
        }

        $palletRequest = PalletRequest::findOrFail($request->pallet_request_id);

        Pesanan::create([
            'client_id' => $palletRequest->client_id, // otomatis
            'pallet_request_id' => $palletRequest->id,
            'nama_project' => $request->nama_project,
            'qty' => $palletRequest->qty,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Pesanan berhasil dibuat!');
    }

    public function updateStatus($id, $status)
    {
        $pesanan = Pesanan::findOrFail($id);

        $pesanan->update([
            'status' => $status
        ]);

        return back()->with('success', 'Status diperbarui');
    }
}
