<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <!-- judul -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-black text-[#1F2937] italic uppercase tracking-tighter">
                    Data Jadwal <span class="text-slate-400 font-light">Kunjungan</span>
                </h1>
                <p class="text-sm text-slate-500 mt-1">Kelola dan tinjau semua permintaan jadwal pertemuan untuk memastikan kelancaran koordinasi operasional.</p>
            </div>
        </div>

        <!-- tabel kunjungan -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto" id="visits-table-wrapper">
                <!-- table kunjungan -->
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Klien</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Judul Kunjungan</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Waktu & Durasi</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($visits as $visit)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs mr-3">
                                        {{ substr($visit->client->name ?? 'C', 0, 1) }}
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">{{ $visit->client->name ?? 'Client' }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-600 font-medium">
                                {{ $visit->title }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-700">{{ \Carbon\Carbon::parse($visit->visit_date)->format('d M Y') }}</span>
                                    <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($visit->visit_date)->format('H:i') }} WIB</span>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($visit->status == 'approved')
                                <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-tighter bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-full">
                                    Approved
                                </span>
                                @elseif($visit->status == 'rejected')
                                <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-tighter bg-rose-50 text-rose-600 border border-rose-100 rounded-full">
                                    Rejected
                                </span>
                                @else
                                <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-tighter bg-amber-50 text-amber-600 border border-amber-100 rounded-full">
                                    Pending
                                </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if($visit->status == 'pending')
                                <div class="flex flex-col gap-2 ml-auto w-32">
                                    {{-- BUTTON APPROVE --}}
                                    <form action="{{ route('admin.kunjungan.approve', $visit->id) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-black py-2 rounded-lg shadow-sm transition transform hover:scale-[1.02] uppercase tracking-wider">
                                            APPROVE
                                        </button>
                                    </form>

                                    {{-- FORM REJECT --}}
                                    <form action="{{ route('admin.kunjungan.reject', $visit->id) }}" method="POST" class="flex flex-col gap-1.5 w-full">
                                        @csrf
                                        <input
                                            type="text"
                                            name="note"
                                            placeholder="Alasan..."
                                            required
                                            class="w-full bg-white border border-slate-200 text-[10px] text-slate-700 rounded-lg focus:ring-rose-500 focus:border-rose-500 block p-2 outline-none placeholder:text-slate-300">

                                        <button type="submit" class="w-full bg-white hover:bg-rose-50 text-rose-600 border border-rose-600 text-[10px] font-black py-2 rounded-lg shadow-sm transition transform hover:scale-[1.02] uppercase tracking-wider">
                                            REJECT
                                        </button>
                                    </form>
                                </div>
                                @else
                                <div class="text-center">
                                    <span class="text-[10px] font-bold text-slate-300 uppercase italic">No Action Needed</span>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        {{-- EMPTY  --}}
                        <tr>
                            <td colspan="5" class="py-20">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4 border border-slate-100">
                                        <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-slate-400 font-medium italic text-sm">Semua permintaan sudah diproses.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- pagination -->
                @if($visits->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 visits-pagination">
                    {{ $visits->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // pagination
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('visits-table-wrapper');
            const link = e.target.closest('#visits-table-wrapper .visits-pagination a');

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
                    const newWrapper = doc.getElementById('visits-table-wrapper');
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