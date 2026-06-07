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

        <!-- Notifikasi dari components -->
        <x-alert />

        <!-- tabel kunjungan -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto" id="visits-table-wrapper">
                <!-- table kunjungan -->
                <table class="w-full text-left border-collapse">
                    <!-- tabel judul -->
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Klien</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Judul Kunjungan</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Waktu & Durasi</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Keterangan</th>
                        </tr>
                    </thead>
                    <!-- tabel konten -->
                    <tbody class="divide-y divide-slate-50">
                        @forelse($kunjungan as $item)
                        <!-- Baris 1 -->
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <!-- nama -->
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs mr-3">
                                        {{ substr($item->client->name ?? 'C', 0, 1) }}
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">{{ $item->client->name ?? 'Client' }}</span>
                                </div>
                            </td>
                            <!-- judul -->
                            <td class="px-6 py-4 text-sm text-slate-600 font-medium">
                                {{ $item->judul }}
                            </td>
                            <!-- waktu kunjungan -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-700">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}</span>
                                    <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('H:i') }} WIB</span>
                                </div>
                            </td>
                            <!-- status -->
                            <td class="px-6 py-4 text-center">
                                @if($item->status == 'disetujui')
                                <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-tighter bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-full">
                                    Disetujui
                                </span>
                                @elseif($item->status == 'ditolak')
                                <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-tighter bg-rose-50 text-rose-600 border border-rose-100 rounded-full">
                                    Ditolak
                                </span>
                                @else
                                <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-tighter bg-amber-50 text-amber-600 border border-amber-100 rounded-full">
                                    Pending
                                </span>
                                @endif
                            </td>
                            <!-- aksi -->
                            <td class="px-6 py-4">
                                @if($item->status == 'pending')
                                <div class="flex flex-col gap-2 ml-auto w-32">
                                    <!-- tombol disetujui -->
                                    <form action="{{ route('admin.kunjungan.approve', $item->id) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-black py-2 rounded-lg shadow-sm transition transform hover:scale-[1.02] uppercase tracking-wider">
                                            Disetujui
                                        </button>
                                    </form>

                                    <!-- tombol ditolak -->
                                    <form action="{{ route('admin.kunjungan.reject', $item->id) }}" method="POST" class="flex flex-col gap-1.5 w-full">
                                        @csrf
                                        <input
                                            type="text"
                                            name="keterangan"
                                            placeholder="Alasan..."
                                            required
                                            class="w-full bg-white border border-slate-200 text-[10px] text-slate-700 rounded-lg focus:ring-rose-500 focus:border-rose-500 block p-2 outline-none placeholder:text-slate-300">
                                        <button type="submit" class="w-full bg-white hover:bg-rose-50 text-rose-600 border border-rose-600 text-[10px] font-black py-2 rounded-lg shadow-sm transition transform hover:scale-[1.02] uppercase tracking-wider">
                                            Ditolak
                                        </button>
                                    </form>
                                </div>
                                @else
                                <div class="text-center">
                                    <span class="text-[10px] font-bold text-slate-300 uppercase italic">Selesai</span>
                                </div>
                                @endif
                            </td>
                            <!-- keterangan jika ditolak -->
                            <td class="px-3 py-4">
                                @if($item->status == 'ditolak' && $item->keterangan)
                                <p class="text-[10px] text-slate-500 italic max-w-[120px]" title="{{ $item->keterangan }}">
                                    "{{ $item->keterangan }}"
                                </p>
                                @else
                                <span class="text-[10px] text-gray-300 italic">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <!-- Baris 2: tampilan jika data kosong -->
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
                @if($kunjungan->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 visits-pagination">
                    {{ $kunjungan->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Pagination AJAX tanpa refresh halaman untuk tabel kunjungan admin
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('visits-table-wrapper');
            const link = e.target.closest('#visits-table-wrapper .visits-pagination a');

            // Abaikan klik jika bukan tombol pagination
            if (!link) return;

            e.preventDefault();

            // Nonaktifkan tabel saat memuat data baru
            wrapper.style.opacity = '0.5';
            wrapper.style.pointerEvents = 'none';

            // Ambil konten halaman berikutnya via AJAX
            fetch(link.href, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => r.text())
                .then(html => {
                    // Parse HTML response dan ambil wrapper baru
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newWrapper = doc.getElementById('visits-table-wrapper');
                    // Update konten tabel dengan data baru
                    if (newWrapper) wrapper.innerHTML = newWrapper.innerHTML;
                    // Update URL tanpa refresh halaman
                    history.pushState({}, '', link.href);
                    // Aktifkan kembali tabel setelah selesai
                    wrapper.style.opacity = '1';
                    wrapper.style.pointerEvents = 'auto';
                })
                .catch(() => {
                    // Aktifkan kembali tabel jika terjadi error
                    wrapper.style.opacity = '1';
                    wrapper.style.pointerEvents = 'auto';
                });
        });
    </script>
</x-app-layout>
