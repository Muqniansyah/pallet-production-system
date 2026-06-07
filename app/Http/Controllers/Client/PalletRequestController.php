<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// pemanggilan model
use App\Models\PalletRequest;
use App\Models\ProdukKayu;

class PalletRequestController extends Controller
{
    // Menampilkan riwayat pengajuan palet milik client yang sedang login
    public function index()
    {
        $requests = PalletRequest::where('client_id', auth()->id())
            ->latest()
            ->paginate(5);

        // Ambil semua produk kayu beserta stok untuk pilihan jenis palet
        $produk = ProdukKayu::with('stok')->get();

        return view('client.pallet-request', compact(
            'requests',
            'produk'
        ));
    }

    // Menyimpan pengajuan palet baru
    public function store(Request $request)
    {
        // Validasi input pengajuan palet
        $request->validate([
            'jenis_palet'  => 'required',
            'qty'          => 'required|integer|min:1',
            'alamat_kirim' => 'required',
            'catatan'      => 'required',
            'file_desain' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'jenis_palet.required'  => 'Jenis palet wajib dipilih.',
            'qty.required'          => 'Jumlah (qty) wajib diisi.',
            'qty.min'               => 'Jumlah (qty) minimal 1.',
            'alamat_kirim.required' => 'Alamat pengiriman wajib diisi.',
            'catatan.required'      => 'Catatan wajib diisi.',
            'file_desain.required'  => 'File desain wajib diunggah.',
            'file_desain.mimes'     => 'File desain harus berformat PDF, JPG, atau PNG.',
            'file_desain.max'       => 'Ukuran file desain maksimal 5MB.',
        ]);

        // Upload file desain ke storage jika ada
        $filePath = null;
        if ($request->hasFile('file_desain')) {
            $filePath = $request->file('file_desain')->store('desain', 'public');
        }

        // Simpan pengajuan palet ke database
        PalletRequest::create([
            'client_id' => auth()->id(),
            'jenis_palet' => $request->jenis_palet,
            'qty' => $request->qty,
            'file_desain' => $filePath,
            'alamat_kirim' => $request->alamat_kirim,
            'catatan' => $request->catatan,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Pengajuan palet berhasil dikirim');
    }
}
