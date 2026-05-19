<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProdukKayu;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('hpp')
            ->where('client_id', auth()->id())
            ->latest()
            ->paginate(5, ['*'], 'orders_page');

        return view('client.orders', compact('orders'));
    }

    public function setDeal($id)
    {
        $order = Order::with('palletRequest')
            ->where('client_id', auth()->id())
            ->findOrFail($id);

        // cari produk sesuai jenis palet
        $produk = ProdukKayu::with('stok')
            ->where(
                'nama_produk',
                $order->palletRequest->jenis_palet
            )
            ->first();

        // jika produk ditemukan
        if ($produk && $produk->stok) {

            // cek stok cukup atau tidak
            if ($produk->stok->stok < $order->qty) {
                return back()->with(
                    'error',
                    'Stok produk tidak mencukupi'
                );
            }

            // kurangi stok
            $produk->stok->decrement(
                'stok',
                $order->qty
            );
        }

        // ubah status order
        $order->update([
            'status' => 'deal'
        ]);

        return back()->with(
            'success',
            'Order siap diproses HPP'
        );
    }

    public function cancel($id)
    {
        $order = Order::where('client_id', auth()->id())
            ->findOrFail($id);

        $order->update([
            'status' => 'batal'
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan');
    }
}
