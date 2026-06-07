<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPALET</title>

    <!-- Mengaktifkan Tailwind CSS dan Alpine.js -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Library animasi Anime.js versi 3 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
</head>

<body class="bg-[#1E0F05] overflow-hidden">
    <div id="splash" class="relative min-h-screen flex items-center justify-center">
        <!-- Background Utama Tekstur/Animasi Kayu (via JavaScript) -->
        <canvas id="woodCanvas" class="absolute inset-0 w-full h-full"></canvas>
        <!-- Efek Cahaya Fokus terang di tengah, gelap di pinggir (Vignette) -->
        <div class="absolute inset-0 z-[1]" style="background:radial-gradient(ellipse at center,transparent 40%,rgba(10,4,1,0.82) 100%)"></div>
        <!-- Lapisan Gelap Menurunkan kontras background agar teks mudah dibaca -->
        <div class="absolute inset-0 z-[2] bg-black/55"></div>

        <!-- Konten utama splash screen -->
        <div class="relative z-10 flex flex-col items-center gap-5">
            <!-- Animasi ring melingkar di belakang logo -->
            <div id="ring" class="absolute w-32 h-32 rounded-full border-2 border-[#C87941]/20 opacity-0"></div>

            <!-- Kotak logo dengan huruf S -->
            <div id="logo-box"
                class="w-20 h-20 rounded-2xl flex items-center justify-center text-3xl font-extrabold text-[#FDF0E0] opacity-0"
                style="background:linear-gradient(135deg,#C87941,#7B3A10);box-shadow:0 8px 32px rgba(200,121,65,0.5);transform:scale(0.5)">S</div>

            <!-- Teks SIPALET yang muncul huruf per huruf -->
            <div id="logo-text" class="flex gap-[2px]">
                @foreach(['S','I','P','A','L','E','T'] as $l)
                <span class="letter text-3xl font-extrabold text-[#FDF0E0] tracking-tight"
                    style="opacity:0;transform:translateY(20px)">{{ $l }}</span>
                @endforeach
            </div>

            <!-- Tagline aplikasi -->
            <p id="tagline" class="text-sm text-[#A07850] tracking-widest uppercase" style="opacity:0">
                Sistem Produksi Palet
            </p>

            <!-- Loading bar -->
            <div class="w-40 h-[2px] bg-[#3A1F0A] rounded-full overflow-hidden mt-2">
                <div id="loading-bar" class="h-full rounded-full" style="width:0%;background:linear-gradient(90deg,#7B3A10,#C87941)"></div>
            </div>
        </div>
    </div>

    <script>
        // Membuat efek tekstur serat kayu pada canvas
        (function() {
            // Ambil elemen canvas dan context 2D
            const canvas = document.getElementById('woodCanvas');
            const ctx = canvas.getContext('2d');

            // fungsi: Menghasilkan angka acak dalam rentang tertentu
            function rand(a, b) {
                return Math.random() * (b - a) + a;
            }

            // Fungsi: Menggambar latar belakang dan pola serat kayu
            function drawWood() {
                // Menyesuaikan ukuran canvas dengan ukuran parent element
                const W = canvas.width = canvas.parentElement.offsetWidth;
                const H = canvas.height = canvas.parentElement.offsetHeight;

                // Membuat gradien warna latar belakang kayu gelap
                const g = ctx.createLinearGradient(0, 0, W, H);
                g.addColorStop(0, '#2A1206');
                g.addColorStop(0.3, '#1E0D04');
                g.addColorStop(0.6, '#2C1508');
                g.addColorStop(1, '#180A02');
                ctx.fillStyle = g;
                ctx.fillRect(0, 0, W, H);

                // Menggambar garis serat kayu secara acak
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

                // Menggambar pola lingkaran serat kayu (annual rings)
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

            // Jalankan drawWood saat pertama kali dimuat
            drawWood();
            // Gambar ulang saat ukuran layar berubah
            window.addEventListener('resize', drawWood);

            // Animasi splash screen menggunakan Anime.js timeline
            anime.timeline({
                    easing: 'easeOutExpo'
                })
                // Animasi logo box muncul
                .add({
                    targets: '#logo-box',
                    opacity: [0, 1],
                    scale: [0.4, 1],
                    duration: 700,
                    delay: 300,
                })
                // Animasi ring memudar dan membesar
                .add({
                    targets: '#ring',
                    opacity: [0.5, 0],
                    scale: [1, 2.4],
                    duration: 800,
                    easing: 'easeOutCubic',
                }, '-=400')
                // Animasi huruf SIPALET muncul satu per satu
                .add({
                    targets: '.letter',
                    opacity: [0, 1],
                    translateY: [20, 0],
                    duration: 400,
                    delay: anime.stagger(60),
                    easing: 'easeOutBack',
                }, '-=300')
                // Animasi tagline muncul
                .add({
                    targets: '#tagline',
                    opacity: [0, 1],
                    translateY: [10, 0],
                    duration: 500,
                }, '-=100')
                // Animasi loading bar berjalan
                .add({
                    targets: '#loading-bar',
                    width: ['0%', '100%'],
                    duration: 1200,
                    easing: 'easeInOutQuad',
                }, '-=200')
                // Animasi splash screen menghilang lalu redirect ke halaman utama
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
