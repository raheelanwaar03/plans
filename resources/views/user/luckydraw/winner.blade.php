<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lottery Winners</title>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        .celebration {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
            z-index: 1000;
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: gold;
            animation: fall linear forwards;
        }

        @keyframes fall {
            0% {
                transform: translateY(-10vh) rotate(0);
                opacity: 1;
            }

            100% {
                transform: translateY(110vh) rotate(720deg);
                opacity: 0;
            }
        }

        .container {
            padding: 2rem 1rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            z-index: 1;
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
        }

        .card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.7);
        }

        .card img {
            width: 100%;
            height: auto;
            max-height: 240px;
            object-fit: cover;
            position: relative;
            animation: glow 3s infinite linear;
        }

        @keyframes glow {
            0% {
                filter: brightness(1) drop-shadow(0 0 0px gold);
            }

            50% {
                filter: brightness(1.2) drop-shadow(0 0 12px gold);
            }

            100% {
                filter: brightness(1) drop-shadow(0 0 0px gold);
            }
        }

        .card-body {
            padding: 1rem;
            text-align: center;
        }

        .card-body h2 {
            margin: 0.5rem 0;
            font-size: 1.3rem;
            color: #ffeb3b;
        }

        .card-body p {
            margin: 0.25rem 0;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .card-body h2 {
                font-size: 1.1rem;
            }

            .card-body p {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .card-body h2 {
                font-size: 1rem;
            }

            .card-body p {
                font-size: 0.85rem;
            }
        }
    </style>
</head>

<body>

    <div class="">
        <a href="{{ route('User.Dashboard') }}"
            style="background: rgb(38, 222, 235);text-align:start;border-radius:5px;font-size:30px;text-decoration:none;color:white;padding-left:6px;padding-right:6px;">←</a>
    </div>

    <div class="celebration" id="celebration"></div>

    <div class="container">
        @forelse ($winners as $winner)
            <div class="card">
                <img src="{{ asset('images/luckyDraw/' . $winner->image) }}" alt="Prize Image">
                <div class="card-body">
                    <h2>{{ $winner->user_email }} is the winner</h2>
                    <p>Ticket Price: {{ $winner->item_price }}</p>
                    <p>Date: {{ $winner->created_at->format('d M, Y') }}</p>
                    <p>Organized by: {{ env('APP_NAME') }}
                </div>
            @empty
                <h3>Winner is not announced yet!</h3>
        @endforelse
    </div>

    <script>
        // Celebration Confetti
        function launchConfetti() {
            const celebration = document.getElementById('celebration');
            for (let i = 0; i < 60; i++) {
                const confetti = document.createElement('div');
                confetti.classList.add('confetti');
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.backgroundColor = `hsl(${Math.random() * 360}, 100%, 50%)`;
                confetti.style.animationDuration = (Math.random() * 3 + 2) + 's';
                confetti.style.opacity = Math.random();
                celebration.appendChild(confetti);

                setTimeout(() => confetti.remove(), 5000);
            }
        }

        // Trigger on load
        window.onload = () => {
            launchConfetti();
            setInterval(launchConfetti, 5000);
        };
    </script>
</body>

</html>
