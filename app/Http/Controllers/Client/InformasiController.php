<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    // Menampilkan halaman pusat informasi
    public function index()
    {
        return view('client.informasi');
    }
}
