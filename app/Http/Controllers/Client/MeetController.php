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
            ->paginate(3);

        return view('client.meet', compact('meetings'));
    }
}
