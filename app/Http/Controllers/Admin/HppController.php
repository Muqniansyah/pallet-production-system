<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
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
        $pesananForUpload = Pesanan::with('client')
            ->where('status', 'deal')
            ->whereDoesntHave('hpp')
            ->latest()
            ->get();

        // untuk tabel riwayat pesanan: semua pesanan tampil
        $pesanan = Pesanan::with('client')->latest()->paginate(5, ['*'], 'pesanan_page');

        // untuk tabel hpp riwayat
        $hpps = Hpp::with('pesanan.client')->latest()->paginate(5, ['*'], 'hpps_page');

        // ambil request palet yang SUDAH DISETUJUI CLIENT
        $requests = PalletRequest::with('client')
            ->where('status', 'approved')
            ->whereDoesntHave('pesanan')
            ->get();

        return view('admin.hpp', compact('clients', 'pesanan', 'pesananForUpload', 'hpps', 'requests'));
    }

    // upload HPP
    public function store(Request $request)
    {
        $request->validate([
            'pesanan_id' => 'required|exists:pesanan,id',
            'file_hpp' => 'required|mimes:pdf,xlsx,xls|max:5120'
        ]);

        $pesanan = Pesanan::findOrFail($request->pesanan_id);

        // hanya boleh upload kalau deal
        if ($pesanan->status !== 'deal') {
            return back()->with('error', 'Order belum deal!');
        }

        // anti double HPP
        if (Hpp::where('pesanan_id', $request->pesanan_id)->exists()) {
            return back()->with('error', 'HPP sudah pernah diupload!');
        }

        $file = $request->file('file_hpp')->store('hpp_files', 'public');

        Hpp::create([
            'pesanan_id' => $request->pesanan_id,
            'file_hpp' => $file
        ]);

        return back()->with('success', 'HPP berhasil diupload');
    }
}
