<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PalletRequest;

class PalletRequestController extends Controller
{
    public function index()
    {
        $requests = PalletRequest::with('client')->latest()->paginate(5);

        return view('admin.pallet-request', compact('requests'));
    }

    public function approve($id)
    {
        $request = PalletRequest::findOrFail($id);
        $request->status = 'disetujui';
        $request->save();

        return back()->with('success', 'Pengajuan palet berhasil disetujui');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'nullable|string|max:500',
        ]);

        $palletRequest = PalletRequest::findOrFail($id);
        $palletRequest->update([
            'status' => 'ditolak',
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Pengajuan palet berhasil ditolak.');
    }
}
