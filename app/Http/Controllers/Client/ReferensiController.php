<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

// pemanggilan model
use App\Models\ProdukKayu;

class ReferensiController extends Controller
{
    // Menampilkan semua referensi produk kayu beserta stok
    public function index()
    {
        // Ambil data dari cache jika ada, jika tidak ambil dari database dan simpan ke cache selama 10 menit
        $stocks = Cache::remember('produk_kayu', 600, function () {
            return ProdukKayu::with('stok')->latest()->get();
        });

        return view('client.referensi', compact('stocks'));
    }
}
