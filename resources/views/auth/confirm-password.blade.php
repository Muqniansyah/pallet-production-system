<x-guest-layout>
    <div class="relative min-h-screen overflow-hidden flex items-center justify-center bg-[#1E0F05]">

        <canvas id="woodCanvas" class="absolute inset-0 w-full h-full"></canvas>
        <div class="absolute inset-0 z-[1]" style="background:radial-gradient(ellipse at center,transparent 40%,rgba(10,4,1,0.75) 100%)"></div>
        <div class="absolute inset-0 z-[2] bg-black/50"></div>

        <div class="relative z-10 w-full max-w-sm mx-auto px-4 py-10">

            <div class="flex flex-col items-center mb-7">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center text-lg font-extrabold text-[#FDF0E0] mb-3"
                    style="background:linear-gradient(135deg,#C87941,#7B3A10);box-shadow:0 4px 16px rgba(200,121,65,0.4)">S</div>
                <h2 class="text-2xl font-extrabold text-[#FDF0E0] tracking-tight">Konfirmasi Password</h2>
                <p class="text-sm text-[#A07850] mt-1.5 text-center max-w-xs">
                    Ini area aman. Konfirmasi password kamu sebelum melanjutkan.
                </p>
            </div>

            <div class="rounded-2xl p-6 border border-[#C87941]/15 bg-white/[0.04] backdrop-blur-sm">
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="mb-6">
                        <x-input-label for="password" :value="__('Password')"
                            class="block text-xs font-semibold text-[#C8A882] mb-1.5 uppercase tracking-wide" />
                        <x-text-input id="password"
                            class="block w-full bg-white/5 border border-[#C87941]/20 text-[#FDF0E0] rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#C87941]/60 focus:ring-1 focus:ring-[#C87941]/40 transition"
                            type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-400" />
                    </div>

                    <button type="submit"
                        class="w-full text-[#FDF0E0] font-bold text-sm py-2.5 rounded-xl transition-all hover:-translate-y-0.5 active:scale-[0.98]"
                        style="background:linear-gradient(135deg,#A0522D,#7B3A10);box-shadow:0 4px 16px rgba(120,50,10,0.5)">
                        🔒 Konfirmasi
                    </button>
                </form>
            </div>

        </div>
    </div>

    <style>
        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <script>
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
    </script>
</x-guest-layout>