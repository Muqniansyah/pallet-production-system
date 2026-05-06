<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MeetingRequest;
use App\Services\ZoomService;

class AdminMeetingController extends Controller
{
    public function index()
    {
        $meetings = MeetingRequest::with('user')->latest()->paginate(5);
        return view('admin.meet', compact('meetings'));
    }

    // admin approve
    public function approve($id, ZoomService $zoomService)
    {
        $meeting = MeetingRequest::findOrFail($id);

        // format waktu ke format Zoom
        $startTime = date('Y-m-d\TH:i:s', strtotime($meeting->start_time));

        $zoom = $zoomService->createMeeting([
            'title' => $meeting->title,
            'start_time' => $startTime,
            'duration' => $meeting->duration,
        ]);

        $meeting->update([
            'status' => 'approved',
            'zoom_meeting_id' => $zoom['id'] ?? null,
            'join_url' => $zoom['join_url'] ?? null,
            'start_url' => $zoom['start_url'] ?? null,
        ]);

        return back()->with('success', 'Meeting berhasil dibuat di Zoom');
    }

    // admin reject
    public function reject(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string'
        ]);

        $meeting = MeetingRequest::findOrFail($id);

        $meeting->update([
            'status' => 'rejected',
            'note' => $request->note,
        ]);

        return back()->with('success', 'Meeting ditolak');
    }
}
