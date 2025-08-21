<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lottery Winners Announcement</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg1: #0f1020;
            --bg2: #0b122e;
            --bg3: #0b2a4e;
            --accent: #22c55e;
            --text: #eaf2ff;
            --muted: #a9b3c7;
            --glow: 0 0 20px rgba(34, 197, 94, .55), 0 0 40px rgba(34, 197, 94, .35), 0 0 60px rgba(34, 197, 94, .2);
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            color: var(--text);
            background: linear-gradient(135deg, var(--bg1), var(--bg2), var(--bg3));
            overflow: auto;
        }

        .aurora {
            position: fixed;
            inset: -20vmax;
            pointer-events: none;
            z-index: 0;
            filter: blur(50px) saturate(140%);
            background: conic-gradient(from 0deg at 50% 50%, rgba(34, 197, 94, .14), rgba(255, 213, 79, .14), rgba(99, 102, 241, .16), rgba(34, 197, 94, .14));
            animation: swirl 18s linear infinite;
            opacity: .8;
        }

        @keyframes swirl {
            to {
                transform: rotate(360deg) scale(1.05)
            }
        }

        .wrap {
            position: relative;
            z-index: 2;
            min-height: 100dvh;
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .winners-grid {
            display: grid;
            gap: 28px;
            width: 100%;
            max-width: 1200px;
        }

        .card {
            background: linear-gradient(135deg, rgba(255, 255, 255, .08), rgba(255, 255, 255, .03));
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 28px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .45), var(--glow);
            backdrop-filter: blur(16px) saturate(135%);
            overflow: hidden;
            position: relative;
            display: grid;
            grid-template-columns: 180px 1fr;
            align-items: stretch;
        }

        .prize-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .trophy {
            width: 60px;
            height: 60px;
            flex: 0 0 60px;
            display: grid;
            place-items: center;
            border-radius: 16px;
            background: radial-gradient(circle at 30% 30%, #ffe082, #f59e0b);
            box-shadow: inset 0 2px 10px rgba(255, 255, 255, .4), 0 10px 25px rgba(245, 158, 11, .5);
        }

        h1 {
            font-size: clamp(20px, 4vw, 32px);
            margin: 0;
            font-weight: 800;
        }

        .subtitle {
            color: var(--muted);
            font-size: 14px;
        }

        .name {
            font-size: clamp(24px, 4.5vw, 40px);
            font-weight: 800;
            margin-bottom: 12px;
            background: linear-gradient(90deg, #fff, #bfeecf, #fff);
            -webkit-background-clip: text;
            color: transparent;
            text-shadow: 0 6px 16px rgba(34, 197, 94, .35);
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
            margin-bottom: 16px;
        }

        .stat {
            background: linear-gradient(180deg, rgba(255, 255, 255, .08), rgba(255, 255, 255, .02));
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 14px;
            padding: 10px 12px;
        }

        .label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: #bbd0e7;
        }

        .value {
            font-size: 18px;
            font-weight: 700;
            margin-top: 2px;
        }

        .actions {
            margin-top: auto;
        }

        .btn {
            border: none;
            border-radius: 12px;
            padding: 8px 12px;
            font-weight: 700;
            background: linear-gradient(90deg, var(--accent), #16a34a);
            color: #041b0d;
            cursor: pointer;
            box-shadow: var(--glow);
        }

        canvas#confetti {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 3;
        }

        .back-arrow {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 24px;
            text-decoration: none;
            color: #333;
            background-color: #e0e0e0;
            padding: 8px 12px;
            border-radius: 50%;
            transition: 0.2s;
            cursor: pointer;
        }

        .back-arrow:hover {
            background-color: #67b0e8;
        }
    </style>
</head>

<body>

    <div class="">
        <a href="{{ route('User.Dashboard') }}" class="btn btn-primary">back</a>
    </div>

    <div class="aurora"></div>
    <canvas id="confetti"></canvas>
    <div class="wrap">
        <div class="winners-grid">
            <!-- Winner Card Example -->
            @foreach ($winners as $winner)
                <div class="card">
                    <div>
                        <img src="{{ asset('images/luckyDraw/' . $winner->image) }}" alt="Prize" class="prize-img">
                    </div>
                    <div class="content">
                        <header>
                            <div class="trophy">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 22h8" stroke="#2e1a00" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M12 18c2.761 0 5-2.239 5-5V4H7v9c0 2.761 2.239 5 5 5Z" fill="#ffd54f" />
                                    <path d="M5 4h14" stroke="#b8860b" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M7 8.5C5 8 3 6.5 3 4H7M17 8.5c2-.5 4-2 4-4.5h-4" stroke="#ffd54f"
                                        stroke-width="1.5" stroke-linecap="round" />
                                    <circle cx="12" cy="11" r="2.6" fill="#fff59d" />
                                </svg>
                            </div>
                            <div>
                                <h1>🎉 Winner!</h1>
                                <div class="subtitle">Grand Prize Winner</div>
                            </div>
                        </header>
                        <div class="name">{{ $winner->user_email }}</div>
                        <div class="stats">
                            <div class="stat">
                                <div class="label">User ID</div>
                                <div class="value">{{ $winner->user_id }}</div>
                            </div>
                            <div class="stat">
                                <div class="label">Draw Price</div>
                                <div class="value">{{ $winner->item_price }}</div>
                            </div>
                            <div class="stat">
                                <div class="label">Draw Date</div>
                                <div class="value">{{ $winner->created_at->format('d-m-Y') }}</div>
                            </div>
                            <div class="stat">
                                <div class="label">Announced By</div>
                                <div class="value">{{ env('APP_NAME') }}</div>
                            </div>
                        </div>
                        <div class="actions"><button class="btn celebrate">Celebrate 🎊</button></div>
                    </div>
                </div>
            @endforeach
            <!-- End Winner Card -->
        </div>
    </div>
    <script>
        const canvas = document.getElementById('confetti');
        const ctx = canvas.getContext('2d');
        let W, H, confetti = [],
            raf;

        function resize() {
            W = canvas.width = innerWidth;
            H = canvas.height = innerHeight;
        }
        addEventListener('resize', resize, {
            passive: true
        });
        resize();

        function spawn(n = 160) {
            confetti = [];
            for (let i = 0; i < n; i++) {
                confetti.push({
                    x: Math.random() * W,
                    y: Math.random() * -H,
                    r: 4 + Math.random() * 6,
                    s: 1 + Math.random() * 3,
                    a: Math.random() * 360,
                    hue: Math.floor(180 + Math.random() * 160),
                    tilt: Math.random() * 10
                });
            }
        }

        function draw() {
            ctx.clearRect(0, 0, W, H);
            confetti.forEach(c => {
                c.y += c.s;
                c.x += Math.sin((c.y + c.a) / 30);
                c.tilt += .3;
                ctx.save();
                ctx.translate(c.x, c.y);
                ctx.rotate(c.tilt * Math.PI / 180);
                ctx.fillStyle = `hsl(${c.hue} 90% 60%)`;
                ctx.fillRect(-c.r / 2, -c.r / 2, c.r, c.r);
                ctx.restore();
            });
            confetti = confetti.filter(c => c.y < H + 20);
            raf = requestAnimationFrame(draw);
        }

        function celebrate() {
            cancelAnimationFrame(raf);
            spawn(200);
            draw();
            setTimeout(() => cancelAnimationFrame(raf), 6000);
        }
        document.querySelectorAll('.celebrate').forEach(btn => btn.addEventListener('click', celebrate));
        setTimeout(celebrate, 400);
    </script>
</body>

</html>
