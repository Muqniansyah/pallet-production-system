<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// pemanggilan model
use App\Models\ProdukKayu;

class ReferensiController extends Controller
{
    // Menampilkan semua referensi produk kayu beserta stok
    public function index()
    {
        $stocks = ProdukKayu::with('stok')
            ->latest()
            ->get();

        return view('client.referensi', compact('stocks'));
    }
}
