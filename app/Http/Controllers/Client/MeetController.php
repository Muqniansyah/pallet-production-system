<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// pemanggilan model
use App\Models\MeetingRequest;

class MeetController extends Controller
{
    // Menampilkan riwayat meeting request milik client yang sedang login
    public function index()
    {
        $meetings = MeetingRequest::where('client_id', auth()->user()->id)
            ->latest()
            ->paginate(3);

        return view('client.meet', compact('meetings'));
    }
}
