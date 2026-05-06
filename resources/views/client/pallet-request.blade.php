<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4">

        <div class="mb-8">
            <h1 class="text-3xl font-black text-[#1F2937] italic uppercase tracking-tighter">
                Pengajuan <span class="text-slate-400 font-light">Palet</span>
            </h1>
            <p class="text-slate-500 text-sm mt-1">Silakan lengkapi detail pesanan palet Anda di bawah ini.</p>
        </div>

        @if(session('success'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 rounded shadow-sm flex items-center">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <!-- ===== FORM PENGAJUAN ===== -->
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <form action="{{ route('client.pallet.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="space-y-6">
                        <div class="group">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 group-focus-within:text-blue-600 transition-colors">Jenis Palet</label>
                            <select name="jenis_palet" class="w-full border-gray-200 rounded-2xl shadow-sm focus:ring-blue-500 focus:border-blue-500 py-3 pl-4 pr-10 appearance-none" required>
                                <option value="" disabled selected>Pilih Tipe Palet...</option>
                                <option value="Palet Kayu Racuk">Palet Kayu Racuk</option>
                                <option value="Palet Kayu Mahoni">Palet Kayu Mahoni</option>
                                <option value="Palet Kayu Meranti">Palet Kayu Meranti</option>
                                <option value="Palet Kayu Jati">Palet Kayu Jati</option>
                                <option value="Palet Kayu Sengon">Palet Kayu Sengon</option>
                                <option value="Palet Kayu Kamper">Palet Kayu Kamper</option>
                            </select>
                        </div>

                        <div class="group">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 group-focus-within:text-blue-600 transition-colors">Quantity (Qty)</label>
                            <div class="relative">
                                <input type="number" name="qty" placeholder="0"
                                    class="w-full border-gray-200 rounded-2xl shadow-sm focus:ring-blue-500 focus:border-blue-500 py-3 pl-4 pr-16" required>

                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 font-bold text-sm pointer-events-none">
                                    PCS
                                </span>
                            </div>
                        </div>

                        <div class="group">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">
                                Upload Desain <span class="text-gray-300 font-normal italic">(Opsional)</span>
                            </label>

                            <div id="dropzone" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-2xl hover:border-blue-400 transition-all cursor-pointer relative bg-white">

                                <input type="file" name="file_desain" id="fileInput" class="absolute inset-0 opacity-0 cursor-pointer z-20">

                                <div class="space-y-2 text-center">
                                    <svg id="uploadIcon" class="mx-auto h-10 w-10 text-gray-300 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    <div id="fileStatus" class="flex flex-col items-center">
                                        <p id="statusText" class="text-xs text-gray-400 font-medium italic">Klik atau drag file ke sini</p>
                                        <p id="subText" class="text-[9px] text-gray-300 mt-1">PDF, JPG, PNG up to 10MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="group">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 group-focus-within:text-blue-600 transition-colors">Alamat Kirim</label>
                            <textarea name="alamat_kirim" rows="3" placeholder="Masukkan alamat lengkap pengiriman..." class="w-full border-gray-200 rounded-2xl shadow-sm focus:ring-blue-500 focus:border-blue-500 py-3 pl-4" required></textarea>
                        </div>

                        <div class="group">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 group-focus-within:text-blue-600 transition-colors">Catatan Tambahan</label>
                            <textarea name="catatan" rows="3" placeholder="Contoh: Kayu harus kering, warna cokelat..." class="w-full border-gray-200 rounded-2xl shadow-sm focus:ring-blue-500 focus:border-blue-500 py-3 pl-4"></textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-6 border-t border-gray-50 flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-black py-4 px-12 rounded-2xl shadow-lg shadow-emerald-200 transition-all active:scale-95 uppercase tracking-widest text-sm">
                        Kirim Request Palet
                    </button>
                </div>
            </form>
        </div>

        {{-- ===== TABEL PENGAJUAN ===== --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden mt-8">
            <div class="px-8 py-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-black text-gray-800 tracking-tight">Riwayat Pengajuan Palet</h3>
                <span class="text-xs text-gray-400 font-medium">{{ $requests->count() }} pengajuan</span>
            </div>

            <div class="overflow-x-auto" id="requests-table-wrapper">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Jenis Palet</th>
                            <th class="px-8 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Qty</th>
                            <th class="px-8 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Alamat Kirim</th>
                            <th class="px-8 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Catatan</th>
                            <th class="px-8 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($requests as $req)
                        <tr class="hover:bg-gray-50/50 transition-colors">

                            {{-- JENIS PALET --}}
                            <td class="px-8 py-5">
                                <div class="text-sm font-bold text-gray-800">{{ $req->jenis_palet }}</div>
                                @if($req->file_desain)
                                <a href="{{ asset('storage/' . $req->file_desain) }}" target="_blank"
                                    class="text-[10px] text-blue-500 hover:underline font-semibold">
                                    Lihat Desain
                                </a>
                                @endif
                            </td>

                            {{-- QTY --}}
                            <td class="px-8 py-5">
                                <span class="text-sm font-black text-blue-600">{{ $req->qty }}</span>
                                <span class="text-[10px] text-gray-400 font-normal ml-1">PCS</span>
                            </td>

                            {{-- ALAMAT --}}
                            <td class="px-8 py-5">
                                <p class="text-xs text-gray-500 max-w-[180px] truncate" title="{{ $req->alamat_kirim }}">
                                    {{ $req->alamat_kirim }}
                                </p>
                            </td>

                            {{-- CATATAN --}}
                            <td class="px-8 py-5">
                                <p class="text-xs text-gray-400 max-w-[150px] truncate" title="{{ $req->catatan }}">
                                    {{ $req->catatan ?? '-' }}
                                </p>
                            </td>

                            {{-- STATUS --}}
                            <td class="px-8 py-5">
                                @if($req->status == 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-50 text-amber-600 border border-amber-200 text-[10px] font-black uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span>
                                    Pending
                                </span>

                                @elseif($req->status == 'approved')
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200 text-[10px] font-black uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                    Disetujui
                                </span>

                                @elseif($req->status == 'rejected')
                                <div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-rose-50 text-rose-600 border border-rose-200 text-[10px] font-black uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span>
                                        Ditolak
                                    </span>
                                    {{-- Tampilkan alasan jika ada --}}
                                    @if($req->rejection_note)
                                    <p class="text-[10px] text-rose-400 italic mt-1 max-w-[160px]">
                                        "{{ $req->rejection_note }}"
                                    </p>
                                    @endif
                                </div>
                                @endif
                            </td>

                            {{-- TANGGAL --}}
                            <td class="px-8 py-5">
                                <div class="text-xs text-gray-400 font-medium">{{ $req->created_at->format('d M Y') }}</div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-16">
                                <div class="text-gray-200 font-black text-3xl italic tracking-tighter mb-2">BELUM ADA PENGAJUAN</div>
                                <p class="text-gray-400 text-xs">Pengajuan palet kamu akan muncul di sini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- pagination --}}
                @if($requests->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 requests-pagination">
                    {{ $requests->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- ===== PaletView 3D Card Box ===== -->
        <div class="mt-8">
            <div class="bg-white rounded-xl shadow overflow-hidden">

                <!-- Card Title Bar -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center"
                            style="background: linear-gradient(135deg, #1e3a5f, #2563eb);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-800">PaletView™ 3D</h3>
                            <p class="text-xs text-gray-400">Hand Gesture Edition — Live Preview</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button onclick="pvLaunchSecure()"
                            class="text-xs font-medium px-4 py-2 rounded-lg text-white transition-all duration-200 hover:opacity-90 active:scale-95"
                            style="background: linear-gradient(135deg, #1e3a5f, #2563eb);">
                            ↗ Buka Fullscreen
                        </button>
                    </div>
                </div>

                <!-- Iframe Container -->
                <div class="relative w-full" style="height: 640px; background:#0f172a;">

                    <!-- SPLASH SCREEN -->
                    <div id="pv-splash"
                        class="absolute inset-0 z-20 flex flex-col items-center justify-center"
                        style="background: linear-gradient(160deg, #0f172a 0%, #1e3a5f 60%, #0f172a 100%); overflow:hidden;">
                        <div id="pv-grid" style="position:absolute;inset:0;z-index:0;background-image:linear-gradient(rgba(37,99,235,0.12) 1px,transparent 1px),linear-gradient(90deg,rgba(37,99,235,0.12) 1px,transparent 1px);background-size:40px 40px;animation:pvGridScroll 8s linear infinite;"></div>
                        <div style="position:absolute;width:340px;height:340px;border-radius:50%;background:radial-gradient(circle,rgba(37,99,235,0.25) 0%,transparent 70%);top:-80px;left:-80px;animation:pvPulse 4s ease-in-out infinite;"></div>
                        <div style="position:absolute;width:280px;height:280px;border-radius:50%;background:radial-gradient(circle,rgba(99,179,237,0.18) 0%,transparent 70%);bottom:-60px;right:-60px;animation:pvPulse 4s ease-in-out infinite 2s;"></div>
                        <div style="position:relative;z-index:10;margin-bottom:28px;">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" style="animation:pvFloat 3s ease-in-out infinite;filter:drop-shadow(0 0 18px rgba(37,99,235,0.7));">
                                <polygon points="40,8 72,26 72,54 40,72 8,54 8,26" fill="rgba(30,58,95,0.85)" stroke="#2563eb" stroke-width="1.5" />
                                <polygon points="40,8 72,26 40,44 8,26" fill="rgba(37,99,235,0.55)" stroke="#60a5fa" stroke-width="1" />
                                <polygon points="8,26 40,44 40,72 8,54" fill="rgba(15,23,42,0.9)" stroke="#1e40af" stroke-width="1" />
                                <polygon points="72,26 40,44 40,72 72,54" fill="rgba(29,78,216,0.7)" stroke="#3b82f6" stroke-width="1" />
                                <line x1="22" y1="35" x2="40" y2="44" stroke="rgba(147,197,253,0.4)" stroke-width="0.8" />
                                <line x1="31" y1="21" x2="49" y2="30" stroke="rgba(147,197,253,0.4)" stroke-width="0.8" />
                                <line x1="40" y1="8" x2="58" y2="17" stroke="rgba(147,197,253,0.4)" stroke-width="0.8" />
                            </svg>
                        </div>
                        <div style="position:relative;z-index:10;text-align:center;margin-bottom:20px;">
                            <div style="font-family:'Courier New',monospace;font-size:11px;letter-spacing:4px;color:#60a5fa;text-transform:uppercase;margin-bottom:6px;opacity:0.8;">Memuat Aplikasi</div>
                            <div style="font-size:22px;font-weight:700;color:#e2e8f0;letter-spacing:1px;">PaletView™ <span style="color:#3b82f6;">3D</span></div>
                            <div style="font-size:12px;color:#94a3b8;margin-top:4px;letter-spacing:2px;">HAND GESTURE EDITION</div>
                        </div>
                        <div style="position:relative;z-index:10;width:260px;margin-bottom:14px;">
                            <div style="width:100%;height:3px;background:rgba(255,255,255,0.08);border-radius:99px;overflow:hidden;">
                                <div id="pv-bar" style="height:100%;width:0%;background:linear-gradient(90deg,#1d4ed8,#60a5fa);border-radius:99px;transition:width 0.3s ease;"></div>
                            </div>
                        </div>
                        <div id="pv-status-text" style="position:relative;z-index:10;font-size:11px;color:#64748b;font-family:'Courier New',monospace;letter-spacing:1px;min-height:18px;">Menginisialisasi...</div>
                        <div style="position:relative;z-index:10;display:flex;gap:6px;margin-top:18px;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#2563eb;animation:pvDot 1.4s ease-in-out infinite 0s;"></span>
                            <span style="width:6px;height:6px;border-radius:50%;background:#2563eb;animation:pvDot 1.4s ease-in-out infinite 0.2s;"></span>
                            <span style="width:6px;height:6px;border-radius:50%;background:#2563eb;animation:pvDot 1.4s ease-in-out infinite 0.4s;"></span>
                        </div>
                    </div>

                    <iframe id="pv-frame"
                        style="width:100%;height:100%;border:none;opacity:0;transition:opacity 0.6s ease;position:relative;z-index:10;"
                        sandbox="allow-scripts allow-same-origin allow-forms allow-pointer-lock allow-popups"
                        referrerpolicy="no-referrer"
                        loading="lazy"
                        title="PaletView 3D"></iframe>
                </div>

                <!-- Log bar -->
                <div id="pv-log-bar"
                    style="padding:8px 20px;background:#f8fafc;border-top:1px solid #f1f5f9;font-size:11px;color:#94a3b8;font-family:'Courier New',monospace;display:flex;align-items:center;gap:8px;min-height:32px;">
                    <span id="pv-log-dot" style="width:6px;height:6px;border-radius:50%;background:#e2e8f0;flex-shrink:0;transition:background 0.3s;"></span>
                    <span id="pv-log-msg">Menunggu koneksi PaletView...</span>
                </div>

            </div>
        </div>
        <!-- ===== END PaletView 3D Card Box ===== -->

        <!-- ===== TABEL DATA DESAIN PALET (dari database) ===== -->
        <div class="mt-8 bg-white rounded-xl shadow overflow-hidden">

            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div>
                    <h3 class="text-base font-semibold text-gray-800">📦 Data Desain Palet — Real-time</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Tersinkronisasi otomatis dari PaletView setiap kali user input</p>
                </div>
                <button onclick="pvRefreshTable()"
                    id="pv-refresh-btn"
                    class="text-xs font-medium px-4 py-2 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 transition-all duration-200 flex items-center gap-2">
                    <span id="pv-refresh-icon">⟳</span> Refresh
                </button>
            </div>

            <!-- Stats bar -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-0 border-b border-gray-100">
                <div class="px-6 py-3 border-r border-gray-100">
                    <div class="text-xs text-gray-400">Total Desain</div>
                    <div class="text-lg font-bold text-gray-800" id="pv-stat-total">—</div>
                </div>
                <div class="px-6 py-3 border-r border-gray-100">
                    <div class="text-xs text-gray-400">Sesi Aktif Hari Ini</div>
                    <div class="text-lg font-bold text-blue-600" id="pv-stat-today">—</div>
                </div>
                <div class="px-6 py-3 border-r border-gray-100">
                    <div class="text-xs text-gray-400">Dimensi Terbaru</div>
                    <div class="text-lg font-bold text-gray-800" id="pv-stat-dim">—</div>
                </div>
                <div class="px-6 py-3">
                    <div class="text-xs text-gray-400">Update Terakhir</div>
                    <div class="text-lg font-bold text-green-600" id="pv-stat-last">—</div>
                </div>
            </div>

            <!-- Table scroll wrapper -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm" id="pv-data-table">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-3 font-medium">Waktu</th>
                            <th class="px-4 py-3 font-medium">Dimensi (mm)</th>
                            <th class="px-4 py-3 font-medium">Papan Atas</th>
                            <th class="px-4 py-3 font-medium">Lapisan Tengah</th>
                            <th class="px-4 py-3 font-medium">Papan Bawah</th>
                            <th class="px-4 py-3 font-medium">Gesture (mm)</th>
                            <th class="px-4 py-3 font-medium">Total Tinggi</th>
                            <th class="px-4 py-3 font-medium">Mode</th>
                            <th class="px-4 py-3 font-medium text-center">Ekspor</th>
                        </tr>
                    </thead>
                    <tbody id="pv-table-body" class="divide-y divide-gray-100">
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-gray-400 text-sm">
                                <div class="flex flex-col items-center gap-2">
                                    <span style="font-size:24px;">📭</span>
                                    <span>Belum ada data — mulai input di PaletView di atas</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer pagination info -->
            <div class="px-6 py-3 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs text-gray-400" id="pv-table-info">Menampilkan 0 data</span>
                <span class="text-xs text-gray-300" id="pv-last-fetch">—</span>
            </div>

        </div>
        <!-- ===== END TABEL DATA ===== -->
    </div>

    <!-- ===== STYLES ===== -->
    <style>
        @keyframes pvGridScroll {
            0% {
                background-position: 0 0
            }

            100% {
                background-position: 40px 40px
            }
        }

        @keyframes pvPulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.6
            }

            50% {
                transform: scale(1.15);
                opacity: 1
            }
        }

        @keyframes pvFloat {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg)
            }

            50% {
                transform: translateY(-10px) rotate(3deg)
            }
        }

        @keyframes pvDot {

            0%,
            80%,
            100% {
                transform: scale(0.6);
                opacity: 0.4
            }

            40% {
                transform: scale(1.2);
                opacity: 1
            }
        }

        @keyframes pvSpin {
            from {
                transform: rotate(0deg)
            }

            to {
                transform: rotate(360deg)
            }
        }

        #pv-data-table tbody tr:hover {
            background: #f8fafc;
        }

        .pv-badge {
            display: inline-block;
            padding: 1px 7px;
            border-radius: 99px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.03em;
        }

        .pv-badge-blue {
            background: #eff6ff;
            color: #2563eb;
        }

        .pv-badge-green {
            background: #f0fdf4;
            color: #16a34a;
        }

        .pv-badge-amber {
            background: #fffbeb;
            color: #d97706;
        }

        .pv-badge-gray {
            background: #f3f4f6;
            color: #6b7280;
        }

        .pv-dim-cell {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            font-weight: 600;
            color: #1e3a5f;
        }

        .pv-sub {
            font-size: 10px;
            color: #9ca3af;
        }

        .pv-spin {
            animation: pvSpin 1s linear infinite;
            display: inline-block;
        }

        /* ── Tombol Ekspor PDF ── */
        .pv-btn-pdf {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 4px 10px;
            font-size: 10px;
            font-weight: 600;
            color: #dc2626;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.18s ease;
            white-space: nowrap;
            letter-spacing: 0.02em;
        }

        .pv-btn-pdf:hover {
            background: #dc2626;
            color: #fff;
            border-color: #dc2626;
            transform: scale(1.04);
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.25);
        }

        .pv-btn-pdf:active {
            transform: scale(0.97);
        }

        /* ── Highlight baris baru ── */
        @keyframes pvRowFlash {
            0% {
                background-color: #fefce8;
            }

            20% {
                background-color: #fde047;
            }

            100% {
                background-color: #fefce8;
            }
        }

        .pv-row-new {
            animation: pvRowFlash 1s ease-out forwards;
            background-color: #fefce8 !important;
            border-left: 3px solid #eab308 !important;
        }

        .pv-new-badge {
            display: inline-block;
            background: #eab308;
            color: #fff;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.05em;
            padding: 1px 6px;
            border-radius: 99px;
            margin-right: 6px;
            vertical-align: middle;
            animation: pvPulse 1s ease-in-out infinite;
            transition: opacity 0.5s ease;
        }
    </style>

    <!-- jsPDF untuk ekspor PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <!-- ===== SCRIPTS ===== -->
    <script>
        (function() {
            'use strict';

            /* ─── Obfuscated URL ────────────────────────────── */
            var _e = 'aHR0cHM6Ly9jb3VyYWdlb3VzLXJvbHlwb2x5LTUzMjU3MS5uZXRsaWZ5LmFwcC8=';

            function _d() {
                try {
                    return atob(_e);
                } catch (x) {
                    return null;
                }
            }

            var TRUSTED_ORIGIN = 'https://courageous-rolypoly-532571.netlify.app';
            var API_SYNC = '/client/palet/sync';
            var API_LIST = '/client/palet/designs';

            /* ─── DOM refs ──────────────────────────────────── */
            var _bar = document.getElementById('pv-bar');
            var _status = document.getElementById('pv-status-text');
            var _splash = document.getElementById('pv-splash');
            var _frame = document.getElementById('pv-frame');
            var _logDot = document.getElementById('pv-log-dot');
            var _logMsg = document.getElementById('pv-log-msg');

            /* ─── Splash sequence ───────────────────────────── */
            var _msgs = [
                'Menginisialisasi mesin 3D...', 'Memuat model geometri palet...',
                'Mengaktifkan hand gesture ML...', 'Menyiapkan WebGL renderer...',
                'Menghubungkan ke modul kamera...', 'Hampir selesai...'
            ];
            var _msgIdx = 0,
                _progress = 0,
                _started = false;

            function _step() {
                if (_progress >= 100) {
                    _finalize();
                    return;
                }
                _progress = Math.min(_progress + Math.floor(Math.random() * 18) + 8, 100);
                if (_bar) _bar.style.width = _progress + '%';
                if (_status && _msgs[_msgIdx]) {
                    _status.textContent = _msgs[_msgIdx];
                    _msgIdx = Math.min(_msgIdx + 1, _msgs.length - 1);
                }
                setTimeout(_step, Math.floor(Math.random() * 500) + 350);
            }

            function _finalize() {
                if (_status) _status.textContent = 'Siap!';
                if (_bar) _bar.style.width = '100%';
                var url = _d();
                if (url && _frame) {
                    _frame.src = url;
                    _frame.onload = function() {
                        setTimeout(function() {
                            if (_splash) {
                                _splash.style.transition = 'opacity 0.7s ease';
                                _splash.style.opacity = '0';
                                setTimeout(function() {
                                    _splash.style.display = 'none';
                                }, 700);
                            }
                            if (_frame) _frame.style.opacity = '1';
                            _setLog('hijau', '✓ PaletView terhubung — menunggu input data...');
                        }, 400);
                    };
                    setTimeout(function() {
                        if (_splash && _splash.style.display !== 'none') {
                            _splash.style.opacity = '0';
                            setTimeout(function() {
                                _splash.style.display = 'none';
                            }, 700);
                            if (_frame) _frame.style.opacity = '1';
                        }
                    }, 6000);
                }
            }

            var _container = _frame ? _frame.closest('.relative') : null;
            if (_container && 'IntersectionObserver' in window) {
                var _obs = new IntersectionObserver(function(entries) {
                    entries.forEach(function(e) {
                        if (e.isIntersecting && !_started) {
                            _started = true;
                            setTimeout(_step, 300);
                            _obs.disconnect();
                        }
                    });
                }, {
                    threshold: 0.2
                });
                _obs.observe(_container);
            } else {
                setTimeout(_step, 500);
            }

            /* ─── Log helper ────────────────────────────────── */
            function _setLog(w, msg) {
                var c = {
                    hijau: '#22c55e',
                    merah: '#ef4444',
                    kuning: '#f59e0b',
                    abu: '#e2e8f0'
                };
                if (_logDot) _logDot.style.background = c[w] || c.abu;
                if (_logMsg) _logMsg.textContent = msg;
            }

            /* ─── postMessage → sync ke API ─────────────────── */
            var _syncCount = 0,
                _syncTimer = null;

            window.addEventListener('message', function(event) {
                if (event.origin !== TRUSTED_ORIGIN) return;
                var msg = event.data;
                if (!msg || msg.type !== 'PALET_DATA_UPDATE' || !msg.payload) return;
                _setLog('kuning', '⟳ Data diterima dari PaletView — menyimpan...');
                clearTimeout(_syncTimer);
                _syncTimer = setTimeout(function() {
                    _syncToLaravel(msg.payload);
                }, 600);
            });

            function _syncToLaravel(payload) {
                var csrf = document.querySelector('meta[name="csrf-token"]');
                var headers = {
                    'Content-Type': 'application/json'
                };
                if (csrf) headers['X-CSRF-TOKEN'] = csrf.getAttribute('content');

                fetch(API_SYNC, {
                        method: 'POST',
                        headers: headers,
                        credentials: 'same-origin',
                        body: JSON.stringify(payload)
                    })
                    .then(function(r) {
                        if (!r.ok) throw new Error('HTTP ' + r.status);
                        return r.json();
                    })
                    .then(function() {
                        _syncCount++;
                        var waktu = new Date().toLocaleTimeString('id-ID');
                        _setLog('hijau', '✓ Tersimpan ke database [' + waktu + '] — total sync: ' + _syncCount);
                        // Refresh tabel otomatis setelah data masuk
                        setTimeout(pvRefreshTable, 500);
                    })
                    .catch(function(err) {
                        _setLog('merah', '✗ Gagal simpan: ' + err.message);
                        console.error('[PaletSync]', err);
                    });
            }

            /* ─── Fullscreen launcher ───────────────────────── */
            window.pvLaunchSecure = function() {
                var url = _d();
                if (!url) return;
                var w = window.open('about:blank', '_blank', 'noopener,noreferrer');
                if (w) {
                    try {
                        w.document.open();
                        w.document.write('<!DOCTYPE html><html><head><meta http-equiv="refresh" content="0;url=' + url + '"><title>Redirecting...</title></head><body></body></html>');
                        w.document.close();
                    } catch (ex) {
                        w.location.href = url;
                    }
                }
            };

            /* ─── Anti-inspect ──────────────────────────────── */
            var _card = document.getElementById('pv-frame');
            if (_card) {
                _card.closest('.relative').addEventListener('contextmenu', function(ev) {
                    ev.preventDefault();
                    return false;
                });
            }
            document.addEventListener('keydown', function(ev) {
                var k = ev.key || '';
                if (ev.keyCode === 123 || (ev.ctrlKey && ev.shiftKey && ['I', 'i', 'J', 'j', 'C', 'c'].includes(k)) || (ev.ctrlKey && ['U', 'u'].includes(k))) {
                    ev.preventDefault();
                    ev.stopPropagation();
                    return false;
                }
            }, true);
            (function _hb() {
                (function() {
                    var d = new Date();
                    debugger;
                    if (new Date() - d > 100) {
                        if (_frame) _frame.src = 'about:blank';
                    }
                })();
                setTimeout(_hb, 3000);
            })();

            /* ════════════════════════════════════════════════
               TABEL DATA — fetch dari /api/palet/designs
            ════════════════════════════════════════════════ */

            function pvRefreshTable() {
                var btn = document.getElementById('pv-refresh-btn');
                var icon = document.getElementById('pv-refresh-icon');
                if (icon) {
                    icon.className = 'pv-spin';
                    icon.textContent = '⟳';
                }
                if (btn) btn.disabled = true;

                fetch(API_LIST, {
                        credentials: 'same-origin'
                    })
                    .then(function(r) {
                        if (!r.ok) throw new Error('HTTP ' + r.status);
                        return r.json();
                    })
                    .then(function(data) {
                        pvRenderTable(data);
                        pvRenderStats(data);
                        var now = new Date().toLocaleTimeString('id-ID');
                        var info = document.getElementById('pv-last-fetch');
                        if (info) info.textContent = 'Diperbarui: ' + now;
                    })
                    .catch(function(err) {
                        var tbody = document.getElementById('pv-table-body');
                        if (tbody) tbody.innerHTML = '<tr><td colspan="9" class="px-4 py-6 text-center text-red-400 text-sm">Gagal memuat data: ' + err.message + '</td></tr>';
                    })
                    .finally(function() {
                        if (icon) {
                            icon.className = '';
                            icon.textContent = '⟳';
                        }
                        if (btn) btn.disabled = false;
                    });
            }

            function pvRenderStats(data) {
                var total = data.length;
                var today = data.filter(function(d) {
                    if (!d.last_updated_at) return false;
                    return new Date(d.last_updated_at).toDateString() === new Date().toDateString();
                }).length;
                var latest = data[0];
                var dim = latest && latest.dimensi_panjang ?
                    (latest.dimensi_panjang * 10) + ' × ' + (latest.dimensi_lebar * 10) + ' mm' :
                    '—';
                var lastTime = latest && latest.last_updated_at ?
                    new Date(latest.last_updated_at).toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    }) :
                    '—';

                var el = function(id, v) {
                    var e = document.getElementById(id);
                    if (e) e.textContent = v;
                };
                el('pv-stat-total', total);
                el('pv-stat-today', today);
                el('pv-stat-dim', dim);
                el('pv-stat-last', lastTime);
            }

            /* ─── Tracking baris terbaru ─────────────────────── */
            var _lastTopId = null;

            function pvRenderTable(data) {
                var tbody = document.getElementById('pv-table-body');
                var info = document.getElementById('pv-table-info');
                if (!tbody) return;

                if (!data || data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="9" class="px-4 py-8 text-center text-gray-400 text-sm"><div class="flex flex-col items-center gap-2"><span style="font-size:24px;">📭</span><span>Belum ada data — mulai input di PaletView di atas</span></div></td></tr>';
                    if (info) info.textContent = 'Menampilkan 0 data';
                    _lastTopId = null;
                    return;
                }

                // Gunakan kombinasi id + last_updated_at agar lebih sensitif terhadap perubahan
                var currentTopId = data[0] ?
                    (data[0].id + '|' + data[0].last_updated_at) :
                    null;
                var isNewRow = _lastTopId !== null && currentTopId !== _lastTopId;
                _lastTopId = currentTopId;

                var rows = data.map(function(d, idx) {
                    var isNewest = idx === 0 && isNewRow;

                    var waktu = d.last_updated_at ?
                        new Date(d.last_updated_at).toLocaleString('id-ID', {
                            day: '2-digit',
                            month: 'short',
                            hour: '2-digit',
                            minute: '2-digit'
                        }) : '—';

                    var dim = (d.dimensi_panjang && d.dimensi_lebar) ?
                        '<span class="pv-dim-cell">' + (d.dimensi_panjang * 10) + ' × ' + (d.dimensi_lebar * 10) + '</span>' :
                        '<span class="text-gray-300">—</span>';

                    var pa = (d.papan_atas_jumlah) ?
                        '<span class="font-medium">' + d.papan_atas_jumlah + ' pcs</span>' +
                        '<div class="pv-sub">' + pvNullDash(d.papan_atas_tebal) + '×' + pvNullDash(d.papan_atas_lebar) + ' cm' +
                        (d.papan_atas_arah ? ' · ' + (d.papan_atas_arah === 'x' ? '↔' : '↕') : '') + '</div>' :
                        '<span class="text-gray-300">—</span>';

                    var lt = (d.lapisan_tengah_jumlah) ?
                        '<span class="font-medium">' + d.lapisan_tengah_jumlah + ' balok</span>' +
                        '<div class="pv-sub">' + pvNullDash(d.lapisan_tengah_tinggi) + '×' + pvNullDash(d.lapisan_tengah_lebar) + ' cm' +
                        (d.lapisan_tengah_tipe ? ' · ' + d.lapisan_tengah_tipe : '') + '</div>' :
                        '<span class="text-gray-300">—</span>';

                    var pb = (d.papan_bawah_jumlah) ?
                        '<span class="font-medium">' + d.papan_bawah_jumlah + ' pcs</span>' +
                        '<div class="pv-sub">' + pvNullDash(d.papan_bawah_tebal) + '×' + pvNullDash(d.papan_bawah_lebar) + ' cm' +
                        (d.papan_bawah_pola ? ' · ' + d.papan_bawah_pola : '') + '</div>' :
                        '<span class="text-gray-300">—</span>';

                    var gest = (d.gesture_x || d.gesture_y || d.gesture_z) ?
                        '<span style="font-family:monospace;font-size:11px;">X:' + pvNullDash(d.gesture_x) +
                        ' Y:' + pvNullDash(d.gesture_y) + ' Z:' + pvNullDash(d.gesture_z) + '</span>' :
                        '<span class="text-gray-300">—</span>';

                    var hk = d.hasil_kalkulasi;
                    if (typeof hk === 'string') {
                        try {
                            hk = JSON.parse(hk);
                        } catch (e) {
                            hk = null;
                        }
                    }
                    var tinggi = (hk && hk.total_tinggi_cm) ?
                        '<span class="font-semibold text-blue-700">' + (hk.total_tinggi_cm * 10).toFixed(0) + ' mm</span>' :
                        '<span class="text-gray-300">—</span>';

                    var modeBadge = d.mode_tracking ?
                        '<span class="pv-badge ' + (d.mode_tracking === 'mode1' ? 'pv-badge-blue' : 'pv-badge-green') + '">' +
                        (d.mode_tracking === 'mode1' ? '✌ Gestur' : '⌨ VKB') + '</span>' :
                        '<span class="pv-badge pv-badge-gray">—</span>';

                    // Badge "BARU" + class highlight untuk baris terbaru
                    var newBadge = isNewest ?
                        '<span class="pv-new-badge">✦ BARU</span>' : '';

                    var rowClass = isNewest ? 'pv-row-new' : '';
                    var rowId = isNewest ? 'id="pv-newest-row"' : '';

                    return '<tr ' + rowId + ' class="' + rowClass + ' hover:bg-gray-50/50 transition-colors">' +
                        '<td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">' + newBadge + waktu + '</td>' +
                        '<td class="px-4 py-3">' + dim + '</td>' +
                        '<td class="px-4 py-3 text-xs">' + pa + '</td>' +
                        '<td class="px-4 py-3 text-xs">' + lt + '</td>' +
                        '<td class="px-4 py-3 text-xs">' + pb + '</td>' +
                        '<td class="px-4 py-3 text-xs">' + gest + '</td>' +
                        '<td class="px-4 py-3 text-xs">' + tinggi + '</td>' +
                        '<td class="px-4 py-3 text-xs">' + modeBadge + '</td>' +
                        '<td class="px-4 py-3 text-center">' +
                        '<button onclick=\'pvExportPDF(' + JSON.stringify(d) + ')\' class="pv-btn-pdf" title="Ekspor ke PDF">' +
                        '<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline;vertical-align:-2px;margin-right:3px;"><path d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>' +
                        'PDF</button>' +
                        '</td>' +
                        '</tr>';
                }).join('');

                tbody.innerHTML = rows;
                if (info) info.textContent = 'Menampilkan ' + data.length + ' data';

                // Scroll ke baris baru & hilangkan highlight setelah 5 detik
                if (isNewRow) {
                    var newestRow = document.getElementById('pv-newest-row');
                    if (newestRow) {
                        newestRow.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        setTimeout(function() {
                            newestRow.classList.remove('pv-row-new');
                            var badge = newestRow.querySelector('.pv-new-badge');
                            if (badge) badge.style.opacity = '0';
                        }, 5000);
                    }
                }
            }

            function pvNullDash(v) {
                return (v !== null && v !== undefined && v !== '') ? v : '—';
            }

            /* ─── Ekspor PDF per baris ───────────────────────── */
            window.pvExportPDF = function(d) {
                var jspdf = window.jspdf;
                if (!jspdf || !jspdf.jsPDF) {
                    alert('Library PDF belum siap, coba beberapa detik lagi.');
                    return;
                }
                var doc = new jspdf.jsPDF({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                });
                var W = doc.internal.pageSize.getWidth();

                // Header biru
                doc.setFillColor(30, 58, 95);
                doc.rect(0, 0, W, 28, 'F');
                doc.setTextColor(255, 255, 255);
                doc.setFontSize(14);
                doc.setFont('helvetica', 'bold');
                doc.text('DESAIN PALET \u2014 PT. KEMAS KAYU INDONESIA', 14, 11);
                doc.setFontSize(7.5);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(148, 163, 184);
                var waktuStr = d.last_updated_at ?
                    new Date(d.last_updated_at).toLocaleString('id-ID', {
                        dateStyle: 'long',
                        timeStyle: 'short'
                    }) : '\u2014';
                doc.text('Dicetak: ' + new Date().toLocaleString('id-ID') + '   |   Update: ' + waktuStr, 14, 19);
                doc.text('Session ID: ' + (d.session_id || '\u2014'), 14, 25);

                var y = 36;

                function nd(v) {
                    return (v !== null && v !== undefined && v !== '') ? String(v) : '\u2014';
                }

                function sectionTitle(title) {
                    doc.setFillColor(239, 246, 255);
                    doc.rect(14, y - 4, W - 28, 8, 'F');
                    doc.setTextColor(30, 58, 95);
                    doc.setFontSize(8.5);
                    doc.setFont('helvetica', 'bold');
                    doc.text(title, 16, y + 1);
                    y += 9;
                }

                function row(lbl, val, lbl2, val2) {
                    doc.setFontSize(8);
                    doc.setFont('helvetica', 'bold');
                    doc.setTextColor(75, 85, 99);
                    doc.text(lbl, 16, y);
                    doc.setFont('helvetica', 'normal');
                    doc.setTextColor(17, 24, 39);
                    doc.text(nd(val), 70, y);
                    if (lbl2) {
                        doc.setFont('helvetica', 'bold');
                        doc.setTextColor(75, 85, 99);
                        doc.text(lbl2, 115, y);
                        doc.setFont('helvetica', 'normal');
                        doc.setTextColor(17, 24, 39);
                        doc.text(nd(val2), 165, y);
                    }
                    y += 6;
                }

                function divider() {
                    doc.setDrawColor(229, 231, 235);
                    doc.line(14, y, W - 14, y);
                    y += 5;
                }

                // 1. Dimensi Utama
                sectionTitle('1. DIMENSI UTAMA PALET');
                row('Panjang', d.dimensi_panjang ? (d.dimensi_panjang * 10) + ' mm (' + d.dimensi_panjang + ' cm)' : null,
                    'Lebar', d.dimensi_lebar ? (d.dimensi_lebar * 10) + ' mm (' + d.dimensi_lebar + ' cm)' : null);
                divider();

                // 2. Papan Atas
                sectionTitle('2. PAPAN ATAS (DECK)');
                row('Jumlah', d.papan_atas_jumlah ? d.papan_atas_jumlah + ' pcs' : null,
                    'Arah', d.papan_atas_arah ? (d.papan_atas_arah === 'x' ? 'Melintang' : 'Membujur') : null);
                row('Tebal', d.papan_atas_tebal ? d.papan_atas_tebal + ' cm' : null,
                    'Lebar', d.papan_atas_lebar ? d.papan_atas_lebar + ' cm' : null);
                row('Gap antar papan', d.papan_atas_gap ? d.papan_atas_gap + ' cm' : null, '', null);
                divider();

                // 3. Lapisan Tengah
                sectionTitle('3. LAPISAN TENGAH (STRINGER)');
                row('Tipe', nd(d.lapisan_tengah_tipe), 'Susunan', nd(d.lapisan_tengah_susunan));
                row('Jumlah', d.lapisan_tengah_jumlah ? d.lapisan_tengah_jumlah + ' balok' : null,
                    'Arah', d.lapisan_tengah_arah ? (d.lapisan_tengah_arah === 'x' ? 'Melintang' : 'Membujur') : null);
                row('Tinggi', d.lapisan_tengah_tinggi ? d.lapisan_tengah_tinggi + ' cm' : null,
                    'Lebar', d.lapisan_tengah_lebar ? d.lapisan_tengah_lebar + ' cm' : null);
                divider();

                // 4. Papan Bawah
                sectionTitle('4. PAPAN BAWAH (BOTTOM DECK)');
                row('Jumlah', d.papan_bawah_jumlah ? d.papan_bawah_jumlah + ' pcs' : null,
                    'Arah', d.papan_bawah_arah ? (d.papan_bawah_arah === 'x' ? 'Melintang' : 'Membujur') : null);
                row('Tebal', d.papan_bawah_tebal ? d.papan_bawah_tebal + ' cm' : null,
                    'Lebar', d.papan_bawah_lebar ? d.papan_bawah_lebar + ' cm' : null);
                row('Pola', nd(d.papan_bawah_pola), 'Gap manual', d.papan_bawah_gap_manual ? d.papan_bawah_gap_manual + ' cm' : null);
                divider();

                // 5. Kalibrasi & Mode
                sectionTitle('5. KALIBRASI & MODE TRACKING');
                row('Lebar tangan', d.kalibrasi_lebar_tangan ? d.kalibrasi_lebar_tangan + ' cm' : null,
                    'Mode', d.mode_tracking ? (d.mode_tracking === 'mode1' ? 'Mode 1 \u2014 Gestur' : 'Mode 2 \u2014 Virtual Keyboard') : null);
                divider();

                // 6. Gesture ML
                sectionTitle('6. DIMENSI TERDETEKSI (HAND GESTURE ML)');
                row('X \u2014 Panjang', d.gesture_x ? d.gesture_x + ' mm' : null,
                    'Y \u2014 Lebar', d.gesture_y ? d.gesture_y + ' mm' : null);
                row('Z \u2014 Tinggi', d.gesture_z ? d.gesture_z + ' mm' : null, '', null);
                divider();

                // 7. Hasil Kalkulasi
                var hk = d.hasil_kalkulasi;
                if (typeof hk === 'string') {
                    try {
                        hk = JSON.parse(hk);
                    } catch (e) {
                        hk = null;
                    }
                }
                if (hk) {
                    sectionTitle('7. HASIL KALKULASI');
                    if (hk.total_tinggi_cm) row('Total Tinggi', (hk.total_tinggi_cm * 10).toFixed(0) + ' mm (' + hk.total_tinggi_cm + ' cm)', '', null);
                    if (hk.papan_atas_n) row('Papan Atas', hk.papan_atas_n + ' pcs \u00b7 p=' + nd(hk.papan_atas_len) + ' cm', '', null);
                    if (hk.balok_n) row('Balok', hk.balok_n + ' pcs \u00b7 p=' + nd(hk.balok_len) + ' cm', '', null);
                    if (hk.papan_bawah_n) row('Papan Bawah', hk.papan_bawah_n + ' pcs \u00b7 p=' + nd(hk.papan_bawah_len) + ' cm', '', null);
                    if (hk.rekap_material) {
                        y += 2;
                        doc.setFontSize(7.5);
                        doc.setFont('helvetica', 'bold');
                        doc.setTextColor(75, 85, 99);
                        doc.text('Rekap Material:', 16, y);
                        y += 5;
                        doc.setFont('helvetica', 'normal');
                        doc.setTextColor(55, 65, 81);
                        var lines = doc.splitTextToSize(hk.rekap_material.replace(/<[^>]+>/g, ''), W - 32);
                        doc.text(lines, 16, y);
                        y += lines.length * 5;
                    }
                    divider();
                }

                // Footer
                var pH = doc.internal.pageSize.getHeight();
                doc.setFillColor(248, 250, 252);
                doc.rect(0, pH - 12, W, 12, 'F');
                doc.setDrawColor(226, 232, 240);
                doc.line(0, pH - 12, W, pH - 12);
                doc.setFontSize(7);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(148, 163, 184);
                doc.text('PaletView\u2122 3D \u2014 PT. Kemas Kayu Indonesia \u00b7 Dokumen digenerate otomatis dari dashboard', 14, pH - 5);
                doc.text('Hal. 1', W - 18, pH - 5);

                // Nama file
                var dimLbl = (d.dimensi_panjang && d.dimensi_lebar) ?
                    '_' + (d.dimensi_panjang * 10) + 'x' + (d.dimensi_lebar * 10) + 'mm' : '';
                doc.save('DesainPalet' + dimLbl + '_' + new Date().toISOString().slice(0, 10) + '.pdf');
            };

            document.addEventListener('DOMContentLoaded', function() {
                pvRefreshTable();
            });

            /* Auto-refresh tabel setiap 30 detik */
            setInterval(pvRefreshTable, 30000);

            /* Expose ke global supaya tombol Refresh bisa memanggil */
            window.pvRefreshTable = pvRefreshTable;

        })();

        // upload gambar
        const fileInput = document.getElementById('fileInput');
        const dropzone = document.getElementById('dropzone');
        const uploadIcon = document.getElementById('uploadIcon');
        const statusText = document.getElementById('statusText');
        const subText = document.getElementById('subText');

        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                const fileName = this.files[0].name;

                // Ubah Tampilan saat file terpilih
                dropzone.classList.remove('border-gray-200');
                dropzone.classList.add('border-blue-400', 'bg-blue-50/50');

                uploadIcon.classList.remove('text-gray-300');
                uploadIcon.classList.add('text-blue-500');

                // Tampilkan Nama File
                statusText.innerHTML = `<span class="text-blue-600 font-black uppercase text-[10px] italic">File Terpilih:</span><br><span class="text-slate-800 font-bold">${fileName}</span>`;
                statusText.classList.remove('text-gray-400', 'italic');

                subText.innerText = "Klik kembali jika ingin mengganti file";
            } else {
                // Reset ke tampilan awal jika batal pilih
                dropzone.classList.add('border-gray-200');
                dropzone.classList.remove('border-blue-400', 'bg-blue-50/50');

                uploadIcon.classList.add('text-gray-300');
                uploadIcon.classList.remove('text-blue-500');

                statusText.innerText = "Klik atau drag file ke sini";
                statusText.classList.add('text-gray-400', 'italic');

                subText.innerText = "PDF, JPG, PNG up to 10MB";
            }
        });

        // pagination not refresh
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('requests-table-wrapper');
            const link = e.target.closest('#requests-table-wrapper .requests-pagination a');

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
                    const newWrapper = doc.getElementById('requests-table-wrapper');
                    if (newWrapper) {
                        wrapper.innerHTML = newWrapper.innerHTML;
                    }
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