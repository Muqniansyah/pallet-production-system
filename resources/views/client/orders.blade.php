<x-app-layout>
    <div class="py-10 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-10">
                <h1 class="text-3xl font-black text-slate-800 italic uppercase tracking-tighter">
                    Manajemen <span class="text-slate-400 font-light">Order & HPP</span>
                </h1>
                <p class="text-slate-500 mt-1 text-sm">Pantau status produksi dan unduh dokumen kalkulasi HPP Anda.</p>
            </div>

            <!-- pesanan saya table -->
            <div class="mb-12 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-800 uppercase italic tracking-tight flex items-center gap-2">
                        <span class="w-2 h-5 bg-blue-600 rounded-full"></span>
                        Pesanan Saya
                    </h3>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Active Requests</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Request ID</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Project</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Qty</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($orders as $order)
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="px-8 py-5 text-xs font-bold text-blue-600">
                                    #REQ-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-8 py-5 text-xs font-bold text-slate-800 uppercase italic">
                                    {{ $order->nama_project }}
                                </td>
                                <td class="px-8 py-5 text-xs font-medium text-slate-600 text-center">
                                    {{ number_format($order->qty) }} unit
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter border {{ $order->status == 'deal' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-amber-50 text-amber-600 border-amber-100' }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ url('client/meet') }}" class="bg-white hover:bg-slate-800 hover:text-white text-slate-800 border border-slate-200 text-[9px] font-black px-3 py-2 rounded-lg transition transform hover:scale-105 uppercase tracking-tighter">
                                            Ajukan Meeting
                                        </a>
                                        <form action="{{ route('client.orders.deal', $order->id) }}" method="POST">
                                            @csrf
                                            @if($order->status == 'pending')
                                            <button
                                                class="bg-blue-600 hover:bg-blue-700 text-white text-[9px] font-black px-3 py-2 rounded-lg">
                                                Proses HPP
                                            </button>
                                            @else
                                            <span class="px-6 py-4 text-sm">Sudah Diproses</span>
                                            @endif
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center text-slate-400 italic text-xs">Belum ada pesanan aktif.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- data hpp table -->
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-50">
                    <h3 class="text-sm font-black text-slate-800 uppercase italic tracking-tight flex items-center gap-2">
                        <span class="w-2 h-5 bg-emerald-500 rounded-full"></span>
                        Data Dokumen HPP
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Request ID</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Project</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Hasil Upload HPP</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($orders as $order)
                            @if($order->hpp)
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="px-8 py-5 text-xs font-bold text-slate-500 uppercase">#REQ-{{ $order->id }}</td>
                                <td class="px-8 py-5 text-xs font-bold text-slate-800 uppercase italic">{{ $order->nama_project }}</td>
                                <td class="px-8 py-5">
                                    <a href="{{ asset('storage/' . $order->hpp->file_hpp) }}" target="_blank" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-black text-[10px] uppercase tracking-widest transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" />
                                        </svg>
                                        Download Dokumen HPP
                                    </a>
                                </td>
                            </tr>
                            @endif
                            @empty
                            @endforelse

                            {{-- Cek jika benar-benar tidak ada HPP dari semua order --}}
                            @if(!$orders->contains(fn($o) => $o->hpp))
                            <tr>
                                <td colspan="3" class="px-8 py-12 text-center text-slate-400 italic text-xs">Belum ada dokumen HPP yang terunggah.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>