<x-app-layout>
    <div class="py-10 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- ucapan -->
            <div class="mb-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <p class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em] mb-1">
                            {{ now()->translatedFormat('l, d F Y') }}
                        </p>
                        @php
                        // Set timezone ke Jakarta agar tidak ikut waktu UTC (Global)
                        date_default_timezone_set('Asia/Jakarta');

                        $hour = date('G');
                        $greeting = 'Selamat Malam';

                        if ($hour >= 5 && $hour < 11) {
                            $greeting='Selamat Pagi' ;
                            } elseif ($hour>= 11 && $hour < 15) {
                                $greeting='Selamat Siang' ;
                                } elseif ($hour>= 15 && $hour < 18) {
                                    $greeting='Selamat Sore' ;
                                    }
                                    @endphp

                                    <h2 class="text-3xl font-black text-slate-800 italic uppercase tracking-tighter">
                                    {{ $greeting }}, <span class="text-slate-400 font-light">{{ Auth::user()->name }}</span>
                                    </h2>
                    </div>
                </div>
            </div>

            <!-- card data -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <!-- card pesanan aktif -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="bg-blue-50 p-3 rounded-xl group-hover:bg-blue-600 transition-colors">
                            <svg class="w-5 h-5 text-blue-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-black text-slate-300 uppercase italic">Active</span>
                    </div>
                    <h3 class="text-slate-500 text-[10px] font-black uppercase tracking-widest">Pesanan Aktif</h3>
                    <p class="text-3xl font-black text-slate-800 mt-1"> {{ number_format($activeOrders) }}</p>
                </div>

                <!-- card total project -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="bg-purple-50 p-3 rounded-xl group-hover:bg-purple-600 transition-colors">
                            <svg class="w-5 h-5 text-purple-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-black text-slate-300 uppercase italic">Lifetime</span>
                    </div>
                    <h3 class="text-slate-500 text-[10px] font-black uppercase tracking-widest">Total Project</h3>
                    <p class="text-3xl font-black text-slate-800 mt-1">{{ number_format($totalProject) }}</p>
                </div>

                <!-- card hpp terunggah -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="bg-amber-50 p-3 rounded-xl group-hover:bg-amber-600 transition-colors">
                            <svg class="w-5 h-5 text-amber-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-black text-slate-300 uppercase italic">Verified</span>
                    </div>
                    <h3 class="text-slate-500 text-[10px] font-black uppercase tracking-widest">HPP Terunggah</h3>
                    <p class="text-3xl font-black text-slate-800 mt-1">{{ $hppCount }}</p>
                </div>
            </div>

            <!-- riwayat -->
            <div class="mt-8 bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-semibold mb-4">Aktivitas Terbaru</h3>
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Tanggal</th>
                            <th>Kegiatan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- PALLET --}}
                        @forelse($requests as $req)
                        <tr class="border-b">
                            <td class="py-2">
                                {{ $req->created_at->format('d M Y') }}
                            </td>
                            <td>
                                📦 Request Palet - {{ $req->jenis_palet }}
                            </td>
                            <td>
                                @if($req->status == 'approved')
                                <span class="text-green-500 font-semibold">Disetujui</span>
                                @elseif($req->status == 'rejected')
                                <span class="text-red-500 font-semibold">Ditolak</span>
                                @else
                                <span class="text-yellow-500 font-semibold">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        @endforelse

                        {{-- MEETING --}}
                        @forelse($meetings as $meeting)
                        <tr class="border-b">
                            <td>
                                {{ \Carbon\Carbon::parse($meeting->created_at)->format('d M Y') }}
                            </td>
                            <td>
                                📅 Request Meeting - {{ $meeting->title }}
                            </td>
                            <td>
                                @if($meeting->status === 'approved')
                                <span class="text-green-500 font-semibold">Disetujui</span>
                                @elseif($meeting->status === 'rejected')
                                <span class="text-red-500 font-semibold">Ditolak</span>
                                @else
                                <span class="text-yellow-500 font-semibold">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        @endforelse

                        {{-- KOSONG --}}
                        @if($requests->isEmpty() && $meetings->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center text-gray-400 py-4">
                                Belum ada aktivitas
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>