<x-app-layout>

    <div class="max-w-7xl mx-auto py-10 px-6">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-black text-[#1F2937] italic uppercase tracking-tighter">
                    Data <span class="text-slate-400 font-light">Produk</span>
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola dan pantau ketersediaan volume bahan baku material produk.
                </p>
            </div>
        </div>

        <!-- ALERT -->
        @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl text-sm font-semibold">
            {{ session('success') }}
        </div>
        @endif

        <!-- FORM TAMBAH PRODUK -->
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm mb-10 overflow-hidden">

            <div class="px-8 py-6 border-b border-slate-100">
                <h2 class="text-xl font-black italic uppercase tracking-tight text-slate-800">
                    Tambah Produk Baru
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    Tambahkan jenis kayu baru beserta stok awal produk.
                </p>
            </div>

            <div class="p-8">

                <form action="{{ route('admin.stok.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    @csrf

                    <!-- nama produk -->
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                            Nama Produk
                        </label>

                        <input type="text"
                            name="nama_produk"
                            class="w-full rounded-2xl border-slate-200 py-3 px-4 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Contoh: Kayu Jati"
                            required>
                    </div>

                    <!-- stok -->
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                            Stok Awal
                        </label>

                        <input type="number"
                            name="stok"
                            class="w-full rounded-2xl border-slate-200 py-3 px-4 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="0"
                            required>
                    </div>

                    <!-- gambar -->
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                            Gambar Produk
                        </label>

                        <input type="file"
                            name="gambar"
                            class="w-full rounded-2xl border-slate-200 py-3 px-4">
                    </div>

                    <!-- keterangan -->
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                            Keterangan
                        </label>

                        <textarea name="keterangan"
                            rows="3"
                            class="w-full rounded-2xl border-slate-200 py-3 px-4 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Keterangan tambahan..."></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <button class="px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black uppercase tracking-widest transition-all">
                            Tambah Produk
                        </button>
                    </div>

                </form>

            </div>
        </div>

        <!-- TABEL PRODUK -->
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">

            <div class="px-8 py-6 border-b border-slate-100">
                <h2 class="text-xl font-black italic uppercase tracking-tight text-slate-800">
                    Data Produk Kayu
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    Daftar seluruh produk beserta stok yang tersedia.
                </p>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full border-collapse">

                    <thead>
                        <tr class="bg-slate-50">

                            <th class="px-6 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">
                                Produk
                            </th>

                            <th class="px-6 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">
                                Stok
                            </th>

                            <th class="px-6 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">
                                Aksi
                            </th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($stocks as $item)

                        <tr class="hover:bg-slate-50/50 transition-all">

                            <!-- PRODUK -->
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-4">

                                    <div class="w-16 h-16 rounded-2xl overflow-hidden bg-slate-100 border border-slate-100">

                                        @if($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}"
                                            class="w-full h-full object-cover">
                                        @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300 text-xs font-bold">
                                            NO IMG
                                        </div>
                                        @endif

                                    </div>

                                    <div>

                                        <h3 class="text-sm font-black uppercase italic tracking-tight text-slate-800">
                                            {{ $item->nama_produk }}
                                        </h3>

                                        <p class="text-xs text-slate-400 mt-1">
                                            {{ $item->keterangan ?? '-' }}
                                        </p>

                                    </div>

                                </div>

                            </td>

                            <!-- STOK -->
                            <td class="px-6 py-5">

                                <p class="text-lg font-black text-slate-800">
                                    {{ $item->stok->stok ?? 0 }}
                                    <span class="text-xs text-slate-400 uppercase">
                                        PCS
                                    </span>
                                </p>

                            </td>

                            <!-- STATUS -->
                            <td class="px-6 py-5">

                                @if(($item->stok->stok ?? 0) > 0)

                                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-widest border border-emerald-200">
                                    Tersedia
                                </span>

                                @else

                                <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-700 text-[10px] font-black uppercase tracking-widest border border-rose-200">
                                    Habis
                                </span>

                                @endif

                            </td>

                            <!-- AKSI -->
                            <td class="px-6 py-5 text-right">

                                <div class="flex justify-end gap-2">

                                    <!-- EDIT -->
                                    <button
                                        onclick="document.getElementById('editModal{{ $item->id }}').classList.remove('hidden')"
                                        class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-[10px] font-black uppercase tracking-widest transition-all">
                                        Edit
                                    </button>

                                    <!-- DELETE -->
                                    <form action="{{ route('admin.stok.destroy', $item->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            onclick="return confirm('Hapus produk ini?')"
                                            class="px-4 py-2 rounded-xl bg-rose-500 hover:bg-rose-600 text-white text-[10px] font-black uppercase tracking-widest transition-all">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        <!-- MODAL EDIT -->
                        <div id="editModal{{ $item->id }}"
                            class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">

                            <div class="bg-white rounded-[2rem] w-full max-w-lg p-8">

                                <h2 class="text-2xl font-black italic uppercase tracking-tight mb-6">
                                    Edit Produk
                                </h2>

                                <form action="{{ route('admin.stok.update', $item->id) }}"
                                    method="POST"
                                    enctype="multipart/form-data">

                                    @csrf
                                    @method('PUT')

                                    <div class="space-y-5">

                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                                                Nama Produk
                                            </label>

                                            <input type="text"
                                                name="nama_produk"
                                                value="{{ $item->nama_produk }}"
                                                class="w-full rounded-2xl border-slate-200 py-3 px-4">
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                                                Stok
                                            </label>

                                            <input type="number"
                                                name="stok"
                                                value="{{ $item->stok->stok ?? 0 }}"
                                                class="w-full rounded-2xl border-slate-200 py-3 px-4">
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                                                Gambar Baru
                                            </label>

                                            <input type="file"
                                                name="gambar"
                                                class="w-full rounded-2xl border-slate-200 py-3 px-4">
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                                                Keterangan
                                            </label>

                                            <textarea name="keterangan"
                                                rows="3"
                                                class="w-full rounded-2xl border-slate-200 py-3 px-4">{{ $item->keterangan }}</textarea>
                                        </div>

                                    </div>

                                    <div class="flex gap-3 mt-8">

                                        <button type="submit"
                                            class="flex-1 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black uppercase tracking-widest">
                                            Update
                                        </button>

                                        <button type="button"
                                            onclick="document.getElementById('editModal{{ $item->id }}').classList.add('hidden')"
                                            class="flex-1 py-3 rounded-2xl bg-slate-200 hover:bg-slate-300 text-xs font-black uppercase tracking-widest">
                                            Batal
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                        @empty

                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-sm text-slate-400 font-medium">
                                Belum ada data produk kayu.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        <!-- FORM TAMBAH STOK -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 mb-8 mt-8">

            <h2 class="text-xl font-black italic uppercase text-slate-800 mb-6">
                Tambah <span class="text-slate-400 font-light">Stok</span>
            </h2>

            <form action="{{ route('admin.stok.tambah') }}" method="POST"
                class="grid md:grid-cols-3 gap-4">

                @csrf

                <!-- pilih produk -->
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        Produk Kayu
                    </label>

                    <select name="produk_kayu_id"
                        class="w-full rounded-xl border-slate-200 text-sm py-3 px-4"
                        required>

                        <option value="">Pilih Produk</option>

                        @foreach($stocks as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->nama_produk }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- jumlah -->
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        Jumlah Stok
                    </label>

                    <input type="number"
                        name="jumlah"
                        min="1"
                        class="w-full rounded-xl border-slate-200 text-sm py-3 px-4"
                        placeholder="Masukkan jumlah"
                        required>
                </div>

                <!-- tombol -->
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-3 rounded-xl transition">

                        Tambah Stok
                    </button>
                </div>

            </form>
        </div>
    </div>

</x-app-layout>