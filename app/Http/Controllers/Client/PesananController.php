<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// pemanggilan model
use App\Models\Pesanan;
use App\Models\ProdukKayu;

class PesananController extends Controller
{
    // Menampilkan riwayat pesanan milik client yang sedang login
    public function index()
    {
        $pesanan = Pesanan::with('hpp')
            ->where('client_id', auth()->id())
            ->latest()
            ->paginate(5, ['*'], 'pesanan_page');

        return view('client.pesanan', compact('pesanan'));
    }

    // Mengubah status pesanan menjadi deal dan mengurangi stok
    public function setDeal($id)
    {
        $pesanan = Pesanan::with('palletRequest')
            ->where('client_id', auth()->id())
            ->findOrFail($id);

        // Cari produk kayu sesuai jenis palet yang dipesan
        $produk = ProdukKayu::with('stok')
            ->where(
                'nama_produk',
                $pesanan->palletRequest->jenis_palet
            )
            ->first();

        // Proses pengurangan stok jika produk ditemukan
        if ($produk && $produk->stok) {
            // Tolak jika stok tidak mencukupi
            if ($produk->stok->stok < $pesanan->qty) {
                return back()->with('error', 'Stok produk tidak mencukupi');
            }
            // Kurangi stok sesuai jumlah yang dipesan
            $produk->stok->decrement('stok', $pesanan->qty);
        }

        // Update status pesanan menjadi deal
        $pesanan->update([
            'status' => 'deal'
        ]);

        return back()->with('success', 'Pesanan siap diproses HPP');
    }

    // Membatalkan pesanan berdasarkan ID
    public function cancel($id)
    {
        $pesanan = Pesanan::where('client_id', auth()->id())
            ->findOrFail($id);

        // Update status pesanan menjadi batal
        $pesanan->update([
            'status' => 'batal'
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan');
    }
}
