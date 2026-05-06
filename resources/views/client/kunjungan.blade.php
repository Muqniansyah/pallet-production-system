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

        @if(session('error'))
        <div class="bg-red-100 text-red-600 text-sm p-2 rounded mb-3">
            {{ session('error') }}
        </div>
        @endif

        @if(session('success'))
        <div class="bg-emerald-100 text-emerald-700 text-sm p-3 rounded-xl mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- ==================== FORM PENGAJUAN (KIRI) ==================== --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center">
                        <span class="bg-blue-100 text-blue-600 w-8 h-8 rounded-lg flex items-center justify-center mr-3 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </span>
                        Buat Jadwal Baru
                    </h3>

                    <form action="{{ route('client.kunjungan.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Judul Kunjungan</label>
                            <input type="text" name="title" required
                                class="w-full rounded-xl border-gray-200 py-3 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                placeholder="Contoh: Peninjauan Palet">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Waktu Kunjungan</label>
                            <input type="datetime-local" name="visit_date" required
                                class="w-full rounded-xl border-gray-200 py-3 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-100 transition transform hover:scale-[1.02] flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
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
                            @forelse($visits as $visit)
                            <div class="p-6 hover:bg-gray-50 transition-colors flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex items-start space-x-4">
                                    <div class="bg-blue-50 text-blue-600 p-3 rounded-xl">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900">{{ $visit->title }}</h4>
                                        <div class="flex items-center text-sm text-gray-500 mt-1">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($visit->visit_date)->format('d M Y - H:i') }} WIB
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col items-start gap-1">

                                    @if($visit->status == 'pending')
                                    <span class="px-3 py-1 text-xs font-black uppercase tracking-widest bg-amber-100 text-amber-700 rounded-full border border-amber-200">
                                        Pending
                                    </span>

                                    @elseif($visit->status == 'approved')
                                    <span class="px-3 py-1 text-xs font-black uppercase tracking-widest bg-emerald-100 text-emerald-700 rounded-full border border-emerald-200">
                                        Approved
                                    </span>

                                    @elseif($visit->status == 'rejected')
                                    <span class="px-3 py-1 text-xs font-black uppercase tracking-widest bg-rose-100 text-rose-700 rounded-full border border-rose-200">
                                        Rejected
                                    </span>

                                    @if($visit->note)
                                    <span class="text-[10px] text-rose-500 font-medium italic">
                                        Alasan: {{ $visit->note }}
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
                        @if($visits->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100 visits-pagination">
                            {{ $visits->links() }}
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