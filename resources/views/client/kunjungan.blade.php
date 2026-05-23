<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        {{-- HEADER HALAMAN --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 space-y-4 md:space-y-0">
            <div>
                <h1 class="text-3xl font-black text-[#1F2937] italic uppercase tracking-tighter">
                    Jadwal <span class="text-slate-400 font-light">Kunjungan</span>
                </h1>
                <p class="text-sm text-slate-500 mt-1">Atur agenda kunjungan ke PT. Menara Bekasi Lestari dengan mudah.</p>
            </div>
        </div>

        {{-- Notifikasi dari components --}}
        <x-alert />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- ==================== FORM PENGAJUAN (KIRI) ==================== --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center">
                        <span class="bg-blue-100 text-blue-600 w-8 h-8 rounded-lg flex items-center justify-center mr-3 text-sm">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </span>
                        Buat Jadwal Baru
                    </h3>

                    <form action="{{ route('client.kunjungan.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Judul Kunjungan</label>
                            <input type="text" name="judul"
                                class="w-full rounded-xl border-gray-200 py-3 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                placeholder="Contoh: Peninjauan Palet">
                            @error('judul')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Waktu Kunjungan</label>
                            <input type="datetime-local" name="tanggal_kunjungan"
                                class="w-full rounded-xl border-gray-200 py-3 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            @error('tanggal_kunjungan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-emerald-200 transition-all active:scale-95 uppercase tracking-widest text-sm flex items-center justify-center">
                            Ajukan Kunjungan
                        </button>
                    </form>
                </div>
            </div>

            {{-- ==================== RIWAYAT KUNJUNGAN (KANAN) ==================== --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-bold text-gray-800">Daftar Agenda Kunjungan</h3>
                    </div>

                    <div id="visits-wrapper">
                        <div class="divide-y divide-gray-100">
                            @forelse($kunjungan as $item)
                            <div class="p-6 hover:bg-gray-50 transition-colors flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex items-start space-x-4">
                                    <div class="bg-emerald-50 text-emerald-600 p-3 rounded-xl">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900">{{ $item->judul }}</h4>
                                        <div class="flex items-center text-sm text-gray-500 mt-1">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y - H:i') }} WIB
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col items-start gap-1">

                                    @if($item->status == 'pending')
                                    <span class="px-3 py-1 text-xs font-black uppercase tracking-widest bg-amber-100 text-amber-700 rounded-full border border-amber-200">
                                        Pending
                                    </span>

                                    @elseif($item->status == 'disetujui')
                                    <span class="px-3 py-1 text-xs font-black uppercase tracking-widest bg-emerald-100 text-emerald-700 rounded-full border border-emerald-200">
                                        Disetujui
                                    </span>

                                    @elseif($item->status == 'ditolak')
                                    <span class="px-3 py-1 text-xs font-black uppercase tracking-widest bg-rose-100 text-rose-700 rounded-full border border-rose-200">
                                        Ditolak
                                    </span>

                                    @if($item->keterangan)
                                    <span class="text-[10px] text-rose-500 font-medium italic">
                                        Alasan: {{ $item->keterangan }}
                                    </span>
                                    @endif

                                    @endif

                                </div>
                            </div>
                            @empty
                            <div class="p-12 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4 text-gray-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="text-gray-500 font-medium">Belum ada jadwal kunjungan yang diajukan.</p>
                            </div>
                            @endforelse
                        </div>

                        {{-- pagination --}}
                        @if($kunjungan->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100 visits-pagination">
                            {{ $kunjungan->links() }}
                        </div>
                        @endif
                    </div>{{-- end visits-wrapper --}}

                </div>
            </div>
        </div>
    </div>

    <script>
        // pagination
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('visits-wrapper');
            const link = e.target.closest('#visits-wrapper .visits-pagination a');

            if (!link) return;

            e.preventDefault();
            wrapper.style.opacity = '0.5';
            wrapper.style.pointerEvents = 'none';

            fetch(link.href, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => r.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newWrapper = doc.getElementById('visits-wrapper');
                    if (newWrapper) wrapper.innerHTML = newWrapper.innerHTML;
                    history.pushState({}, '', link.href);
                    wrapper.style.opacity = '1';
                    wrapper.style.pointerEvents = 'auto';
                })
                .catch(() => {
                    wrapper.style.opacity = '1';
                    wrapper.style.pointerEvents = 'auto';
                });
        });
    </script>
</x-app-layout>