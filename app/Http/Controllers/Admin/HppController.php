<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// pemanggilan model
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Hpp;
use App\Models\PalletRequest;

class HppController extends Controller
{
    // Menampilkan halaman HPP beserta data yang dibutuhkan
    public function index()
    {
        // Ambil semua data client
        $clients = User::where('role', 'client')->get();

        // Pesanan berstatus deal dan belum memiliki HPP (untuk dropdown upload)
        $pesananForUpload = Pesanan::with('client')
            ->where('status', 'deal')
            ->whereDoesntHave('hpp')
            ->latest()
            ->get();

        // Semua pesanan untuk tabel riwayat dengan pagination
        $pesanan = Pesanan::with(['client', 'palletRequest'])->latest()->paginate(5, ['*'], 'pesanan_page');

        // Semua HPP untuk tabel riwayat dengan pagination
        $hpps = Hpp::with('pesanan.client')->latest()->paginate(5, ['*'], 'hpps_page');

        // Pengajuan palet yang sudah disetujui dan belum memiliki pesanan
        $requests = PalletRequest::with('client')
            ->where('status', 'disetujui')
            ->whereDoesntHave('pesanan')
            ->get();

        return view('admin.hpp', compact('clients', 'pesanan', 'pesananForUpload', 'hpps', 'requests'));
    }

    // Mengunggah file HPP untuk pesanan yang sudah deal
    public function store(Request $request)
    {
        // Validasi input unggah HPP
        $request->validate([
            'pesanan_id' => 'required|exists:pesanan,id',
            'file_hpp'   => 'required|mimes:pdf,xlsx,xls|max:5120',
        ], [
            'pesanan_id.required' => 'Pesanan wajib dipilih.',
            'file_hpp.required'   => 'File HPP wajib diunggah.',
            'file_hpp.mimes'      => 'File HPP harus berformat PDF atau Excel.',
            'file_hpp.max'        => 'Ukuran file HPP maksimal 5MB.',
        ]);

        $pesanan = Pesanan::findOrFail($request->pesanan_id);

        // Tolak upload jika pesanan belum berstatus deal
        if ($pesanan->status !== 'deal') {
            return back()->with('error', 'Pesanan belum deal!');
        }

        // Cegah upload HPP lebih dari satu kali untuk pesanan yang sama
        if (Hpp::where('pesanan_id', $request->pesanan_id)->exists()) {
            return back()->with('error', 'HPP sudah pernah diunggah!');
        }

        // Simpan file HPP ke storage
        $file = $request->file('file_hpp')->store('hpp_files', 'public');

        // Simpan data HPP ke database
        Hpp::create([
            'pesanan_id' => $request->pesanan_id,
            'file_hpp' => $file
        ]);

        return back()->with('success', 'HPP berhasil diunggah');
    }
}
