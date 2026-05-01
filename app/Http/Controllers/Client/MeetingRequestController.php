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
            'title' => 'required',
            'start_time' => 'required|date|after:now',
            'duration' => 'required|in:15,30,40',
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
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'duration' => $request->duration,
        ]);

        return back()->with('success', 'Request berhasil dikirim');
    }
}
