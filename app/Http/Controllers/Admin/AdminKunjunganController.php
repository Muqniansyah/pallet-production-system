<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;

class AdminKunjunganController extends Controller
{
    public function index()
    {
        $kunjungan = Kunjungan::with('client')
            ->latest()
            ->paginate(5);

        return view('admin.kunjungan', compact('kunjungan'));
    }

    public function approve($id)
    {
        $kunjungan = Kunjungan::findOrFail($id);

        $kunjungan->update([
            'status' => 'disetujui'
        ]);

        return back()->with('success', 'Kunjungan disetujui');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string|max:500'
        ]);

        $kunjungan = Kunjungan::findOrFail($id);

        $kunjungan->update([
            'status' => 'ditolak',
            'keterangan' => $request->keterangan
        ]);

        return back()->with('success', 'Kunjungan ditolak dengan alasan');
    }
}
