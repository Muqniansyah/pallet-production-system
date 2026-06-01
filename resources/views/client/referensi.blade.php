<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-6">
        <!-- judul -->
        <div class="mb-10">
            <h1 class="text-3xl font-black text-[#1F2937] italic uppercase tracking-tighter">
                Referensi <span class="text-slate-400 font-light">Produk</span>
            </h1>
            <p class="text-slate-500 mt-1 text-sm">
                Katalog standar palet kayu kualitas ekspor PT. Menara Bekasi Lestari
            </p>
        </div>

        <!-- list produk -->
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($stocks as $item)
            <!-- produk -->
            <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm">
                <!-- gambar -->
                <div class="h-52 bg-slate-100">
                    @if($item->gambar)
                    <img src="{{ asset('storage/' . $item->gambar) }}"
                        class="w-full h-full object-cover">
                    @endif
                </div>

                <!-- konten produk -->
                <div class="p-6">
                    <!-- nama produk -->
                    <h2 class="text-xl font-black uppercase italic tracking-tight">
                        {{ $item->nama_produk }}
                    </h2>
                    <!-- keterangan produk -->
                    <p class="text-xs text-slate-500 leading-relaxed font-normal mt-0.5">
                        {{ $item->keterangan }}
                    </p>
                    <!-- jumlah stok & status -->
                    <div class="mt-4 flex justify-between items-center">
                        <!-- jumlah stok -->
                        <div>
                            <p class="text-xs uppercase text-slate-400 font-black">Stok</p>
                            <p class="text-2xl font-black">
                                {{ $item->stok->stok ?? 0 }}
                                PCS
                            </p>
                        </div>

                        <!-- status stok produk -->
                        @if(($item->stok->stok ?? 0) > 0)
                        <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-700">
                            Tersedia
                        </span>
                        @else
                        <span class="px-3 py-1 rounded-full text-xs font-black bg-rose-100 text-rose-700">
                            Habis
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>