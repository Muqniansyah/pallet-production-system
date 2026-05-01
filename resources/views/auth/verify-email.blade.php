<x-guest-layout>
    <div class="relative min-h-screen overflow-hidden flex items-center justify-center bg-[#1E0F05]">

        <canvas id="woodCanvas" class="absolute inset-0 w-full h-full"></canvas>
        <div class="absolute inset-0 z-[1]" style="background:radial-gradient(ellipse at center,transparent 40%,rgba(10,4,1,0.75) 100%)"></div>
        <div class="absolute inset-0 z-[2] bg-black/50"></div>

        <div class="relative z-10 w-full max-w-sm mx-auto px-4 py-10">

            <div class="flex flex-col items-center mb-7">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center text-lg font-extrabold text-[#FDF0E0] mb-3"
                    style="background:linear-gradient(135deg,#C87941,#7B3A10);box-shadow:0 4px 16px rgba(200,121,65,0.4)">S</div>
                <h2 class="text-2xl font-extrabold text-[#FDF0E0] tracking-tight">Verifikasi Email</h2>
                <p class="text-sm text-[#A07850] mt-1.5 text-center max-w-xs leading-relaxed">
                    Terima kasih telah mendaftar! Silakan verifikasi email kamu dengan mengklik link yang telah kami kirimkan. Jika tidak menerima email, kami akan mengirimkan yang baru.
                </p>
            </div>

            <div class="rounded-2xl p-6 border border-[#C87941]/15 bg-white/[0.04] backdrop-blur-sm">

                @if (session('status') == 'verification-link-sent')
                <div class="mb-5 flex items-start gap-2.5 bg-[#C87941]/10 border border-[#C87941]/25 rounded-lg px-4 py-3">
                    <span class="text-[#C87941] mt-0.5">✓</span>
                    <p class="text-sm text-[#C8A882]">
                        Link verifikasi baru telah dikirim ke email yang kamu daftarkan.
                    </p>
                </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-[#FDF0E0] font-bold text-sm py-2.5 rounded-xl transition-all hover:-translate-y-0.5 active:scale-[0.98] mb-3"
                        style="background:linear-gradient(135deg,#A0522D,#7B3A10);box-shadow:0 4px 16px rgba(120,50,10,0.5)">
                        ✉ Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-[#7A5C3A] text-sm font-medium py-2.5 rounded-xl border border-[#C87941]/15 bg-transparent hover:text-[#C8A882] hover:border-[#C87941]/30 transition-all">
                        Keluar
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