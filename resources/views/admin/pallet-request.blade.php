<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <!-- Judul -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-[#1F2937] italic uppercase tracking-tighter">
                    Data Pengajuan <span class="text-slate-400 font-light">Palet</span>
                </h1>
                <p class="text-sm text-slate-500 mt-1">Manajemen persetujuan pengajuan palet dari klien secara real-time.</p>
            </div>
        </div>

        <!-- Notifikasi dari components -->
        <x-alert />

        <!-- tabel pallet request -->
        <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-100 border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto" id="requests-table-wrapper">
                <table class="w-full text-left border-collapse text-xs">
                    <!-- tabel judul -->
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-3 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] whitespace-nowrap text-center">Klien</th>
                            <th class="px-3 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] whitespace-nowrap">Detail Produk</th>
                            <th class="px-3 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] whitespace-nowrap">Desain</th>
                            <th class="px-3 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] whitespace-nowrap">Catatan</th>
                            <th class="px-3 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] whitespace-nowrap">Alamat Kirim</th>
                            <th class="px-3 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] whitespace-nowrap">Status</th>
                            <th class="px-3 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] whitespace-nowrap text-center">Aksi</th>
                            <th class="px-3 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] whitespace-nowrap">Keterangan</th>
                        </tr>
                    </thead>
                    <!-- tabel konten -->
                    <tbody class="divide-y divide-gray-50">
                        @forelse($requests as $req)
                        <!-- Baris 1 -->
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <!-- nama -->
                            <td class="px-3 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="h-7 w-7 flex-shrink-0 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-[10px] uppercase">
                                        {{ substr($req->client->name ?? 'C', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800 text-xs">{{ $req->client->name ?? 'Unknown' }}</div>
                                        <div class="text-[9px] text-gray-400 font-mono">ID-REQ-{{ $req->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <!-- qty / jumlah -->
                            <td class="px-3 py-4">
                                <div class="font-bold text-gray-700 text-xs">{{ $req->jenis_palet }}</div>
                                <div class="text-[10px] text-blue-600 font-black">{{ $req->qty }} <span class="text-[9px] text-gray-400 font-normal">PCS</span></div>
                            </td>
                            <!-- file desain -->
                            <td class="px-3 py-4">
                                @if($req->file_desain)
                                <a href="{{ asset('storage/' . $req->file_desain) }}" target="_blank"
                                    class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-bold hover:bg-blue-600 hover:text-white transition-all border border-blue-100">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View
                                </a>
                                @else
                                <span class="text-[9px] font-bold text-gray-300 italic">—</span>
                                @endif
                            </td>
                            <!-- catatan -->
                            <td class="px-3 py-4">
                                <div class="text-[11px] text-gray-600 max-w-[100px] truncate" title="{{ $req->catatan }}">
                                    {{ $req->catatan ?? '-' }}
                                </div>
                            </td>
                            <!-- alamat kirim -->
                            <td class="px-3 py-4">
                                <p class="text-[11px] text-gray-500 max-w-[110px] truncate" title="{{ $req->alamat_kirim }}">
                                    {{ $req->alamat_kirim }}
                                </p>
                            </td>
                            <!-- status -->
                            <td class="px-3 py-4">
                                @php
                                $statusClasses = [
                                'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                'disetujui' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                'ditolak' => 'bg-rose-100 text-rose-700 border-rose-200',
                                ];
                                @endphp
                                <span class="px-2 py-1 rounded-full border text-[9px] font-black uppercase tracking-tighter whitespace-nowrap {{ $statusClasses[$req->status] ?? 'bg-gray-100' }}">
                                    {{ $req->status }}
                                </span>
                            </td>
                            <!-- aksi -->
                            <td class="px-3 py-4">
                                <div class="flex justify-center">
                                    @if($req->status == 'pending')
                                    <div class="flex flex-col gap-1.5 w-32">
                                        <!-- tombol disetujui -->
                                        <form action="/admin/pallet-request/{{ $req->id }}/approve" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full uppercase bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold py-1.5 rounded-lg transition">
                                                Disetujui
                                            </button>
                                        </form>

                                        <!-- tombol ditolak -->
                                        <form action="/admin/pallet-request/{{ $req->id }}/reject" method="POST" class="flex flex-col gap-1">
                                            @csrf
                                            <input type="text" name="keterangan" placeholder="Alasan..."
                                                class="w-full border border-slate-200 text-[10px] rounded-lg p-1.5 outline-none placeholder:text-slate-300">
                                            <button type="submit" class="w-full bg-white hover:bg-rose-50 text-rose-600 border border-rose-400 text-[9px] font-black py-1.5 rounded-lg transition uppercase">
                                                Ditolak
                                            </button>
                                        </form>
                                    </div>
                                    @else
                                    <div class="flex flex-col items-center opacity-40">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-[8px] font-black uppercase tracking-widest mt-1 text-gray-400">Diproses</span>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <!-- keterangan jika ditolak -->
                            <td class="px-3 py-4">
                                @if($req->status == 'ditolak' && $req->keterangan)
                                <p class="text-[10px] text-slate-500 italic max-w-[120px]" title="{{ $req->keterangan }}">
                                    "{{ $req->keterangan }}"
                                </p>
                                @else
                                <span class="text-[10px] text-gray-300 italic">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <!-- Baris 2: tampilan jika data kosong -->
                        <tr>
                            <td colspan="8" class="px-3 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <span class="text-gray-400 mt-2 text-sm italic font-medium">Semua permintaan sudah diproses.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- pagination -->
                @if($requests->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 requests-pagination">
                    {{ $requests->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Pagination AJAX tanpa refresh halaman untuk tabel pengajuan palet
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('requests-table-wrapper');
            const link = e.target.closest('#requests-table-wrapper .requests-pagination a');

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
                    const newWrapper = doc.getElementById('requests-table-wrapper');
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
