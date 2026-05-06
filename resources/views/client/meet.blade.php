<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-3xl font-black text-[#1F2937] italic uppercase tracking-tighter">
                Jadwal <span class="text-slate-400 font-light">Meeting</span>
            </h1>
            <p class="text-slate-500 mt-1">Pilih jadwal temu Anda (maks. 3 sesi/hari). Diskusi intensif selama 40 menit untuk memastikan setiap detail palet Anda terencana dengan presisi.</p>
        </div>

        @if(session('error'))
        <div class="bg-red-100 text-red-600 text-sm p-2 rounded mb-3">
            {{ session('error') }}
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="md:col-span-1">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Atur Jadwal Meet
                    </h3>

                    <form method="POST" action="/client/meeting-request" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Meeting</label>
                            <input type="text" name="title" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Contoh: Konsultasi Proyek">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Detail singkat..."></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal & Waktu</label>
                                <input type="datetime-local" name="start_time" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm px-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Durasi (Menit)</label>
                                <select name="duration" required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                    <option value="15">15 menit</option>
                                    <option value="30">30 menit</option>
                                    <option value="40">40 menit</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 shadow-md">
                            Ajukan Pertemuan
                        </button>
                    </form>
                </div>
            </div>

            <!-- table meet -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="font-bold text-gray-800">Daftar Pengajuan Meeting</h3>
                    </div>

                    <div class="overflow-x-auto" id="meetings-table-wrapper">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-xs uppercase tracking-wider text-gray-500 bg-gray-50">
                                    <th class="px-6 py-3 font-semibold">Judul</th>
                                    <th class="px-6 py-3 font-semibold">Deskripsi</th>
                                    <th class="px-6 py-3 font-semibold">Waktu</th>
                                    <th class="px-6 py-3 font-semibold">Status</th>
                                    <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                                    <th class="px-6 py-3 font-semibold">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($meetings as $meeting)
                                <tr class="hover:bg-blue-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-medium text-gray-900">{{ $meeting->title }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-normal text-gray-600">{{ $meeting->description }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($meeting->start_time)->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                        $statusColor = [
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'approved' => 'bg-green-100 text-green-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                        ][$meeting->status] ?? 'bg-gray-100 text-gray-700';
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                            {{ ucfirst($meeting->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($meeting->join_url)
                                        <a href="{{ $meeting->join_url }}" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-bold text-sm">
                                            Join Now
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                        @else
                                        <span class="text-gray-400 text-xs italic">Menunggu Link</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($meeting->status === 'rejected')
                                        {{ $meeting->note }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">
                                        Belum ada data request.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- pagination -->
                        @if($meetings->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100 meetings-pagination">
                            {{ $meetings->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // pagination
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('meetings-table-wrapper');
            const link = e.target.closest('#meetings-table-wrapper .meetings-pagination a');

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
                    const newWrapper = doc.getElementById('meetings-table-wrapper');
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