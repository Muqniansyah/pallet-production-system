<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\ProdukKayu;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with('hpp')
            ->where('client_id', auth()->id())
            ->latest()
            ->paginate(5, ['*'], 'pesanan_page');

        return view('client.pesanan', compact('pesanan'));
    }

    public function setDeal($id)
    {
        $pesanan = Pesanan::with('palletRequest')
            ->where('client_id', auth()->id())
            ->findOrFail($id);

        // cari produk sesuai jenis palet
        $produk = ProdukKayu::with('stok')
            ->where(
                'nama_produk',
                $pesanan->palletRequest->jenis_palet
            )
            ->first();

        // jika produk ditemukan
        if ($produk && $produk->stok) {

            // cek stok cukup atau tidak
            if ($produk->stok->stok < $pesanan->qty) {
                return back()->with(
                    'error',
                    'Stok produk tidak mencukupi'
                );
            }

            // kurangi stok
            $produk->stok->decrement(
                'stok',
                $pesanan->qty
            );
        }

        // ubah status pesanan
        $pesanan->update([
            'status' => 'deal'
        ]);

        return back()->with(
            'success',
            'Pesanan siap diproses HPP'
        );
    }

    public function cancel($id)
    {
        $pesanan = Pesanan::where('client_id', auth()->id())
            ->findOrFail($id);

        $pesanan->update([
            'status' => 'batal'
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan');
    }
}
