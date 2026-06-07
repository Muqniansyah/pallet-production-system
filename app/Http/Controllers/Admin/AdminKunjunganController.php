<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// pemanggilan model
use App\Models\Kunjungan;

class AdminKunjunganController extends Controller
{
    // Menampilkan semua data kunjungan dengan pagination
    public function index()
    {
        $kunjungan = Kunjungan::with('client')
            ->latest()
            ->paginate(5);

        return view('admin.kunjungan', compact('kunjungan'));
    }

    // Menyetujui kunjungan berdasarkan ID
    public function approve($id)
    {
        $kunjungan = Kunjungan::findOrFail($id);

        // Update status kunjungan menjadi disetujui
        $kunjungan->update([
            'status' => 'disetujui'
        ]);

        return back()->with('success', 'Kunjungan disetujui');
    }

    // Menolak kunjungan berdasarkan ID beserta keterangan alasan
    public function reject(Request $request, $id)
    {
        // Validasi keterangan penolakan wajib diisi
        $request->validate([
            'keterangan' => 'required|string|max:500'
        ]);

        $kunjungan = Kunjungan::findOrFail($id);

        // Update status kunjungan menjadi ditolak beserta keterangan
        $kunjungan->update([
            'status' => 'ditolak',
            'keterangan' => $request->keterangan
        ]);

        return back()->with('success', 'Kunjungan ditolak dengan alasan');
    }
}
