<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎉 Lucky Draw Winner</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #240046, #5a189a);
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            padding: 20px;
        }

        .winner-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border-radius: 25px;
            padding: 35px 30px;
            max-width: 460px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
            animation: fadeIn 1.4s ease;
        }

        .trophy {
            font-size: 64px;
            margin-bottom: 10px;
            animation: bounce 2s infinite;
        }

        .winner-title {
            font-size: 30px;
            font-weight: 700;
            color: #ffd166;
            margin-bottom: 10px;
            animation: pulse 1.5s infinite;
        }

        /* Prize Section */
        .prize-box {
            margin: 25px 0;
            padding: 15px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.12);
            animation: slideUp 1.2s ease forwards;
        }

        .prize-box img {
            width: 100%;
            max-height: 200px;
            object-fit: contain;
            border-radius: 14px;
            box-shadow: 0 0 20px rgba(255, 209, 102, 0.8);
        }

        .prize-text {
            margin-top: 12px;
            font-size: 18px;
            font-weight: 600;
            color: #ffd166;
        }

        .winner-name {
            font-size: 32px;
            font-weight: 700;
            margin-top: 20px;
            text-shadow: 0 0 18px #ffd166;
            animation: scaleUp 1s ease forwards;
        }

        .winner-id {
            font-size: 15px;
            opacity: 0.9;
            margin-top: 6px;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-20px);
            }

            60% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.06);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes scaleUp {
            from {
                transform: scale(0.7);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @media (max-width: 480px) {
            .winner-name {
                font-size: 26px;
            }

            .winner-title {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

    <div class="winner-container">
        <div class="trophy">🏆</div>
        <div class="winner-title">Hurray! You Won 🎉</div>

        <!-- Prize Section -->
        <div class="prize-box">
            <img src="{{ asset('images/luckyDraw/' . $participant->image) }}" alt="Prize">
            <div class="prize-text">🎁 Congratulation: {{ $participant->user_name }}</div>
            <div class="winner-name">#{{ $participant->lucky_draw_id }}</div>
        </div>

    </div>

    <!-- Sounds -->
    <audio id="hurraySound">
        <source src="https://www.soundjay.com/human/cheering-01.mp3" type="audio/mpeg">
    </audio>

    <script>
        // Play hurray sound
        const hurray = document.getElementById('hurraySound');
        setTimeout(() => {
            hurray.play();
        }, 900);

        // Confetti blast
        setTimeout(() => {
            confetti({
                particleCount: 220,
                spread: 100,
                origin: {
                    y: 0.6
                }
            });
        }, 800);
    </script>

</body>

</html>
