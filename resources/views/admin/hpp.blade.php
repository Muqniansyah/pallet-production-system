<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-3xl font-black text-[#1F2937] italic uppercase tracking-tighter">
                Data HPP & <span class="text-slate-400 font-light">Management Pesanan</span>
            </h1>
            <p class="text-slate-500 mt-1">Kelola pembuatan pesanan dan unggah dokumen Harga Pokok Produksi (HPP) dalam satu tempat.</p>
        </div>

        {{-- NOTIFIKASI --}}
        @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 p-3 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-lg">
            {{ session('error') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- ==================== BUAT ORDER / PESANAN ==================== --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center">
                        <span class="bg-blue-100 text-blue-600 w-8 h-8 rounded-lg flex items-center justify-center mr-3 text-sm">1</span>
                        Buat Pesanan
                    </h3>

                    <form action="{{ route('admin.orders.store') }}" method="POST" class="space-y-5">
                        @csrf

                        {{-- PILIH REQUEST PALET --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2">Pilih Pengajuan Palet</label>
                            <select id="requestSelect" name="pallet_request_id" required class="w-full rounded-xl border-gray-200 py-3">

                                <option value="" disabled selected>Pilih Pengajuan...</option>

                                @foreach($requests as $req)
                                <option value="{{ $req->id }}" data-qty="{{ $req->qty }}">
                                    {{ $req->client->name }} - {{ $req->jenis_palet }} ({{ $req->qty }})
                                </option>
                                @endforeach

                            </select>
                        </div>

                        {{-- NAMA PROJECT --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2">Nama Project</label>
                            <input type="text" name="nama_project" required
                                class="w-full rounded-xl border-gray-200 py-3"
                                placeholder="Contoh: Pallet Gudang Bekasi">
                        </div>

                        {{-- QTY --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2">Jumlah (Qty)</label>
                            <input id="qtyInput" type="number" readonly
                                class="w-full rounded-xl border-gray-200 py-3"
                                placeholder="Masukkan jumlah pallet">
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl">
                            Buat Pesanan
                        </button>
                    </form>
                </div>
            </div>

            {{-- ==================== UPLOAD + TABLE ==================== --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- ==================== UPLOAD HPP ==================== --}}
                <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-2xl border border-blue-100 p-6">
                    <h3 class="text-lg font-bold text-indigo-900 mb-4 flex items-center">
                        <span class="bg-indigo-200 text-indigo-700 w-8 h-8 rounded-lg flex items-center justify-center mr-3 text-sm">2</span>
                        Upload Dokumen HPP
                    </h3>

                    <form action="{{ route('admin.hpp.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- pilih order / pesanan --}}
                        <div class="mb-4">
                            <label class="text-xs font-bold text-gray-500 uppercase">
                                Pilih Pesanan (Status Deal) 'Nama Klien - Nama Project'
                            </label>

                            <select name="order_id" required class="w-full mt-2 rounded-xl border-gray-200">
                                <option value="" disabled selected>Pilih Order...</option>

                                @foreach($orders as $order)
                                <option value="{{ $order->id }}">
                                    {{ $order->client->name }} - {{ $order->nama_project }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Upload Section --}}
                        <div class="relative group">
                            <input name="file_hpp" type="file" id="hppFileInput"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" required>

                            <div id="hppDropzone" class="border-2 border-dashed border-slate-200 rounded-[2rem] p-10 text-center transition-all bg-white">
                                <div id="hppIcon" class="mb-3 flex justify-center text-slate-300">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>

                                <div id="hppContent">
                                    <p id="hppPrimaryText" class="text-xs font-black text-slate-600 uppercase italic tracking-tight">
                                        Klik untuk upload file HPP
                                    </p>
                                    <p id="hppSecondaryText" class="text-[10px] text-slate-400 mt-1">
                                        PDF atau Excel (Maks. 5MB)
                                    </p>
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                            class="mt-6 w-full bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black py-3 rounded-xl shadow-lg shadow-indigo-100 transition transform hover:scale-[1.02] uppercase tracking-widest">
                            Upload HPP
                        </button>
                    </form>
                </div>

                {{-- ==================== TABLE ==================== --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-800">Riwayat Data HPP</h3>
                    </div>

                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold">
                            <tr>
                                <th class="px-6 py-4">Klien</th>
                                <th class="px-6 py-4">File HPP</th>
                                <th class="px-6 py-4 text-right">Tanggal</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($hpps as $hpp)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $hpp->order->client->name }}
                                </td>

                                <td class="px-6 py-4">
                                    <a href="{{ asset('storage/' . $hpp->file_hpp) }}"
                                        target="_blank"
                                        class="text-blue-600 hover:underline font-semibold">
                                        Download HPP
                                    </a>
                                </td>

                                <td class="px-6 py-4 text-right text-gray-400">
                                    {{ $hpp->created_at->format('d M Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-6 text-gray-400">
                                    Belum ada data HPP
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script>
        // script order
        const select = document.getElementById('requestSelect');
        const qtyInput = document.getElementById('qtyInput');

        select.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const qty = selectedOption.getAttribute('data-qty');

            qtyInput.value = qty;
        });

        // script upload hpp
        const hppFileInput = document.getElementById('hppFileInput');
        const hppDropzone = document.getElementById('hppDropzone');
        const hppIcon = document.getElementById('hppIcon');
        const hppPrimaryText = document.getElementById('hppPrimaryText');
        const hppSecondaryText = document.getElementById('hppSecondaryText');

        hppFileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                const fileName = this.files[0].name;

                // Ubah Tampilan Menjadi "Active/Success"
                hppDropzone.classList.remove('border-slate-200');
                hppDropzone.classList.add('border-indigo-500', 'bg-indigo-50/50');

                hppIcon.classList.remove('text-slate-300');
                hppIcon.classList.add('text-indigo-600');

                // Tampilkan Nama File yang dipilih
                hppPrimaryText.innerHTML = `<span class="text-indigo-600">FILE TERPILIH:</span>`;
                hppSecondaryText.innerHTML = `<span class="text-slate-800 font-bold text-sm">${fileName}</span>`;
            } else {
                // Reset Jika Batal
                hppDropzone.classList.add('border-slate-200');
                hppDropzone.classList.remove('border-indigo-500', 'bg-indigo-50/50');

                hppIcon.classList.add('text-slate-300');
                hppIcon.classList.remove('text-indigo-600');

                hppPrimaryText.innerText = "Klik untuk upload file HPP";
                hppSecondaryText.innerText = "PDF atau Excel (Maks. 5MB)";
            }
        });
    </script>
</x-app-layout>