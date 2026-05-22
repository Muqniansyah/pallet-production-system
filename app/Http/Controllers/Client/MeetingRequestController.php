<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MeetingRequest;
use Carbon\Carbon;

class MeetingRequestController extends Controller
{
    public function index()
    {
        $meetings = MeetingRequest::where('client_id', auth()->user()->id)
            ->latest()
            ->get();
        return view('client.meeting-request.index', compact('meetings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'start_time' => 'required|date|after:now',
            'durasi' => 'required|in:15,30,40',
        ]);

        $userId = auth()->id();

        // limit 3 per hari
        $todayCount = MeetingRequest::where('client_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        if ($todayCount >= 3) {
            return back()->with('error', 'Maksimal 3 pengajuan meeting per hari');
        }

        MeetingRequest::create([
            'client_id' => $userId,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'start_time' => $request->start_time,
            'durasi' => $request->durasi,
        ]);

        return back()->with('success', 'Request berhasil dikirim');
    }
}
