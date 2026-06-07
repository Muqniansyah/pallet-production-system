<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// pemanggilan model
use App\Models\ProdukKayu;
use App\Models\StokKayu;

class StokKayuController extends Controller
{
    // Menampilkan semua data produk kayu beserta stok dengan pagination
    public function index()
    {
        $stocks = ProdukKayu::with('stok')
            ->latest()
            ->paginate(6);

        return view('admin.stok', compact('stocks'));
    }

    // Menambahkan produk kayu baru beserta stok awal
    public function store(Request $request)
    {
        // Validasi input produk baru
        $request->validate([
            'nama_produk' => 'required|string|max:255|unique:produk_kayu,nama_produk',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'keterangan'  => 'required|string',
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.unique'   => 'Nama produk sudah pernah dipakai, gunakan nama lain.',
            'stok.required'        => 'Stok awal wajib diisi.',
            'stok.min'             => 'Stok awal tidak boleh kurang dari 0.',
            'gambar.required'      => 'Gambar produk wajib diunggah.',
            'gambar.max'           => 'Ukuran gambar maksimal 2MB.',
            'keterangan.required'  => 'Keterangan wajib diisi.',
        ]);

        // Upload gambar ke storage jika ada
        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')
                ->store('produk-kayu', 'public');
        }

        // Simpan data produk baru ke database
        $produk = ProdukKayu::create([
            'nama_produk' => $request->nama_produk,
            'gambar' => $gambar,
            'satuan' => 'PCS',
            'keterangan' => $request->keterangan,
        ]);

        // Simpan stok awal produk ke database
        StokKayu::create([
            'produk_kayu_id' => $produk->id,
            'stok' => $request->stok,
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan');
    }

    // Memperbarui data produk kayu berdasarkan ID
    public function update(Request $request, $id)
    {
        // Validasi input update produk
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $produk = ProdukKayu::with('stok')->findOrFail($id);

        // Update gambar jika ada file baru yang diunggah
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')
                ->store('produk-kayu', 'public');

            $produk->gambar = $gambar;
        }

        // Update data produk
        $produk->update([
            'nama_produk' => $request->nama_produk,
            'keterangan' => $request->keterangan,
        ]);

        // Update stok produk jika sudah ada
        if ($produk->stok) {
            $produk->stok->update([
                'stok' => $request->stok
            ]);
        }

        return back()->with('success', 'Produk berhasil diupdate');
    }

    // Menghapus produk kayu berdasarkan ID
    public function destroy($id)
    {
        $produk = ProdukKayu::findOrFail($id);

        // Hapus produk dari database
        $produk->delete();

        return back()->with('success', 'Produk berhasil dihapus');
    }

    // Menambah jumlah stok produk yang sudah ada
    public function tambahStok(Request $request)
    {
        // Validasi input penambahan stok
        $request->validate([
            'produk_kayu_id' => 'required|exists:produk_kayu,id',
            'jumlah'         => 'required|integer|min:1',
        ], [
            'produk_kayu_id.required' => 'Produk kayu wajib dipilih.',
            'jumlah.required'         => 'Jumlah stok wajib diisi.',
            'jumlah.min'              => 'Jumlah stok minimal 1.',
        ]);

        // Cari stok produk berdasarkan produk_kayu_id
        $stok = StokKayu::where('produk_kayu_id', $request->produk_kayu_id)->first();

        // Buat stok baru jika belum ada
        if (!$stok) {
            StokKayu::create([
                'produk_kayu_id' => $request->produk_kayu_id,
                'stok' => $request->jumlah,
            ]);
        } else {
            // Tambah jumlah stok yang sudah ada
            $stok->increment('stok', $request->jumlah);
        }

        return back()->with('success', 'Stok berhasil ditambahkan');
    }
}
