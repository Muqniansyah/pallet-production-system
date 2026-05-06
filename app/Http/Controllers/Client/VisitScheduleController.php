<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisitSchedule;

class VisitScheduleController extends Controller
{
    public function index()
    {
        $visits = VisitSchedule::where('client_id', auth()->id())
            ->latest()
            ->paginate(3);

        return view('client.kunjungan', compact('visits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'visit_date' => 'required|date',
        ]);

        VisitSchedule::create([
            'client_id' => auth()->id(),
            'title' => $request->title,
            'visit_date' => $request->visit_date,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Jadwal kunjungan berhasil dibuat');
    }
}
