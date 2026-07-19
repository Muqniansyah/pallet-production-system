<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

// pemanggilan model
use App\Models\Kunjungan;

class KunjunganController extends Controller
{
    // Menampilkan riwayat kunjungan milik client yang sedang login
    public function index()
    {
        $kunjungan = Kunjungan::where('client_id', auth()->id())
            ->latest()
            ->paginate(3);

        return view('client.kunjungan', compact('kunjungan'));
    }

    // Menyimpan pengajuan kunjungan baru
    public function store(Request $request)
    {
        // Validasi input pengajuan kunjungan
        $request->validate([
            'judul'             => 'required|string|max:255',
            'tanggal_kunjungan' => 'required|date|after:now',
        ], [
            'judul.required'             => 'Judul kunjungan wajib diisi.',
            'tanggal_kunjungan.required' => 'Waktu kunjungan wajib diisi.',
            'tanggal_kunjungan.after'    => 'Waktu kunjungan tidak boleh di hari/jam yang sudah lewat.',
        ]);

        // Ambil ID client yang sedang login
        $userId = auth()->id();

        // Hitung jumlah pengajuan kunjungan client hari ini
        $jumlahHariIni = Kunjungan::where('client_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Tolak pengajuan jika sudah mencapai batas 3 kunjungan per hari
        if ($jumlahHariIni >= 3) {
            return back()->withInput()->with('error', 'Maksimal 3 pengajuan kunjungan per hari.');
        }

        // Simpan pengajuan kunjungan ke database
        Kunjungan::create([
            'client_id'         => $userId,
            'judul'             => $request->judul,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'status'            => 'pending',
        ]);

        return back()->with('success', 'Jadwal kunjungan berhasil dibuat');
    }
}
