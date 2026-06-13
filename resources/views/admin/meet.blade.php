<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <!-- Judul -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-black text-[#1F2937] italic uppercase tracking-tighter">
                    Data Jadwal <span class="text-slate-400 font-light">Meeting</span>
                </h1>
                <p class="text-sm text-slate-500 mt-1">Kelola dan tinjau semua permintaan meeting dari klien.</p>
            </div>
        </div>

        <!-- Notifikasi dari components -->
        <x-alert />

        <!-- tabel meet -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <!-- tabel judul -->
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 border-b">Klien</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 border-b">Judul Meeting</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 border-b">Deskripsi</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 border-b">Waktu & Durasi</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 border-b text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 border-b text-center">Aksi</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 border-b">Keterangan</th>
                    </tr>
                </thead>

                <!-- tabel konten -->
                <tbody class="divide-y divide-gray-100">
                    @forelse($meetings as $meeting)
                    <!-- Baris 1 -->
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <!-- nama -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs uppercase">
                                    {{ substr($meeting->user->name ?? 'C', 0, 1) }}
                                </div>
                                <span class="ml-3 font-semibold text-gray-700">{{ $meeting->user->name ?? '-' }}</span>
                            </div>
                        </td>
                        <!-- judul -->
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $meeting->judul }}
                        </td>
                        <!-- deskripsi -->
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $meeting->deskripsi }}
                        </td>
                        <!-- waktu & durasi -->
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <div class="font-semibold">{{ \Carbon\Carbon::parse($meeting->start_time)->format('d M, Y') }}</div>
                            <div class="text-gray-400 text-xs mt-1">
                                <span class="bg-gray-100 px-2 py-0.5 rounded italic">{{ $meeting->durasi }} Menit</span>
                            </div>
                        </td>
                        <!-- status -->
                        <td class="px-6 py-4 text-center">
                            @php
                            $statusStyles = [
                            'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                            'disetujui' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            'ditolak' => 'bg-rose-100 text-rose-700 border-rose-200',
                            ][$meeting->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusStyles }}">
                                {{ strtoupper($meeting->status) }}
                            </span>
                        </td>
                        <!-- aksi -->
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                @if($meeting->status === 'pending')
                                <div class="flex flex-col gap-4 w-full max-w-md">
                                    <!-- tombol disetujui -->
                                    <form action="/admin/meeting/{{ $meeting->id }}/approve" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full uppercase bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2.5 rounded-lg shadow-sm transition transform hover:scale-[1.02]">
                                            Disetujui
                                        </button>
                                    </form>

                                    <!-- tombol ditolak -->
                                    <form action="/admin/meeting/{{ $meeting->id }}/reject" method="POST" class="flex flex-col gap-2 w-full">
                                        @csrf
                                        <div class="relative w-full">
                                            <input
                                                type="text"
                                                name="keterangan"
                                                placeholder="Alasan penolakan..."
                                                class="w-full bg-white border border-slate-200 text-slate-700 text-xs rounded-lg focus:ring-rose-500 focus:border-rose-500 block p-2.5 transition-all duration-200 outline-none placeholder:text-slate-400">
                                        </div>
                                        <button type="submit" class="w-full bg-white hover:bg-rose-50 text-rose-600 border border-rose-600 text-[10px] font-black py-2.5 rounded-lg shadow-sm transition transform hover:scale-[1.02] uppercase tracking-wider">
                                            Ditolak
                                        </button>
                                    </form>
                                </div>
                                @else
                                @if($meeting->start_url)
                                <!-- keterangan setelah disetujui -->
                                <div class="flex flex-col items-center gap-2">
                                    <!-- tombol meet -->
                                    <a href="{{ $meeting->start_url }}" target="_blank"
                                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded shadow-sm transition">
                                        Start Meeting
                                    </a>

                                    <!-- tombol hapus -->
                                    <form action="{{ route('admin.meeting.destroy', $meeting->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-2 py-1 text-[8px] font-black rounded-lg bg-rose-50 text-rose-400 border border-rose-200 hover:bg-rose-100 uppercase tracking-wider transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                                @else
                                <!-- keterangan setelah ditolak -->
                                <div class="flex flex-col items-center gap-2">
                                    <!-- keterangan selesai -->
                                    <span class="text-xs text-gray-400 italic font-medium">Selesai</span>

                                    <!-- tombol hapus -->
                                    <form action="{{ route('admin.meeting.destroy', $meeting->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-2 py-1 text-[8px] font-black rounded-lg bg-rose-50 text-rose-400 border border-rose-200 hover:bg-rose-100 uppercase tracking-wider transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                                @endif
                                @endif
                            </div>
                        </td>
                        <!-- keterangan jika ditolak -->
                        <td class="px-3 py-4">
                            @if($meeting->status == 'ditolak' && $meeting->keterangan)
                            <p class="text-[10px] text-slate-500 italic max-w-[120px]" title="{{ $meeting->keterangan }}">
                                "{{ $meeting->keterangan }}"
                            </p>
                            @else
                            <span class="text-[10px] text-gray-300 italic">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <!-- Baris 2: tampilan jika data kosong -->
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
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
        </div>

        <!-- pagination -->
        @if($meetings->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $meetings->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
