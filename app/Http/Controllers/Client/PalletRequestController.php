<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PalletRequest;

class PalletRequestController extends Controller
{
    public function index()
    {
        $requests = PalletRequest::where('client_id', auth()->id())
            ->latest()
            ->paginate(5);

        return view('client.pallet-request', compact('requests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_palet' => 'required',
            'qty' => 'required|integer|min:1',
            'alamat_kirim' => 'required',
            'file_desain' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        // upload file (kalau ada)
        $filePath = null;
        if ($request->hasFile('file_desain')) {
            $filePath = $request->file('file_desain')->store('desain', 'public');
        }

        // simpan ke database
        PalletRequest::create([
            'client_id' => auth()->id(),
            'nama_project' => $request->nama_project,
            'jenis_palet' => $request->jenis_palet,
            'qty' => $request->qty,
            'file_desain' => $filePath,
            'alamat_kirim' => $request->alamat_kirim,
            'catatan' => $request->catatan,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Request palet berhasil dikirim');
    }
}
