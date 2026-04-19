<x-app-layout>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Title -->
            <h2 class="text-2xl font-bold mb-6">Dashboard Client</h2>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Card 1 -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-gray-500 text-sm">Total Produksi</h3>
                    <p class="text-2xl font-bold">1200</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-gray-500 text-sm">Stok Pallet</h3>
                    <p class="text-2xl font-bold">530</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-gray-500 text-sm">Client Aktif</h3>
                    <p class="text-2xl font-bold">25</p>
                </div>

            </div>

            <!-- Table -->
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
                        <tr class="border-b">
                            <td class="py-2">10 Apr 2026</td>
                            <td>Produksi Pallet</td>
                            <td class="text-green-500">Selesai</td>
                        </tr>
                        <tr>
                            <td class="py-2">9 Apr 2026</td>
                            <td>Pengiriman</td>
                            <td class="text-yellow-500">Proses</td>
                        </tr>
                    </tbody>
                </table>
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
                            </tr>
                        </thead>
                        <tbody id="pv-table-body" class="divide-y divide-gray-100">
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-gray-400 text-sm">
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
    </style>

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
            var API_SYNC = '/api/palet/sync';
            var API_LIST = '/api/palet/designs';

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
                        if (tbody) tbody.innerHTML = '<tr><td colspan="8" class="px-4 py-6 text-center text-red-400 text-sm">Gagal memuat data: ' + err.message + '</td></tr>';
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

            function pvRenderTable(data) {
                var tbody = document.getElementById('pv-table-body');
                var info = document.getElementById('pv-table-info');
                if (!tbody) return;

                if (!data || data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="8" class="px-4 py-8 text-center text-gray-400 text-sm"><div class="flex flex-col items-center gap-2"><span style="font-size:24px;">📭</span><span>Belum ada data — mulai input di PaletView di atas</span></div></td></tr>';
                    if (info) info.textContent = 'Menampilkan 0 data';
                    return;
                }

                var rows = data.map(function(d) {
                    var waktu = d.last_updated_at ?
                        new Date(d.last_updated_at).toLocaleString('id-ID', {
                            day: '2-digit',
                            month: 'short',
                            hour: '2-digit',
                            minute: '2-digit'
                        }) :
                        '—';

                    // Dimensi utama
                    var dim = (d.dimensi_panjang && d.dimensi_lebar) ?
                        '<span class="pv-dim-cell">' + (d.dimensi_panjang * 10) + ' × ' + (d.dimensi_lebar * 10) + '</span>' :
                        '<span class="text-gray-300">—</span>';

                    // Papan atas
                    var pa = (d.papan_atas_jumlah) ?
                        '<span class="font-medium">' + d.papan_atas_jumlah + ' pcs</span>' +
                        '<div class="pv-sub">' +
                        pvNullDash(d.papan_atas_tebal) + '×' + pvNullDash(d.papan_atas_lebar) + ' cm' +
                        (d.papan_atas_arah ? ' · ' + (d.papan_atas_arah === 'x' ? '↔' : '↕') : '') +
                        '</div>' :
                        '<span class="text-gray-300">—</span>';

                    // Lapisan tengah
                    var lt = (d.lapisan_tengah_jumlah) ?
                        '<span class="font-medium">' + d.lapisan_tengah_jumlah + ' balok</span>' +
                        '<div class="pv-sub">' +
                        pvNullDash(d.lapisan_tengah_tinggi) + '×' + pvNullDash(d.lapisan_tengah_lebar) + ' cm' +
                        (d.lapisan_tengah_tipe ? ' · ' + d.lapisan_tengah_tipe : '') +
                        '</div>' :
                        '<span class="text-gray-300">—</span>';

                    // Papan bawah
                    var pb = (d.papan_bawah_jumlah) ?
                        '<span class="font-medium">' + d.papan_bawah_jumlah + ' pcs</span>' +
                        '<div class="pv-sub">' +
                        pvNullDash(d.papan_bawah_tebal) + '×' + pvNullDash(d.papan_bawah_lebar) + ' cm' +
                        (d.papan_bawah_pola ? ' · ' + d.papan_bawah_pola : '') +
                        '</div>' :
                        '<span class="text-gray-300">—</span>';

                    // Gesture
                    var gest = (d.gesture_x || d.gesture_y || d.gesture_z) ?
                        '<span style="font-family:monospace;font-size:11px;">' +
                        'X:' + pvNullDash(d.gesture_x) +
                        ' Y:' + pvNullDash(d.gesture_y) +
                        ' Z:' + pvNullDash(d.gesture_z) +
                        '</span>' :
                        '<span class="text-gray-300">—</span>';

                    // Total tinggi dari hasil_kalkulasi
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

                    // Mode badge
                    var modeBadge = d.mode_tracking ?
                        '<span class="pv-badge ' + (d.mode_tracking === 'mode1' ? 'pv-badge-blue' : 'pv-badge-green') + '">' +
                        (d.mode_tracking === 'mode1' ? '✌ Gestur' : '⌨ VKB') + '</span>' :
                        '<span class="pv-badge pv-badge-gray">—</span>';

                    return '<tr>' +
                        '<td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">' + waktu + '</td>' +
                        '<td class="px-4 py-3">' + dim + '</td>' +
                        '<td class="px-4 py-3 text-xs">' + pa + '</td>' +
                        '<td class="px-4 py-3 text-xs">' + lt + '</td>' +
                        '<td class="px-4 py-3 text-xs">' + pb + '</td>' +
                        '<td class="px-4 py-3 text-xs">' + gest + '</td>' +
                        '<td class="px-4 py-3 text-xs">' + tinggi + '</td>' +
                        '<td class="px-4 py-3 text-xs">' + modeBadge + '</td>' +
                        '</tr>';
                }).join('');

                tbody.innerHTML = rows;
                if (info) info.textContent = 'Menampilkan ' + data.length + ' data';
            }

            function pvNullDash(v) {
                return (v !== null && v !== undefined && v !== '') ? v : '—';
            }

            /* Muat tabel pertama kali saat halaman dibuka */
            document.addEventListener('DOMContentLoaded', function() {
                pvRefreshTable();
            });

            /* Auto-refresh tabel setiap 30 detik */
            setInterval(pvRefreshTable, 30000);

            /* Expose ke global supaya tombol Refresh bisa memanggil */
            window.pvRefreshTable = pvRefreshTable;

        })();
    </script>

</x-app-layout>