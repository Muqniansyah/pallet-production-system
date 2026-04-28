<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PalletRequest;

class PalletRequestController extends Controller
{
    public function index()
    {
        $requests = PalletRequest::with('client')->latest()->get();

        return view('admin.pallet-request', compact('requests'));
    }

    public function approve($id)
    {
        $request = PalletRequest::findOrFail($id);
        $request->status = 'approved';
        $request->save();

        return back()->with('success', 'Request berhasil di-approve');
    }

    public function reject($id)
    {
        $request = PalletRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->save();

        return back()->with('success', 'Request berhasil di-reject');
    }
}
