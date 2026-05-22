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
            'judul' => 'required|string|max:255',
            'tanggal_kunjungan' => 'required|date',
        ]);

        Kunjungan::create([
            'client_id' => auth()->id(),
            'judul' => $request->judul,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Jadwal kunjungan berhasil dibuat');
    }
}
