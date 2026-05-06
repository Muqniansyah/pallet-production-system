<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-[#1F2937] italic uppercase tracking-tighter">
                    Data Pengajuan <span class="text-slate-400 font-light">Palet</span>
                </h1>
                <p class="text-sm text-slate-500 mt-1">Manajemen persetujuan pengajuan palet dari client secara real-time.</p>
            </div>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
        <div class="mb-6 flex items-center p-4 text-green-800 border-t-4 border-green-300 bg-green-50 rounded-lg shadow-sm" role="alert">
            <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div class="ml-3 text-sm font-medium">
                {{ session('success') }}
            </div>
        </div>
        @endif

        <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-100 border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Klien</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Detail Produk</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Desain</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Catatan</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Alamat Kirim</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Status</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-[0.2em] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($requests as $req)
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs uppercase mr-10">
                                        {{ substr($req->client->name ?? 'C', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-800">{{ $req->client->name ?? 'Unknown Client' }}</div>
                                        <div class="text-[10px] text-gray-400 font-mono">ID-REQ-{{ $req->id }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-gray-700">{{ $req->jenis_palet }}</div>
                                <div class="text-xs text-blue-600 font-black">{{ $req->qty }} <span class="text-[10px] text-gray-400 font-normal">PCS</span></div>
                            </td>

                            <td class="px-6 py-5">
                                @if($req->file_desain)
                                <a href="{{ asset('storage/' . $req->file_desain) }}" target="_blank"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-600 hover:text-white transition-all border border-blue-100">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View File
                                </a>
                                @else
                                <span class="text-[10px] font-bold text-gray-300 italic uppercase">No Design</span>
                                @endif
                            </td>

                            <td class="px-6 py-5">
                                <div class="text-sm text-gray-700">{{ $req->catatan }}</div>
                            </td>

                            <td class="px-6 py-5">
                                <p class="text-xs text-gray-500 leading-relaxed max-w-[200px] truncate group-hover:whitespace-normal group-hover:overflow-visible group-hover:bg-white group-hover:shadow-sm">
                                    {{ $req->alamat_kirim }}
                                </p>
                            </td>

                            <td class="px-6 py-5">
                                @php
                                $statusClasses = [
                                'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                'approved' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                'rejected' => 'bg-rose-100 text-rose-700 border-rose-200',
                                ];
                                @endphp
                                <span class="px-3 py-1 rounded-full border text-[10px] font-black uppercase tracking-tighter {{ $statusClasses[$req->status] ?? 'bg-gray-100' }}">
                                    {{ $req->status }}
                                </span>
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex justify-center gap-2">
                                    @if($req->status == 'pending')
                                    <div class="flex flex-col gap-3 w-full max-w-[200px]">

                                        {{-- APPROVE --}}
                                        <form action="/admin/pallet-request/{{ $req->id }}/approve" method="POST" class="w-full">
                                            @csrf
                                            <button type="submit"
                                                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold py-2.5 rounded-lg shadow-sm transition transform hover:scale-[1.02]">
                                                APPROVE
                                            </button>
                                        </form>

                                        {{-- REJECT dengan note --}}
                                        <form action="/admin/pallet-request/{{ $req->id }}/reject" method="POST" class="flex flex-col gap-2 w-full">
                                            @csrf
                                            <input
                                                type="text"
                                                name="rejection_note"
                                                placeholder="Alasan..."
                                                class="w-full bg-white border border-slate-200 text-slate-700 text-xs rounded-lg focus:ring-rose-500 focus:border-rose-500 p-2.5 outline-none placeholder:text-slate-400">
                                            <button type="submit"
                                                class="w-full bg-white hover:bg-rose-50 text-rose-600 border border-rose-600 text-[10px] font-black py-2.5 rounded-lg shadow-sm transition transform hover:scale-[1.02] uppercase tracking-wider">
                                                REJECT
                                            </button>
                                        </form>

                                    </div>
                                    @else
                                    <div class="flex flex-col items-center opacity-40">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-[9px] font-black uppercase tracking-widest mt-1 text-gray-400">Processed</span>
                                    </div>

                                    {{-- Tampilkan rejection note jika rejected --}}
                                    @if($req->status == 'rejected' && $req->rejection_note)
                                    <div class="text-[10px] text-rose-400 italic max-w-[150px] text-center leading-relaxed">
                                        "{{ $req->rejection_note }}"
                                    </div>
                                    @endif

                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if($requests->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $requests->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>