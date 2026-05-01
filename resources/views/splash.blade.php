<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPALET</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
</head>

<body class="bg-[#1E0F05] overflow-hidden">

    <div id="splash" class="relative min-h-screen flex items-center justify-center">
        <canvas id="woodCanvas" class="absolute inset-0 w-full h-full"></canvas>
        <div class="absolute inset-0 z-[1]" style="background:radial-gradient(ellipse at center,transparent 40%,rgba(10,4,1,0.82) 100%)"></div>
        <div class="absolute inset-0 z-[2] bg-black/55"></div>

        <div class="relative z-10 flex flex-col items-center gap-5">
            <div id="ring" class="absolute w-32 h-32 rounded-full border-2 border-[#C87941]/20 opacity-0"></div>
            <div id="logo-box"
                class="w-20 h-20 rounded-2xl flex items-center justify-center text-3xl font-extrabold text-[#FDF0E0] opacity-0"
                style="background:linear-gradient(135deg,#C87941,#7B3A10);box-shadow:0 8px 32px rgba(200,121,65,0.5);transform:scale(0.5)">S</div>
            <div id="logo-text" class="flex gap-[2px]">
                @foreach(['S','I','P','A','L','E','T'] as $l)
                <span class="letter text-3xl font-extrabold text-[#FDF0E0] tracking-tight"
                    style="opacity:0;transform:translateY(20px)">{{ $l }}</span>
                @endforeach
            </div>
            <p id="tagline" class="text-sm text-[#A07850] tracking-widest uppercase" style="opacity:0">
                Sistem Produksi Palet
            </p>
            <div class="w-40 h-[2px] bg-[#3A1F0A] rounded-full overflow-hidden mt-2">
                <div id="loading-bar" class="h-full rounded-full" style="width:0%;background:linear-gradient(90deg,#7B3A10,#C87941)"></div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            // Wood grain
            const canvas = document.getElementById('woodCanvas');
            const ctx = canvas.getContext('2d');

            function rand(a, b) {
                return Math.random() * (b - a) + a;
            }

            function drawWood() {
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
                        ctx.strokeStyle = `rgba(160,80,20,${rand(0.015, 0.07)})`;
                        ctx.lineWidth = rand(0.5, 1.5);
                        ctx.stroke();
                    }
                }
            }
            drawWood();
            window.addEventListener('resize', drawWood);

            // Anime.js timeline
            anime.timeline({
                    easing: 'easeOutExpo'
                })
                .add({
                    targets: '#logo-box',
                    opacity: [0, 1],
                    scale: [0.4, 1],
                    duration: 700,
                    delay: 300,
                })
                .add({
                    targets: '#ring',
                    opacity: [0.5, 0],
                    scale: [1, 2.4],
                    duration: 800,
                    easing: 'easeOutCubic',
                }, '-=400')
                .add({
                    targets: '.letter',
                    opacity: [0, 1],
                    translateY: [20, 0],
                    duration: 400,
                    delay: anime.stagger(60),
                    easing: 'easeOutBack',
                }, '-=300')
                .add({
                    targets: '#tagline',
                    opacity: [0, 1],
                    translateY: [10, 0],
                    duration: 500,
                }, '-=100')
                .add({
                    targets: '#loading-bar',
                    width: ['0%', '100%'],
                    duration: 1200,
                    easing: 'easeInOutQuad',
                }, '-=200')
                .add({
                    targets: '#splash',
                    opacity: [1, 0],
                    duration: 500,
                    easing: 'easeInQuad',
                    complete: function() {
                        window.location.href = "{{ route('home') }}";
                    }
                }, '+=200');
        })();
    </script>
</body>

</html>