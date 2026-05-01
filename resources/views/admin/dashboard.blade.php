<x-app-layout>
    <div class="py-6 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col md:flex-row md:items-end justify-between gap-2">
                <div>
                    <p class="text-[9px] font-black text-blue-600 uppercase tracking-[0.2em]">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </p>
                    <h2 class="text-2xl font-black text-slate-800 italic uppercase tracking-tighter">
                        @php
                        date_default_timezone_set('Asia/Jakarta');
                        $hour = date('G');
                        $greeting = 'Selamat Malam';
                        if ($hour >= 5 && $hour < 11) $greeting='Selamat Pagi' ;
                            elseif ($hour>= 11 && $hour < 15) $greeting='Selamat Siang' ;
                                elseif ($hour>= 15 && $hour < 18) $greeting='Selamat Sore' ;
                                    @endphp
                                    {{ $greeting }}, <span class="text-slate-400 font-light">{{ Auth::user()->name }}</span>
                    </h2>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <!-- card total pesanan -->
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all group">
                    <div class="flex justify-between items-center mb-3">
                        <div class="bg-blue-50 p-2 rounded-lg group-hover:bg-blue-600 transition-colors">
                            <svg class="w-4 h-4 text-blue-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <span class="text-[8px] font-black text-slate-300 uppercase tracking-widest">Permintaan</span>
                    </div>
                    <h3 class="text-slate-500 text-[9px] font-black uppercase tracking-wider">Total Pesanan</h3>
                    <p class="text-2xl font-black text-slate-800 tracking-tighter">{{ number_format($totalOrders) }}</p>
                </div>

                <!-- card total pengajuan -->
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all group">
                    <div class="flex justify-between items-center mb-3">
                        <div class="bg-indigo-50 p-2 rounded-lg group-hover:bg-indigo-600 transition-colors">
                            <svg class="w-4 h-4 text-indigo-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <span class="text-[8px] font-black text-slate-300 uppercase tracking-widest">Pengajuan</span>
                    </div>
                    <h3 class="text-slate-500 text-[9px] font-black uppercase tracking-wider">Total Pengajuan</h3>
                    <p class="text-2xl font-black text-slate-800 tracking-tighter">{{ number_format($totalRequests) }}</p>
                </div>

                <!-- card client aktif -->
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all group">
                    <div class="flex justify-between items-center mb-3">
                        <div class="bg-rose-50 p-2 rounded-lg group-hover:bg-rose-600 transition-colors">
                            <svg class="w-4 h-4 text-rose-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="text-[8px] font-black text-slate-300 uppercase tracking-widest">Active</span>
                    </div>
                    <h3 class="text-slate-500 text-[9px] font-black uppercase tracking-wider">Client Aktif</h3>
                    <p class="text-2xl font-black text-slate-800 tracking-tighter">{{ number_format($activeClients) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="text-[11px] font-black text-slate-800 uppercase italic tracking-tight">Log Aktivitas</h3>
                    <button class="text-[9px] font-bold text-blue-600 uppercase border border-blue-100 px-3 py-1 rounded-md hover:bg-blue-50 transition-colors">
                        Export Data
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-6 py-3 text-[9px] font-black text-slate-400 uppercase tracking-widest">Waktu</th>
                                <th class="px-6 py-3 text-[9px] font-black text-slate-400 uppercase tracking-widest">Kegiatan</th>
                                <th class="px-6 py-3 text-[9px] font-black text-slate-400 uppercase tracking-widest text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="px-6 py-3">
                                    <p class="text-[11px] font-bold text-slate-700 uppercase">10 Apr 2026</p>
                                    <p class="text-[8px] text-slate-400 font-medium">09:30 WIB</p>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm">🛠️</span>
                                        <div>
                                            <p class="text-[11px] font-black text-slate-800 uppercase italic tracking-tight">Produksi Pallet Kayu</p>
                                            <p class="text-[9px] text-slate-400 font-mono">#PROD-8821</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-right">
                                    <span class="inline-block px-2 py-0.5 rounded text-[8px] font-black uppercase border bg-green-50 text-green-600 border-green-100">
                                        Selesai
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>