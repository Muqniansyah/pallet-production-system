<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PalletRequest;

class PalletRequestController extends Controller
{
    public function index()
    {
        $requests = PalletRequest::with('client')->latest()->paginate(5);

        return view('admin.pallet-request', compact('requests'));
    }

    public function approve($id)
    {
        $request = PalletRequest::findOrFail($id);
        $request->status = 'approved';
        $request->save();

        return back()->with('success', 'Request berhasil di-approve');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_note' => 'nullable|string|max:500',
        ]);

        $palletRequest = PalletRequest::findOrFail($id);
        $palletRequest->update([
            'status' => 'rejected',
            'rejection_note' => $request->rejection_note,
        ]);

        return back()->with('success', 'Request berhasil ditolak.');
    }
}
