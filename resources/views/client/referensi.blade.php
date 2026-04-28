<x-app-layout>
    <div class="py-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 space-y-4 md:space-y-0">
            <div>
                <h1 class="text-2xl font-black text-gray-800 tracking-tight">Referensi Produk</h1>
                <p class="text-sm text-gray-500 mt-1">Katalog standar palet kayu kualitas ekspor PT. Kemas Kayu Indonesia.</p>
            </div>
        </div>

        <!-- ===== CARD BOX JENIS KAYU ===== -->
        <div class="bg-white rounded-2xl shadow overflow-hidden" id="kayu-card">

            <!-- Card Title Bar -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center"
                        style="background: linear-gradient(135deg, #3d2008, #a0522d);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">Jenis Kayu yang Kami Sediakan</h3>
                        <p class="text-xs text-gray-400">Bahan baku pilihan bersertifikat ISPM 15</p>
                    </div>
                </div>
                <button id="kayu-launch-btn"
                    onclick="kayuLaunchSecure()"
                    class="text-xs font-medium px-4 py-2 rounded-lg text-white transition-all duration-200 hover:opacity-90 active:scale-95"
                    style="background: linear-gradient(135deg, #3d2008, #a0522d);">
                    ↗ Lihat Halaman Asli
                </button>
            </div>

            <!-- Content Container (fixed height, no scroll) -->
            <div class="relative w-full overflow-hidden" style="height: 520px;">

                <!-- ══ SPLASH SCREEN ══ -->
                <div id="kayu-splash"
                    class="absolute inset-0 z-20 flex flex-col items-center justify-center"
                    style="background: linear-gradient(160deg, #1a0a00 0%, #3d1f06 55%, #1a0a00 100%); overflow:hidden;">

                    <!-- Grid background animasi -->
                    <div style="
                        position:absolute;inset:0;z-index:0;
                        background-image:
                            linear-gradient(rgba(160,82,45,0.10) 1px,transparent 1px),
                            linear-gradient(90deg,rgba(160,82,45,0.10) 1px,transparent 1px);
                        background-size:38px 38px;
                        animation:kayuGridScroll 10s linear infinite;">
                    </div>

                    <!-- Glow orbs -->
                    <div style="position:absolute;width:320px;height:320px;border-radius:50%;
                        background:radial-gradient(circle,rgba(160,82,45,0.22) 0%,transparent 70%);
                        top:-90px;left:-70px;animation:kayuPulse 4s ease-in-out infinite;"></div>
                    <div style="position:absolute;width:260px;height:260px;border-radius:50%;
                        background:radial-gradient(circle,rgba(200,140,80,0.16) 0%,transparent 70%);
                        bottom:-60px;right:-50px;animation:kayuPulse 4s ease-in-out infinite 2.1s;"></div>

                    <!-- Icon kayu animasi -->
                    <div style="position:relative;z-index:10;margin-bottom:24px;">
                        <svg width="72" height="72" viewBox="0 0 72 72" fill="none"
                            style="animation:kayuFloat 3.2s ease-in-out infinite;filter:drop-shadow(0 0 16px rgba(160,82,45,0.75));">
                            <!-- Batang kayu isometrik -->
                            <ellipse cx="36" cy="16" rx="22" ry="9" fill="rgba(100,55,20,0.9)" stroke="#a0522d" stroke-width="1.2" />
                            <rect x="14" y="16" width="44" height="30" rx="1" fill="rgba(80,40,12,0.95)" stroke="#8b4513" stroke-width="1" />
                            <ellipse cx="36" cy="46" rx="22" ry="9" fill="rgba(120,65,25,0.95)" stroke="#a0522d" stroke-width="1.2" />
                            <!-- Serat kayu -->
                            <ellipse cx="36" cy="16" rx="14" ry="5.5" fill="none" stroke="rgba(200,140,80,0.35)" stroke-width="0.8" />
                            <ellipse cx="36" cy="16" rx="8" ry="3" fill="none" stroke="rgba(200,140,80,0.25)" stroke-width="0.6" />
                            <line x1="20" y1="25" x2="52" y2="25" stroke="rgba(180,120,60,0.2)" stroke-width="0.7" />
                            <line x1="20" y1="32" x2="52" y2="32" stroke="rgba(180,120,60,0.2)" stroke-width="0.7" />
                            <line x1="20" y1="39" x2="52" y2="39" stroke="rgba(180,120,60,0.2)" stroke-width="0.7" />
                        </svg>
                    </div>

                    <!-- Teks -->
                    <div style="position:relative;z-index:10;text-align:center;margin-bottom:22px;">
                        <div style="font-family:'Courier New',monospace;font-size:10px;letter-spacing:4px;color:#cd853f;text-transform:uppercase;margin-bottom:5px;opacity:0.85;">
                            Memuat Katalog
                        </div>
                        <div style="font-size:20px;font-weight:700;color:#f5e6d3;letter-spacing:0.5px;">
                            Jenis <span style="color:#cd853f;">Kayu</span>
                        </div>
                        <div style="font-size:11px;color:#a0784a;margin-top:3px;letter-spacing:2px;">
                            BAHAN BAKU BERSERTIFIKAT ISPM 15
                        </div>
                    </div>

                    <!-- Progress bar -->
                    <div style="position:relative;z-index:10;width:240px;margin-bottom:12px;">
                        <div style="width:100%;height:3px;background:rgba(255,255,255,0.07);border-radius:99px;overflow:hidden;">
                            <div id="kayu-bar" style="height:100%;width:0%;background:linear-gradient(90deg,#7c3a1e,#cd853f);border-radius:99px;transition:width 0.3s ease;"></div>
                        </div>
                    </div>

                    <!-- Status text -->
                    <div id="kayu-status" style="position:relative;z-index:10;font-size:10px;color:#6b4c2a;font-family:'Courier New',monospace;letter-spacing:1px;min-height:16px;">
                        Menginisialisasi...
                    </div>

                    <!-- Dots -->
                    <div style="position:relative;z-index:10;display:flex;gap:6px;margin-top:16px;">
                        <span style="width:5px;height:5px;border-radius:50%;background:#a0522d;animation:kayuDot 1.4s ease-in-out infinite 0s;"></span>
                        <span style="width:5px;height:5px;border-radius:50%;background:#a0522d;animation:kayuDot 1.4s ease-in-out infinite 0.2s;"></span>
                        <span style="width:5px;height:5px;border-radius:50%;background:#a0522d;animation:kayuDot 1.4s ease-in-out infinite 0.4s;"></span>
                    </div>
                </div>
                <!-- ══ END SPLASH ══ -->

                <!-- ══ KONTEN JENIS KAYU ══ -->
                <div id="kayu-content"
                    style="position:absolute;inset:0;z-index:10;opacity:0;transition:opacity 0.7s ease;
                            overflow:hidden;pointer-events:none;background:#fdfaf7;">

                    <!-- Header section dalam konten -->
                    <div style="background:linear-gradient(135deg,#3d1f06,#7c3a1e);padding:18px 24px 14px;">
                        <div style="font-size:10px;letter-spacing:3px;color:rgba(255,220,170,0.7);font-family:'Courier New',monospace;text-transform:uppercase;margin-bottom:4px;">PT. Menara Bekasi</div>
                        <div style="font-size:18px;font-weight:700;color:#fff;">Jenis Kayu yang Kami Sediakan</div>
                        <div style="font-size:11px;color:rgba(255,210,160,0.8);margin-top:3px;">Bahan baku pilihan · Bersertifikat ISPM 15 · Reg. ID-139</div>
                    </div>

                    <!-- Grid kartu kayu -->
                    <div style="padding:18px 20px;display:grid;grid-template-columns:repeat(3,1fr);gap:14px;height:calc(100% - 76px);overflow:hidden;">

                        <!-- Kayu 1: Racuk -->
                        <div style="background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 1px 6px rgba(0,0,0,0.08);border:1px solid #f0e8df;display:flex;flex-direction:column;">
                            <div style="height:120px;overflow:hidden;position:relative;background:#e8d5c0;">
                                <img src="https://menara-bekasi.web.app/images/tentang/kayu-racuk.jpg"
                                    alt="Kayu Racuk"
                                    style="width:100%;height:100%;object-fit:cover;display:block;"
                                    loading="lazy"
                                    onerror="this.style.display='none';this.parentElement.style.background='linear-gradient(135deg,#c4956a,#8b6347)';">
                            </div>
                            <div style="padding:10px 12px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                                <div>
                                    <div style="font-size:13px;font-weight:700;color:#3d1f06;margin-bottom:3px;">Kayu Racuk</div>
                                    <div style="font-size:10px;color:#7c5c3e;line-height:1.5;">Serbaguna dan kuat, cocok untuk konstruksi dan furnitur.</div>
                                </div>
                                <div style="margin-top:8px;">
                                    <span style="display:inline-block;background:#fef3e8;color:#a0522d;font-size:9px;font-family:'Courier New',monospace;letter-spacing:0.05em;padding:2px 8px;border-radius:99px;border:1px solid #f0d4b0;">ISPM 15 ✓</span>
                                </div>
                            </div>
                        </div>

                        <!-- Kayu 2: Mahoni -->
                        <div style="background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 1px 6px rgba(0,0,0,0.08);border:1px solid #f0e8df;display:flex;flex-direction:column;">
                            <div style="height:120px;overflow:hidden;position:relative;background:#d4b896;">
                                <img src="https://menara-bekasi.web.app/images/tentang/kayu-mahoni.jpg"
                                    alt="Kayu Mahoni"
                                    style="width:100%;height:100%;object-fit:cover;display:block;"
                                    loading="lazy"
                                    onerror="this.style.display='none';this.parentElement.style.background='linear-gradient(135deg,#8b2020,#c0503a)';">
                            </div>
                            <div style="padding:10px 12px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                                <div>
                                    <div style="font-size:13px;font-weight:700;color:#3d1f06;margin-bottom:3px;">Kayu Mahoni</div>
                                    <div style="font-size:10px;color:#7c5c3e;line-height:1.5;">Warna merah elegan, ideal untuk furnitur premium.</div>
                                </div>
                                <div style="margin-top:8px;">
                                    <span style="display:inline-block;background:#fef3e8;color:#a0522d;font-size:9px;font-family:'Courier New',monospace;letter-spacing:0.05em;padding:2px 8px;border-radius:99px;border:1px solid #f0d4b0;">ISPM 15 ✓</span>
                                </div>
                            </div>
                        </div>

                        <!-- Kayu 3: Meranti -->
                        <div style="background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 1px 6px rgba(0,0,0,0.08);border:1px solid #f0e8df;display:flex;flex-direction:column;">
                            <div style="height:120px;overflow:hidden;position:relative;background:#c8a87a;">
                                <img src="https://menara-bekasi.web.app/images/tentang/kayu-meranti.jpg"
                                    alt="Kayu Meranti"
                                    style="width:100%;height:100%;object-fit:cover;display:block;"
                                    loading="lazy"
                                    onerror="this.style.display='none';this.parentElement.style.background='linear-gradient(135deg,#b87333,#e8a050)';">
                            </div>
                            <div style="padding:10px 12px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                                <div>
                                    <div style="font-size:13px;font-weight:700;color:#3d1f06;margin-bottom:3px;">Kayu Meranti</div>
                                    <div style="font-size:10px;color:#7c5c3e;line-height:1.5;">Ringan namun tahan lama, cocok untuk panel dan kusen.</div>
                                </div>
                                <div style="margin-top:8px;">
                                    <span style="display:inline-block;background:#fef3e8;color:#a0522d;font-size:9px;font-family:'Courier New',monospace;letter-spacing:0.05em;padding:2px 8px;border-radius:99px;border:1px solid #f0d4b0;">ISPM 15 ✓</span>
                                </div>
                            </div>
                        </div>

                        <!-- Kayu 4: Jati -->
                        <div style="background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 1px 6px rgba(0,0,0,0.08);border:1px solid #f0e8df;display:flex;flex-direction:column;">
                            <div style="height:120px;overflow:hidden;position:relative;background:#b89060;">
                                <img src="https://menara-bekasi.web.app/images/tentang/kayu-jati.jpg"
                                    alt="Kayu Jati"
                                    style="width:100%;height:100%;object-fit:cover;display:block;"
                                    loading="lazy"
                                    onerror="this.style.display='none';this.parentElement.style.background='linear-gradient(135deg,#6b4c1e,#a0784a)';">
                            </div>
                            <div style="padding:10px 12px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                                <div>
                                    <div style="font-size:13px;font-weight:700;color:#3d1f06;margin-bottom:3px;">Kayu Jati</div>
                                    <div style="font-size:10px;color:#7c5c3e;line-height:1.5;">Paling premium dan tahan cuaca, cocok untuk outdoor.</div>
                                </div>
                                <div style="margin-top:8px;">
                                    <span style="display:inline-block;background:#fef3e8;color:#a0522d;font-size:9px;font-family:'Courier New',monospace;letter-spacing:0.05em;padding:2px 8px;border-radius:99px;border:1px solid #f0d4b0;">ISPM 15 ✓</span>
                                </div>
                            </div>
                        </div>

                        <!-- Kayu 5: Sengon -->
                        <div style="background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 1px 6px rgba(0,0,0,0.08);border:1px solid #f0e8df;display:flex;flex-direction:column;">
                            <div style="height:120px;overflow:hidden;position:relative;background:#d8c4a0;">
                                <img src="https://menara-bekasi.web.app/images/tentang/kayu-sengon.jpg"
                                    alt="Kayu Sengon"
                                    style="width:100%;height:100%;object-fit:cover;display:block;"
                                    loading="lazy"
                                    onerror="this.style.display='none';this.parentElement.style.background='linear-gradient(135deg,#c8b890,#a09060)';">
                            </div>
                            <div style="padding:10px 12px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                                <div>
                                    <div style="font-size:13px;font-weight:700;color:#3d1f06;margin-bottom:3px;">Kayu Sengon</div>
                                    <div style="font-size:10px;color:#7c5c3e;line-height:1.5;">Ringan dan mudah dibentuk, ideal untuk kemasan ekspor.</div>
                                </div>
                                <div style="margin-top:8px;">
                                    <span style="display:inline-block;background:#fef3e8;color:#a0522d;font-size:9px;font-family:'Courier New',monospace;letter-spacing:0.05em;padding:2px 8px;border-radius:99px;border:1px solid #f0d4b0;">ISPM 15 ✓</span>
                                </div>
                            </div>
                        </div>

                        <!-- Kayu 6: Kamper -->
                        <div style="background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 1px 6px rgba(0,0,0,0.08);border:1px solid #f0e8df;display:flex;flex-direction:column;">
                            <div style="height:120px;overflow:hidden;position:relative;background:#c0a070;">
                                <img src="https://menara-bekasi.web.app/images/tentang/kayu-kamper.jpg"
                                    alt="Kayu Kamper"
                                    style="width:100%;height:100%;object-fit:cover;display:block;"
                                    loading="lazy"
                                    onerror="this.style.display='none';this.parentElement.style.background='linear-gradient(135deg,#8b6914,#c8a030)';">
                            </div>
                            <div style="padding:10px 12px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                                <div>
                                    <div style="font-size:13px;font-weight:700;color:#3d1f06;margin-bottom:3px;">Kayu Kamper</div>
                                    <div style="font-size:10px;color:#7c5c3e;line-height:1.5;">Kuat dan awet, banyak dipakai untuk konstruksi.</div>
                                </div>
                                <div style="margin-top:8px;">
                                    <span style="display:inline-block;background:#fef3e8;color:#a0522d;font-size:9px;font-family:'Courier New',monospace;letter-spacing:0.05em;padding:2px 8px;border-radius:99px;border:1px solid #f0d4b0;">ISPM 15 ✓</span>
                                </div>
                            </div>
                        </div>

                    </div><!-- end grid -->
                </div>
                <!-- ══ END KONTEN ══ -->

            </div><!-- end container -->

            <!-- Log bar bawah -->
            <div id="kayu-log-bar"
                style="padding:7px 20px;background:#fdf8f4;border-top:1px solid #f5ede4;font-size:10px;color:#b0916e;font-family:'Courier New',monospace;display:flex;align-items:center;gap:8px;min-height:30px;">
                <span id="kayu-log-dot" style="width:6px;height:6px;border-radius:50%;background:#e8d5c0;flex-shrink:0;transition:background 0.3s;"></span>
                <span id="kayu-log-msg">Memuat katalog jenis kayu...</span>
            </div>

        </div>
        <!-- ===== END CARD BOX ===== -->

    </div>

    <!-- ===== STYLES ===== -->
    <style>
        @keyframes kayuGridScroll {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 38px 38px;
            }
        }

        @keyframes kayuPulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.6;
            }

            50% {
                transform: scale(1.14);
                opacity: 1;
            }
        }

        @keyframes kayuFloat {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-9px) rotate(2.5deg);
            }
        }

        @keyframes kayuDot {

            0%,
            80%,
            100% {
                transform: scale(0.6);
                opacity: 0.35;
            }

            40% {
                transform: scale(1.25);
                opacity: 1;
            }
        }
    </style>

    <!-- ===== SCRIPTS ===== -->
    <script>
        (function() {
            'use strict';

            /* ─── Obfuscated URL ────────────────────────────────────────────────
               URL target di-encode Base64, tidak pernah muncul sebagai plain text.
               Decode hanya terjadi di memori runtime, tepat saat tombol ditekan.
            ─────────────────────────────────────────────────────────────────── */
            var _e = 'aHR0cHM6Ly9tZW5hcmEtYmVrYXNpLndlYi5hcHAvdGVudGFuZw==';

            function _d() {
                try {
                    return atob(_e);
                } catch (x) {
                    return null;
                }
            }

            /* ─── DOM refs ───────────────────────────────────────────────────── */
            var _bar = document.getElementById('kayu-bar');
            var _status = document.getElementById('kayu-status');
            var _splash = document.getElementById('kayu-splash');
            var _content = document.getElementById('kayu-content');
            var _logDot = document.getElementById('kayu-log-dot');
            var _logMsg = document.getElementById('kayu-log-msg');

            /* ─── Splash sequence ────────────────────────────────────────────── */
            var _msgs = [
                'Memuat katalog kayu...',
                'Mengambil data bahan baku...',
                'Menyiapkan spesifikasi ISPM 15...',
                'Memuat galeri produk...',
                'Hampir selesai...',
            ];
            var _msgIdx = 0,
                _progress = 0,
                _started = false;

            function _step() {
                if (_progress >= 100) {
                    _reveal();
                    return;
                }
                _progress = Math.min(_progress + Math.floor(Math.random() * 20) + 8, 100);
                if (_bar) _bar.style.width = _progress + '%';
                if (_status && _msgs[_msgIdx]) {
                    _status.textContent = _msgs[_msgIdx];
                    _msgIdx = Math.min(_msgIdx + 1, _msgs.length - 1);
                }
                setTimeout(_step, Math.floor(Math.random() * 450) + 300);
            }

            function _reveal() {
                if (_status) _status.textContent = 'Siap!';
                if (_bar) _bar.style.width = '100%';
                setTimeout(function() {
                    // Sembunyikan splash
                    if (_splash) {
                        _splash.style.transition = 'opacity 0.65s ease';
                        _splash.style.opacity = '0';
                        setTimeout(function() {
                            if (_splash) _splash.style.display = 'none';
                        }, 660);
                    }
                    // Tampilkan konten
                    if (_content) {
                        _content.style.opacity = '1';
                        _content.style.pointerEvents = 'none'; // tetap non-interaktif agar tidak bisa di-tab/klik link
                    }
                    _setLog('hijau', '✓ Katalog kayu dimuat — sumber: PT. Menara Bekasi');
                }, 300);
            }

            function _setLog(w, msg) {
                var c = {
                    hijau: '#22c55e',
                    merah: '#ef4444',
                    kuning: '#f59e0b',
                    abu: '#e8d5c0'
                };
                if (_logDot) _logDot.style.background = c[w] || c.abu;
                if (_logMsg) _logMsg.textContent = msg;
            }

            /* Mulai saat card masuk viewport */
            var _card = document.getElementById('kayu-card');
            if (_card && 'IntersectionObserver' in window) {
                var _obs = new IntersectionObserver(function(entries) {
                    entries.forEach(function(e) {
                        if (e.isIntersecting && !_started) {
                            _started = true;
                            setTimeout(_step, 400);
                            _obs.disconnect();
                        }
                    });
                }, {
                    threshold: 0.15
                });
                _obs.observe(_card);
            } else {
                setTimeout(_step, 600);
            }

            /* ─── Tombol "Lihat Halaman Asli" (obfuscated) ───────────────────── */
            window.kayuLaunchSecure = function() {
                var url = _d();
                if (!url) return;
                var w = window.open('about:blank', '_blank', 'noopener,noreferrer');
                if (w) {
                    try {
                        w.document.open();
                        w.document.write(
                            '<!DOCTYPE html><html><head>' +
                            '<meta http-equiv="refresh" content="0;url=' + url + '">' +
                            '<title>Redirecting...</title></head><body></body></html>'
                        );
                        w.document.close();
                    } catch (ex) {
                        w.location.href = url;
                    }
                }
            };

            /* ─── Proteksi anti-inspect pada card ───────────────────────────── */
            if (_card) {
                // Blokir klik kanan
                _card.addEventListener('contextmenu', function(ev) {
                    ev.preventDefault();
                    return false;
                });

                // Blokir drag gambar
                _card.addEventListener('dragstart', function(ev) {
                    ev.preventDefault();
                    return false;
                });
            }

            // Blokir shortcut DevTools
            document.addEventListener('keydown', function(ev) {
                var k = ev.key || '';
                if (
                    ev.keyCode === 123 ||
                    (ev.ctrlKey && ev.shiftKey && ['I', 'i', 'J', 'j', 'C', 'c'].includes(k)) ||
                    (ev.ctrlKey && ['U', 'u'].includes(k))
                ) {
                    ev.preventDefault();
                    ev.stopPropagation();
                    return false;
                }
            }, true);

            // Debugger heartbeat
            (function _hb() {
                (function() {
                    var d = new Date();
                    debugger; // eslint-disable-line no-debugger
                    if (new Date() - d > 100) {
                        // DevTools terdeteksi — sembunyikan konten
                        if (_content) _content.style.opacity = '0';
                    }
                })();
                setTimeout(_hb, 3000);
            })();

        })();
    </script>

</x-app-layout>