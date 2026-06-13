<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// pemanggilan model
use App\Models\MeetingRequest;
// pemanggilan services
use App\Services\ZoomService;

class AdminMeetingController extends Controller
{
    // Menampilkan semua data meeting request dengan pagination
    public function index()
    {
        $meetings = MeetingRequest::with('user')->latest()->paginate(5);

        return view('admin.meet', compact('meetings'));
    }

    // Menyetujui meeting dan membuat meeting di Zoom
    public function approve($id, ZoomService $zoomService)
    {
        $meeting = MeetingRequest::findOrFail($id);

        // Format waktu ke format yang diterima Zoom API
        $startTime = date('Y-m-d\TH:i:s', strtotime($meeting->start_time));

        // Buat meeting di Zoom menggunakan ZoomService
        $zoom = $zoomService->createMeeting([
            'judul' => $meeting->judul,
            'start_time' => $startTime,
            'durasi' => $meeting->durasi,
        ]);

        // Simpan data meeting Zoom ke database
        $meeting->update([
            'status' => 'disetujui',
            'zoom_meeting_id' => $zoom['id'] ?? null,
            'join_url' => $zoom['join_url'] ?? null,
            'start_url' => $zoom['start_url'] ?? null,
        ]);

        return back()->with('success', 'Meeting berhasil dibuat di Zoom');
    }

    // Menolak meeting berdasarkan ID beserta keterangan alasan
    public function reject(Request $request, $id)
    {
        // Validasi keterangan penolakan wajib diisi
        if (!$request->filled('keterangan')) {
            return back()->with('error', 'Alasan penolakan wajib diisi.');
        }

        $meeting = MeetingRequest::findOrFail($id);

        // Update status meeting menjadi ditolak beserta keterangan
        $meeting->update([
            'status' => 'ditolak',
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Meeting ditolak');
    }

    // Menghapus data meeting berdasarkan ID
    public function destroy($id)
    {
        $meeting = MeetingRequest::findOrFail($id);
        $meeting->delete();

        return back()->with('success', 'Data meeting berhasil dihapus.');
    }
}
