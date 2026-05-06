<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisitSchedule;

class AdminVisitScheduleController extends Controller
{
    public function index()
    {
        $visits = VisitSchedule::with('client')
            ->latest()
            ->paginate(5);

        return view('admin.kunjungan', compact('visits'));
    }

    public function approve($id)
    {
        $visit = VisitSchedule::findOrFail($id);

        $visit->update([
            'status' => 'approved'
        ]);

        return back()->with('success', 'Kunjungan disetujui');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string|max:500'
        ]);

        $visit = VisitSchedule::findOrFail($id);

        $visit->update([
            'status' => 'rejected',
            'note' => $request->note
        ]);

        return back()->with('success', 'Kunjungan ditolak dengan alasan');
    }
}
