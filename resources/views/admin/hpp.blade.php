<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">Data HPP & Management Order</h1>
            <p class="text-gray-500 mt-1">
                Kelola pembuatan order dan unggah dokumen Harga Pokok Produksi (HPP) dalam satu tempat.
            </p>
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

            {{-- ==================== BUAT ORDER ==================== --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center">
                        <span class="bg-blue-100 text-blue-600 w-8 h-8 rounded-lg flex items-center justify-center mr-3 text-sm">1</span>
                        Buat Order
                    </h3>

                    <form action="{{ route('admin.orders.store') }}" method="POST" class="space-y-5">
                        @csrf

                        {{-- PILIH REQUEST PALET --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2">Pilih Request Palet</label>
                            <select name="pallet_request_id" required class="w-full rounded-xl border-gray-200 py-3">

                                <option value="" disabled selected>Pilih Request...</option>

                                @foreach($requests as $req)
                                <option value="{{ $req->id }}">
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
                            <input type="number" name="qty" required
                                class="w-full rounded-xl border-gray-200 py-3"
                                placeholder="Masukkan jumlah pallet">
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl">
                            Buat Order
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

                        {{-- pilih order --}}
                        <div class="mb-4">
                            <label class="text-xs font-bold text-gray-500 uppercase">
                                Pilih Order (Status Deal)
                            </label>

                            <select name="order_id" required class="w-full mt-2 rounded-xl border-gray-200">
                                @foreach($orders->where('status', 'deal') as $order)
                                <option value="{{ $order->id }}">
                                    {{ $order->client->name }} - {{ $order->nama_project }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- upload --}}
                        <div class="relative group">
                            <input name="file_hpp" type="file"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required>

                            <div class="border-2 border-dashed border-indigo-300 rounded-xl p-8 text-center">
                                <p class="text-sm font-semibold text-indigo-600">
                                    Klik untuk upload file HPP
                                </p>
                                <p class="text-xs text-indigo-400 mt-1">
                                    PDF atau Excel (Maks. 5MB)
                                </p>
                            </div>
                        </div>

                        <button type="submit"
                            class="mt-4 w-full bg-indigo-600 text-white py-2 rounded-lg">
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
                                <th class="px-6 py-4">Client</th>
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
</x-app-layout>