<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;

class KunjunganController extends Controller
{
    public function index()
    {
        $kunjungan = Kunjungan::where('client_id', auth()->id())
            ->latest()
            ->paginate(3);

        return view('client.kunjungan', compact('kunjungan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'             => 'required|string|max:255',
            'tanggal_kunjungan' => 'required|date|after:now',
        ], [
            'judul.required'             => 'Judul kunjungan wajib diisi.',
            'tanggal_kunjungan.required' => 'Waktu kunjungan wajib diisi.',
            'tanggal_kunjungan.after'    => 'Waktu kunjungan tidak boleh di hari/jam yang sudah lewat.',
        ]);

        // Cek maksimal 3 kunjungan per hari untuk client yang sama
        $tanggal = \Carbon\Carbon::parse($request->tanggal_kunjungan);

        $jumlahHariIni = Kunjungan::where('client_id', auth()->id())
            ->whereDate('tanggal_kunjungan', $tanggal->toDateString())
            ->count();

        if ($jumlahHariIni >= 3) {
            return back()
                ->withInput()
                ->withErrors([
                    'tanggal_kunjungan' => 'Anda sudah mengajukan 3 kunjungan pada tanggal tersebut. Maksimal 3 kunjungan per hari.',
                ]);
        }

        Kunjungan::create([
            'client_id'         => auth()->id(),
            'judul'             => $request->judul,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'status'            => 'pending',
        ]);

        return back()->with('success', 'Jadwal kunjungan berhasil dibuat');
    }
}
