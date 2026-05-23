<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProdukKayu;
use App\Models\StokKayu;

class StokKayuController extends Controller
{
    public function index()
    {
        $stocks = ProdukKayu::with('stok')
            ->latest()
            ->paginate(6);

        return view('admin.stok', compact('stocks'));
    }

    public function store(Request $request)
    {
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

        // upload gambar
        $gambar = null;

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')
                ->store('produk-kayu', 'public');
        }

        // simpan produk
        $produk = ProdukKayu::create([
            'nama_produk' => $request->nama_produk,
            'gambar' => $gambar,
            'satuan' => 'PCS',
            'keterangan' => $request->keterangan,
        ]);

        // simpan stok
        StokKayu::create([
            'produk_kayu_id' => $produk->id,
            'stok' => $request->stok,
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $produk = ProdukKayu::with('stok')
            ->findOrFail($id);

        // update gambar baru
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')
                ->store('produk-kayu', 'public');

            $produk->gambar = $gambar;
        }

        // update produk
        $produk->update([
            'nama_produk' => $request->nama_produk,
            'keterangan' => $request->keterangan,
        ]);

        // update stok
        if ($produk->stok) {
            $produk->stok->update([
                'stok' => $request->stok
            ]);
        }

        return back()->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        $produk = ProdukKayu::findOrFail($id);

        $produk->delete();

        return back()->with('success', 'Produk berhasil dihapus');
    }

    // TAMBAH STOK
    public function tambahStok(Request $request)
    {
        $request->validate([
            'produk_kayu_id' => 'required|exists:produk_kayu,id',
            'jumlah'         => 'required|integer|min:1',
        ], [
            'produk_kayu_id.required' => 'Produk kayu wajib dipilih.',
            'jumlah.required'         => 'Jumlah stok wajib diisi.',
            'jumlah.min'              => 'Jumlah stok minimal 1.',
        ]);

        $stok = StokKayu::where('produk_kayu_id', $request->produk_kayu_id)
            ->first();

        // kalau stok belum ada
        if (!$stok) {
            StokKayu::create([
                'produk_kayu_id' => $request->produk_kayu_id,
                'stok' => $request->jumlah,
            ]);
        } else {

            // tambah stok lama
            $stok->increment('stok', $request->jumlah);
        }

        return back()->with('success', 'Stok berhasil ditambahkan');
    }
}
