<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MeetingRequest;

class MeetController extends Controller
{
    public function index()
    {
        $meetings = MeetingRequest::where('client_id', auth()->user()->id)
            ->latest()
            ->get();

        return view('client.meet', compact('meetings'));
    }
}
