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
        if (!$request->filled('keterangan')) {
            return back()->with('error', 'Alasan penolakan wajib diisi.');
        }

        $kunjungan = Kunjungan::findOrFail($id);

        // Update status kunjungan menjadi ditolak beserta keterangan
        $kunjungan->update([
            'status' => 'ditolak',
            'keterangan' => $request->keterangan
        ]);

        return back()->with('success', 'Kunjungan ditolak dengan alasan');
    }

    // Menghapus data kunjungan berdasarkan ID
    public function destroy($id)
    {
        $kunjungan = Kunjungan::findOrFail($id);
        $kunjungan->delete();

        return back()->with('success', 'Data kunjungan berhasil dihapus.');
    }
}
