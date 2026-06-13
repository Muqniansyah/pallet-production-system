<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

// pemanggilan model
use App\Models\MeetingRequest;

class MeetingRequestController extends Controller
{
    // Menampilkan riwayat meeting request milik client yang sedang login
    public function index()
    {
        $meetings = MeetingRequest::where('client_id', auth()->user()->id)
            ->latest()
            ->paginate(3);

        return view('client.meet', compact('meetings'));
    }

    // Menyimpan pengajuan meeting request baru
    public function store(Request $request)
    {
        // Validasi input pengajuan meeting
        $request->validate([
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'required|string',
            'start_time' => 'required|date|after:now',
            'durasi'     => 'required|in:15,30,40',
        ], [
            'judul.required'      => 'Judul meeting wajib diisi.',
            'deskripsi.required'  => 'Deskripsi wajib diisi.',
            'start_time.required' => 'Tanggal & waktu wajib diisi.',
            'start_time.after'    => 'Tanggal & waktu tidak boleh di hari/jam yang sudah lewat.',
        ]);

        // Ambil ID client yang sedang login
        $userId = auth()->id();

        // Hitung jumlah pengajuan meeting client hari ini
        $todayCount = MeetingRequest::where('client_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Tolak pengajuan jika sudah mencapai batas 3 meeting per hari
        if ($todayCount >= 3) {
            return back()->withInput()->with('error', 'Maksimal 3 pengajuan meeting per hari.');
        }

        // Simpan pengajuan meeting ke database
        MeetingRequest::create([
            'client_id'  => $userId,
            'judul'      => $request->judul,
            'deskripsi'  => $request->deskripsi,
            'start_time' => $request->start_time,
            'durasi'     => $request->durasi,
        ]);

        return back()->with('success', 'Jadwal Pertemuan berhasil dikirim');
    }
}
