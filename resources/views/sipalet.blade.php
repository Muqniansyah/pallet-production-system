<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .lp-wrap {
        font-family: 'Plus Jakarta Sans', sans-serif;
        min-height: 580px;
        overflow: hidden;
        position: relative;
        border-radius: 12px;
        background-color: #1E0F05;
    }

    #woodCanvas {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }

    .vignette {
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at center, transparent 40%, rgba(10, 4, 1, 0.75) 100%);
        z-index: 1;
    }

    .dark-overlay {
        position: absolute;
        inset: 0;
        background: rgba(15, 7, 2, 0.55);
        z-index: 2;
    }

    .nav {
        position: relative;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 32px;
        opacity: 0;
        transform: translateY(-20px);
        animation: slideDown 0.6s ease forwards 0.2s;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #F5DEB3;
        font-weight: 800;
        font-size: 18px;
        letter-spacing: -0.5px;
    }

    .logo-icon {
        width: 34px;
        height: 34px;
        background: linear-gradient(135deg, #C87941, #7B3A10);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 800;
        color: #FDF0E0;
        box-shadow: 0 2px 12px rgba(200, 121, 65, 0.4);
    }

    .nav-badge {
        background: rgba(200, 121, 65, 0.15);
        border: 1px solid rgba(200, 121, 65, 0.35);
        color: #D4956A;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
        letter-spacing: 0.5px;
    }

    .hero {
        position: relative;
        z-index: 10;
        padding: 44px 32px 48px;
        max-width: 680px;
        margin: 0 auto;
        text-align: center;
    }

    .tag-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(200, 121, 65, 0.15);
        border: 1px solid rgba(200, 121, 65, 0.35);
        color: #C87941;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 14px;
        border-radius: 20px;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeUp 0.6s ease forwards 0.4s;
        margin-bottom: 20px;
    }

    .tag-dot {
        width: 6px;
        height: 6px;
        background: #C87941;
        border-radius: 50%;
    }

    .hero-title {
        color: #FDF0E0;
        font-size: 42px;
        font-weight: 800;
        line-height: 1.1;
        letter-spacing: -1.5px;
        margin-bottom: 8px;
        text-shadow: 0 2px 20px rgba(0, 0, 0, 0.6);
        opacity: 0;
        transform: translateY(24px);
        animation: fadeUp 0.7s ease forwards 0.5s;
    }

    .hero-sub {
        color: #D4854A;
        font-size: 42px;
        font-weight: 800;
        line-height: 1.1;
        letter-spacing: -1.5px;
        margin-bottom: 20px;
        text-shadow: 0 2px 20px rgba(0, 0, 0, 0.5);
        opacity: 0;
        transform: translateY(24px);
        animation: fadeUp 0.7s ease forwards 0.62s;
    }

    .hero-desc {
        color: #B8916A;
        font-size: 15px;
        line-height: 1.75;
        max-width: 440px;
        margin: 0 auto 32px;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeUp 0.6s ease forwards 0.75s;
    }

    .cta-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeUp 0.6s ease forwards 0.9s;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #A0522D, #7B3A10);
        color: #FDF0E0;
        font-family: inherit;
        font-size: 14px;
        font-weight: 700;
        padding: 12px 24px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(120, 50, 10, 0.5);
        transition: transform 0.15s, box-shadow 0.15s;
        text-decoration: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(120, 50, 10, 0.6);
    }

    .btn-ghost {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(4px);
        color: #C8A882;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        padding: 12px 20px;
        border-radius: 10px;
        border: 1px solid rgba(200, 168, 130, 0.28);
        cursor: pointer;
        transition: border-color 0.2s, color 0.2s, transform 0.15s;
        text-decoration: none;
    }

    .btn-ghost:hover {
        border-color: rgba(200, 168, 130, 0.55);
        color: #FDF0E0;
        transform: translateY(-2px);
    }

    .feature-strip {
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
        padding: 24px 32px 32px;
        /* border-top: 1px solid rgba(200, 150, 80, 0.1); */
        position: relative;
        z-index: 10;
        opacity: 0;
        animation: fadeUp 0.6s ease forwards 1.05s;
    }

    .feat-tag {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(200, 150, 80, 0.15);
        color: #806040;
        font-size: 12px;
        font-weight: 500;
        padding: 5px 12px;
        border-radius: 6px;
    }

    .feat-tag span {
        color: #C87941;
        margin-right: 5px;
    }

    @keyframes fadeUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideDown {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<title>{{ config('app.name', 'Laravel') }}</title>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

<canvas id="woodCanvas"></canvas>
<div class="vignette"></div>
<div class="dark-overlay"></div>

<nav class="nav">
    <div class="logo">
        <div class="logo-icon">S</div>
        SIPALET
    </div>
    <div class="nav-badge">SISTEM PRODUKSI PALET</div>
</nav>

<section class="hero">
    <div class="tag-pill">
        <div class="tag-dot"></div>
        Platform Manajemen Palet Indonesia
    </div>
    <h1 class="hero-title">Kelola produksi</h1>
    <div class="hero-sub">lebih cerdas &amp; efisien</div>
    <p class="hero-desc">
        SIPALET adalah platform terintegrasi untuk mengelola produksi palet. mulai dari kustomisasi desain, penjadwalan meeting, hingga transparansi kalkulasi HPP dalam satu sistem yang presisi.
    </p>
    <div class="cta-row">
        <a href="{{ route('login') }}" class="btn-primary">&#9654; Mulai Sekarang</a>
        <a href="{{ route('register') }}" class="btn-ghost">Daftar Gratis ↓</a>
    </div>
</section>

<div class="feature-strip">
    <div class="feat-tag"><span>✓</span>Custom Design Pallet</div>
    <div class="feat-tag"><span>✓</span>Transparansi HPP</div>
    <div class="feat-tag"><span>✓</span>Jadwal Meeting Instan</div>
    <div class="feat-tag"><span>✓</span>Monitoring Produksi</div>
    <div class="feat-tag"><span>✓</span>Arsip Dokumen Digital</div>
</div>

<script>
    (function() {
        const canvas = document.getElementById('woodCanvas');
        const ctx = canvas.getContext('2d');

        function resize() {
            const wrap = canvas.parentElement;
            canvas.width = wrap.offsetWidth || 680;
            canvas.height = wrap.offsetHeight || 580;
            drawWood();
        }

        function rand(min, max) {
            return Math.random() * (max - min) + min;
        }

        function drawWood() {
            const W = canvas.width,
                H = canvas.height;
            ctx.clearRect(0, 0, W, H);

            const baseGrad = ctx.createLinearGradient(0, 0, W, H);
            baseGrad.addColorStop(0, '#2A1206');
            baseGrad.addColorStop(0.3, '#1E0D04');
            baseGrad.addColorStop(0.6, '#2C1508');
            baseGrad.addColorStop(1, '#180A02');
            ctx.fillStyle = baseGrad;
            ctx.fillRect(0, 0, W, H);

            const grainColors = [
                'rgba(120,60,15,IDX)', 'rgba(90,40,8,IDX)',
                'rgba(150,80,20,IDX)', 'rgba(70,30,5,IDX)',
                'rgba(180,100,30,IDX)', 'rgba(100,50,12,IDX)',
            ];

            for (let i = 0; i < 120; i++) {
                const x = rand(0, W);
                const amplitude = rand(2, 18);
                const frequency = rand(0.003, 0.012);
                const phase = rand(0, Math.PI * 2);
                const width = rand(0.4, 2.8);
                const alpha = rand(0.04, 0.22);
                const colorTemplate = grainColors[Math.floor(rand(0, grainColors.length))];
                const color = colorTemplate.replace('IDX', alpha.toFixed(3));

                ctx.beginPath();
                ctx.moveTo(x, 0);
                for (let y = 0; y <= H; y += 2) {
                    const xOffset = amplitude * Math.sin(frequency * y + phase) +
                        (amplitude * 0.4) * Math.sin(frequency * 2.3 * y + phase * 1.7);
                    ctx.lineTo(x + xOffset, y);
                }
                ctx.strokeStyle = color;
                ctx.lineWidth = width;
                ctx.stroke();
            }

            for (let i = 0; i < 18; i++) {
                const cx = rand(W * 0.1, W * 0.9);
                const cy = rand(-H * 0.3, H * 0.5);
                const maxR = rand(30, 120);
                for (let r = maxR; r > 2; r -= rand(3, 8)) {
                    const alpha = rand(0.015, 0.07);
                    ctx.beginPath();
                    ctx.ellipse(cx, cy, r * rand(1.8, 3.5), r, rand(-0.2, 0.2), 0, Math.PI * 2);
                    ctx.strokeStyle = `rgba(160,80,20,${alpha})`;
                    ctx.lineWidth = rand(0.5, 1.5);
                    ctx.stroke();
                }
            }

            for (let i = 0; i < 40; i++) {
                const x = rand(0, W);
                const y = rand(0, H);
                const len = rand(4, 20);
                const angle = rand(-0.1, 0.1);
                ctx.beginPath();
                ctx.moveTo(x, y);
                ctx.lineTo(x + Math.sin(angle) * len, y + Math.cos(angle) * len);
                ctx.strokeStyle = `rgba(60,20,5,${rand(0.3, 0.7)})`;
                ctx.lineWidth = rand(1, 3);
                ctx.stroke();
            }

            const sheen = ctx.createLinearGradient(0, 0, W * 0.6, H * 0.4);
            sheen.addColorStop(0, 'rgba(255,200,120,0.04)');
            sheen.addColorStop(0.5, 'rgba(255,180,80,0.02)');
            sheen.addColorStop(1, 'transparent');
            ctx.fillStyle = sheen;
            ctx.fillRect(0, 0, W, H);
        }

        resize();
        window.addEventListener('resize', resize);
    })();
</script>