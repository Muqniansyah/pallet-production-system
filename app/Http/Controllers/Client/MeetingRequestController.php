<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MeetingRequest; // WAJIB

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
            'start_time' => 'required|date',
            'duration' => 'required|integer',
        ]);

        MeetingRequest::create([
            'client_id' => auth()->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'duration' => $request->duration,
        ]);

        return back()->with('success', 'Request berhasil dikirim');
    }
}
