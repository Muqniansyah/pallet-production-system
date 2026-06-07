<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// pemanggilan model
use App\Models\PalletRequest;

class PalletRequestController extends Controller
{
    // Menampilkan semua pengajuan palet dengan pagination
    public function index()
    {
        $requests = PalletRequest::with('client')->latest()->paginate(5);

        return view('admin.pallet-request', compact('requests'));
    }

    // Menyetujui pengajuan palet berdasarkan ID
    public function approve($id)
    {
        $request = PalletRequest::findOrFail($id);

        // Update status pengajuan menjadi disetujui
        $request->update([
            'status' => 'disetujui'
        ]);

        return back()->with('success', 'Pengajuan palet berhasil disetujui');
    }

    // Menolak pengajuan palet berdasarkan ID beserta keterangan alasan
    public function reject(Request $request, $id)
    {
        // Validasi keterangan penolakan (opsional)
        $request->validate([
            'keterangan' => 'nullable|string|max:500',
        ]);

        $palletRequest = PalletRequest::findOrFail($id);

        // Update status pengajuan menjadi ditolak beserta keterangan
        $palletRequest->update([
            'status' => 'ditolak',
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Pengajuan palet berhasil ditolak.');
    }
}
