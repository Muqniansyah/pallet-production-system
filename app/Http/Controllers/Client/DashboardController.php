<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PalletRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $requests = PalletRequest::where('client_id', auth()->id())
            ->latest()
            ->take(5) // ambil 5 terbaru
            ->get();

        return view('client.dashboard', compact('requests'));
    }
}
