<x-guest-layout>
    <div class="relative min-h-screen overflow-hidden flex items-center justify-center bg-[#1E0F05]">

        <canvas id="woodCanvas" class="absolute inset-0 w-full h-full"></canvas>
        <div class="absolute inset-0 z-[1]" style="background:radial-gradient(ellipse at center,transparent 40%,rgba(10,4,1,0.75) 100%)"></div>
        <div class="absolute inset-0 z-[2] bg-black/50"></div>

        <div class="relative z-10 w-full max-w-sm mx-auto px-4 py-10">

            <div class="flex flex-col items-center mb-7">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center text-lg font-extrabold text-[#FDF0E0] mb-3"
                    style="background:linear-gradient(135deg,#C87941,#7B3A10);box-shadow:0 4px 16px rgba(200,121,65,0.4)">S</div>
                <h2 class="text-2xl font-extrabold text-[#FDF0E0] tracking-tight">Daftar Akun SIPALET</h2>
                <p class="text-sm text-[#A07850] mt-1">Buat akun baru Anda</p>
            </div>

            <div class="rounded-2xl p-6 border border-[#C87941]/15 bg-white/[0.04] backdrop-blur-sm">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Nama --}}
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama Lengkap')"
                            class="block text-xs font-semibold text-[#C8A882] mb-1.5 uppercase tracking-wide" />
                        <x-text-input id="name"
                            class="block w-full bg-white/5 border border-[#C87941]/20 text-[#FDF0E0] rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#C87941]/60 focus:ring-1 focus:ring-[#C87941]/40 transition"
                            type="text" name="name" :value="old('name')" required autofocus
                            placeholder="Masukkan nama lengkap" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs text-red-400" />
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Alamat Email')"
                            class="block text-xs font-semibold text-[#C8A882] mb-1.5 uppercase tracking-wide" />
                        <x-text-input id="email"
                            class="block w-full bg-white/5 border border-[#C87941]/20 text-[#FDF0E0] rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#C87941]/60 focus:ring-1 focus:ring-[#C87941]/40 transition"
                            type="email" name="email" :value="old('email')" required
                            placeholder="contoh@email.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-400" />
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password')"
                            class="block text-xs font-semibold text-[#C8A882] mb-1.5 uppercase tracking-wide" />
                        <div class="relative">
                            <x-text-input id="password"
                                class="block w-full bg-white/5 border border-[#C87941]/20 text-[#FDF0E0] rounded-lg px-3.5 py-2.5 pr-10 text-sm focus:outline-none focus:border-[#C87941]/60 focus:ring-1 focus:ring-[#C87941]/40 transition"
                                type="password" name="password" required
                                placeholder="Min. 8 karakter"
                                oninput="checkPasswordStrength(this.value)" />
                            {{-- Toggle show/hide --}}
                            <button type="button" onclick="togglePassword('password', 'eyeIcon1')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#A07850] hover:text-[#C87941] transition">
                                <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>

                        {{-- Indikator kekuatan password --}}
                        <div class="mt-2 space-y-1.5" id="strengthBox" style="display:none;">
                            {{-- Bar kekuatan --}}
                            <div class="flex gap-1">
                                <div id="bar1" class="h-1 flex-1 rounded-full bg-white/10 transition-all duration-300"></div>
                                <div id="bar2" class="h-1 flex-1 rounded-full bg-white/10 transition-all duration-300"></div>
                                <div id="bar3" class="h-1 flex-1 rounded-full bg-white/10 transition-all duration-300"></div>
                                <div id="bar4" class="h-1 flex-1 rounded-full bg-white/10 transition-all duration-300"></div>
                            </div>
                            <p id="strengthLabel" class="text-[10px] font-bold uppercase tracking-widest"></p>

                            {{-- Checklist syarat --}}
                            <div class="grid grid-cols-2 gap-x-3 gap-y-0.5 mt-1">
                                <div id="req-len" class="flex items-center gap-1.5 text-[10px] text-white/30 transition-colors"><span class="req-icon">○</span> Min. 8 karakter</div>
                                <div id="req-upper" class="flex items-center gap-1.5 text-[10px] text-white/30 transition-colors"><span class="req-icon">○</span> Huruf besar (A-Z)</div>
                                <div id="req-lower" class="flex items-center gap-1.5 text-[10px] text-white/30 transition-colors"><span class="req-icon">○</span> Huruf kecil (a-z)</div>
                                <div id="req-num" class="flex items-center gap-1.5 text-[10px] text-white/30 transition-colors"><span class="req-icon">○</span> Angka (0-9)</div>
                                <div id="req-sym" class="flex items-center gap-1.5 text-[10px] text-white/30 transition-colors col-span-2"><span class="req-icon">○</span> Simbol (!@#$%^&*)</div>
                            </div>
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-400" />
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="mb-6">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')"
                            class="block text-xs font-semibold text-[#C8A882] mb-1.5 uppercase tracking-wide" />
                        <div class="relative">
                            <x-text-input id="password_confirmation"
                                class="block w-full bg-white/5 border border-[#C87941]/20 text-[#FDF0E0] rounded-lg px-3.5 py-2.5 pr-10 text-sm focus:outline-none focus:border-[#C87941]/60 focus:ring-1 focus:ring-[#C87941]/40 transition"
                                type="password" name="password_confirmation" required
                                placeholder="Ulangi password"
                                oninput="checkConfirm(this.value)" />
                            <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#A07850] hover:text-[#C87941] transition">
                                <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        <p id="confirmMsg" class="mt-1.5 text-[10px] font-semibold hidden"></p>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs text-red-400" />
                    </div>

                    <button type="submit"
                        class="w-full text-[#FDF0E0] font-bold text-sm py-2.5 rounded-xl transition-all hover:-translate-y-0.5 active:scale-[0.98]"
                        style="background:linear-gradient(135deg,#A0522D,#7B3A10);box-shadow:0 4px 16px rgba(120,50,10,0.5)">
                        Daftar Sekarang
                    </button>
                </form>
            </div>

            <p class="text-center text-sm text-[#7A5C3A] mt-5">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-[#C87941] hover:text-[#D4956A] font-semibold">Masuk</a>
            </p>
        </div>
    </div>

    <style>
        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .req-met {
            color: #4ade80 !important;
        }

        .req-fail {
            color: rgba(255, 255, 255, 0.25) !important;
        }
    </style>

    <script>
        /* ── Canvas wood grain ── */
        (function() {
            const canvas = document.getElementById('woodCanvas');
            const ctx = canvas.getContext('2d');

            function rand(a, b) {
                return Math.random() * (b - a) + a;
            }

            function draw() {
                const W = canvas.width = canvas.parentElement.offsetWidth;
                const H = canvas.height = canvas.parentElement.offsetHeight;
                const g = ctx.createLinearGradient(0, 0, W, H);
                g.addColorStop(0, '#2A1206');
                g.addColorStop(0.3, '#1E0D04');
                g.addColorStop(0.6, '#2C1508');
                g.addColorStop(1, '#180A02');
                ctx.fillStyle = g;
                ctx.fillRect(0, 0, W, H);
                for (let i = 0; i < 120; i++) {
                    const x = rand(0, W),
                        amp = rand(2, 18),
                        freq = rand(0.003, 0.012),
                        ph = rand(0, Math.PI * 2),
                        a = rand(0.04, 0.22);
                    ctx.beginPath();
                    ctx.moveTo(x, 0);
                    for (let y = 0; y <= H; y += 2) ctx.lineTo(x + amp * Math.sin(freq * y + ph) + (amp * 0.4) * Math.sin(freq * 2.3 * y + ph * 1.7), y);
                    ctx.strokeStyle = `rgba(130,65,15,${a})`;
                    ctx.lineWidth = rand(0.4, 2.8);
                    ctx.stroke();
                }
                for (let i = 0; i < 18; i++) {
                    const cx = rand(W * 0.1, W * 0.9),
                        cy = rand(-H * 0.3, H * 0.5),
                        mr = rand(30, 120);
                    for (let r = mr; r > 2; r -= rand(3, 8)) {
                        ctx.beginPath();
                        ctx.ellipse(cx, cy, r * rand(1.8, 3.5), r, rand(-0.2, 0.2), 0, Math.PI * 2);
                        ctx.strokeStyle = `rgba(160,80,20,${rand(0.015,0.07)})`;
                        ctx.lineWidth = rand(0.5, 1.5);
                        ctx.stroke();
                    }
                }
            }
            draw();
            window.addEventListener('resize', draw);
        })();

        /* ── Toggle show/hide password ── */
        function togglePassword(fieldId, iconId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);
            const isHidden = field.type === 'password';
            field.type = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden ?
                `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>` :
                `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
        }

        /* ── Cek kekuatan password ── */
        function checkPasswordStrength(val) {
            const box = document.getElementById('strengthBox');
            if (!val) {
                box.style.display = 'none';
                return;
            }
            box.style.display = 'block';

            const rules = {
                len: val.length >= 8,
                upper: /[A-Z]/.test(val),
                lower: /[a-z]/.test(val),
                num: /[0-9]/.test(val),
                sym: /[^A-Za-z0-9]/.test(val),
            };

            // Update checklist
            Object.keys(rules).forEach(function(key) {
                const el = document.getElementById('req-' + key);
                const icon = el.querySelector('.req-icon');
                if (rules[key]) {
                    el.className = el.className.replace('text-white/30', '') + ' req-met';
                    icon.textContent = '✓';
                } else {
                    el.className = el.className.replace('req-met', '') + ' text-white/30';
                    icon.textContent = '○';
                }
            });

            // Hitung skor
            const score = Object.values(rules).filter(Boolean).length;
            const bars = ['bar1', 'bar2', 'bar3', 'bar4'];
            const label = document.getElementById('strengthLabel');

            const config = [{
                    color: '#ef4444',
                    text: 'Sangat Lemah',
                    textColor: '#ef4444'
                },
                {
                    color: '#f97316',
                    text: 'Lemah',
                    textColor: '#f97316'
                },
                {
                    color: '#eab308',
                    text: 'Cukup',
                    textColor: '#eab308'
                },
                {
                    color: '#22c55e',
                    text: 'Kuat',
                    textColor: '#22c55e'
                },
                {
                    color: '#16a34a',
                    text: 'Sangat Kuat',
                    textColor: '#4ade80'
                },
            ];

            const cfg = config[Math.max(0, score - 1)] || config[0];

            bars.forEach(function(id, i) {
                const bar = document.getElementById(id);
                bar.style.background = i < score ? cfg.color : 'rgba(255,255,255,0.1)';
            });

            label.textContent = cfg.text;
            label.style.color = cfg.textColor;
        }

        /* ── Cek konfirmasi password ── */
        function checkConfirm(val) {
            const original = document.getElementById('password').value;
            const msg = document.getElementById('confirmMsg');
            if (!val) {
                msg.classList.add('hidden');
                return;
            }
            msg.classList.remove('hidden');
            if (val === original) {
                msg.textContent = '✓ Password cocok';
                msg.style.color = '#4ade80';
            } else {
                msg.textContent = '✗ Password tidak cocok';
                msg.style.color = '#f87171';
            }
        }
    </script>
</x-guest-layout>