<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Verify your email — Sending link</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg1: #0075db;
            /* dark navy */
            --bg2: #059ea6;
            /* deep */
            --accent: #7c3aed;
            /* violet */
            --muted: rgba(255, 255, 255, 0.7);
        }

        * {
            box-sizing: border-box
        }

        html,
        body {
            height: 100%;
            margin: 0;
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial
        }

        body {
            background: radial-gradient(1200px 600px at 10% 10%, rgba(124, 58, 237, 0.12), transparent),
                radial-gradient(900px 400px at 90% 90%, rgba(14, 165, 233, 0.06), transparent),
                linear-gradient(180deg, var(--bg1), var(--bg2));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .card {
            width: 100%;
            max-width: 920px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.03), rgba(255, 255, 255, 0.02));
            border-radius: 18px;
            padding: 32px;
            box-shadow: 0 10px 40px rgba(2, 6, 23, 0.7);
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 28px;
            align-items: center;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.04)
        }

        @media (max-width:880px) {
            .card {
                grid-template-columns: 1fr;
                max-width: 640px;
                padding: 22px
            }
        }

        .left {
            padding-right: 8px;
        }

        h1 {
            margin: 0 0 8px 0;
            font-size: 28px;
            letter-spacing: -0.2px
        }

        p.lead {
            margin: 0;
            color: var(--muted)
        }

        .envelope-wrap {
            display: flex;
            gap: 18px;
            align-items: center;
            margin-top: 20px
        }

        /* animated envelope */
        .env {
            width: 120px;
            height: 96px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .env svg {
            width: 100%;
            height: 100%;
            filter: drop-shadow(0 8px 20px rgba(0, 0, 0, 0.4));
        }

        .floating {
            animation: float 3.6s ease-in-out infinite
        }

        @keyframes float {
            0% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(-10px)
            }

            100% {
                transform: translateY(0)
            }
        }

        .status {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.03), rgba(255, 255, 255, 0.01));
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px dashed rgba(255, 255, 255, 0.04);
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-top: 8px
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: linear-gradient(180deg, var(--accent), #5b21b6);
            box-shadow: 0 4px 18px rgba(124, 58, 237, 0.28)
        }

        .right {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 8px
        }

        .mailbox {
            width: 100%;
            max-width: 360px;
            text-align: center
        }

        .big {
            font-size: 14px;
            color: var(--muted);
            margin-top: 4px
        }

        .countdown {
            font-weight: 700;
            font-size: 40px;
            margin: 8px 0 14px 0;
            color: var(--accent);
            letter-spacing: -1px
        }

        .buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center
        }

        .btn {
            appearance: none;
            border: 0;
            padding: 12px 18px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            min-width: 140px
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--accent), #4f46e5);
            color: white;
            box-shadow: 0 8px 30px rgba(124, 58, 237, 0.18)
        }

        .btn-ghost {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.06);
            color: var(--muted)
        }

        .btn[disabled] {
            opacity: 0.5;
            cursor: not-allowed
        }

        .subtle {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.55);
            margin-top: 10px
        }

        /* progress dots */
        .dots {
            display: flex;
            gap: 8px;
            margin-top: 12px
        }

        .dots span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            opacity: 0.5
        }

        .dots span.active {
            background: var(--accent);
            box-shadow: 0 8px 18px rgba(124, 58, 237, 0.18);
            opacity: 1
        }

        footer.small {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.45);
            text-align: center;
            margin-top: 18px
        }
    </style>
</head>

<body>
    <div class="card" role="main" aria-labelledby="title">
        <div class="left">
            <h1 id="title">Almost there — Verify your email</h1>
            <p class="lead">We sent a verification link to <strong id="user-email">{{ auth()->user()->email }}</strong>. Click it
                to finish setting up your account.</p>

            <div class="envelope-wrap">
                <div class="env floating" aria-hidden="true">
                    <!-- envelope SVG -->
                    <svg viewBox="0 0 64 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="g1" x1="0" x2="1">
                                <stop offset="0" stop-color="#7c3aed" />
                                <stop offset="1" stop-color="#4f46e5" />
                            </linearGradient>
                        </defs>
                        <rect x="1" y="6" width="62" height="36" rx="6" fill="url(#g1)" opacity="0.15" />
                        <path d="M4 10l28 20L60 10" stroke="url(#g1)" stroke-width="2.6" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M4 38V12l28 18 28-18v26a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4z"
                            fill="rgba(255,255,255,0.02)" />
                        <path d="M4 10l28 20 28-20" stroke="rgba(255,255,255,0.06)" stroke-width="1" />
                    </svg>
                </div>

                <div>
                    <div class="status" role="status" aria-live="polite">
                        <div class="dot"></div>
                        <div>Sending verification link...</div>
                    </div>
                    <div class="big">Check your inbox — it might take a few seconds</div>
                </div>
            </div>

            <p class="subtle">Tip: check your spam or promotions folder if you don’t see the message. Still nothing? You
                can resend the link below.</p>
        </div>

        <div class="right">
            <div class="mailbox">
                <svg width="90" height="90" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <circle cx="12" cy="12" r="10" stroke="rgba(255,255,255,0.06)" stroke-width="1.2">
                    </circle>
                    <path d="M7 11l3 3 7-7" stroke="white" stroke-width="1.6" stroke-linecap="round"
                        stroke-linejoin="round" opacity="0.95"></path>
                </svg>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                {{-- <div class="countdown" id="count">00:30</div> --}}
                <div class="buttons">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button class="btn btn-primary" id="resendBtn">Resend link</button>
                    </form>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-ghost" id="changeBtn">Logout</button>
                    </form>
                </div>

                <div class="subtle" style="margin-top:10px">Didn't receive it? The button will enable shortly. If you
                    changed your email, update it using "Change email".</div>
            </div>
        </div>
    </div>

    <script>
        // --- Config ---
        const RESEND_WAIT = 30; // seconds until resend enabled
        let remaining = RESEND_WAIT;

        const countEl = document.getElementById('count');
        const resendBtn = document.getElementById('resendBtn');
        const changeBtn = document.getElementById('changeBtn');

        function formatTime(s) {
            const mm = Math.floor(s / 60).toString().padStart(2, '0');
            const ss = (s % 60).toString().padStart(2, '0');
            return mm + ':' + ss;
        }

        function tick() {
            countEl.textContent = formatTime(remaining);
            if (remaining <= 0) {
                resendBtn.disabled = false;
                countEl.textContent = 'Ready';
                clearInterval(timer);
            }
            remaining--;
        }

        // start timer
        tick();
        const timer = setInterval(tick, 1000);

        resendBtn.addEventListener('click', () => {
            if (resendBtn.disabled) return;
            // visual feedback
            resendBtn.disabled = true;
            resendBtn.textContent = 'Sending...';

            // simulate network call (replace with real request)
            setTimeout(() => {
                // show success animation sequence
                resendBtn.textContent = 'Sent';
                remaining = RESEND_WAIT; // restart cooldown
                tick();
                setTimeout(() => { // restore label after short time
                    resendBtn.textContent = 'Resend link';
                    // restart timer
                    const newTimer = setInterval(tick, 1000);
                }, 1600);
            }, 1200);
        });

        changeBtn.addEventListener('click', () => {
            const newEmail = prompt('Enter new email address to use:', '');
            if (!newEmail) return;
            // update UI -- in a real app, you'd validate and send to the server
            document.getElementById('user-email').textContent = newEmail;
            // optionally auto-trigger a resend
            alert('Email updated — we will send a verification link to ' + newEmail + '.');
            // reset timer & disable resend for cooldown
            resendBtn.disabled = true;
            remaining = RESEND_WAIT;
            countEl.textContent = formatTime(remaining);
            // restart timer
            const x = setInterval(tick, 1000);
            setTimeout(() => clearInterval(x), (RESEND_WAIT + 2) * 1000);
        });

        // accessible keyboard shortcut: press R to resend when available
        document.addEventListener('keydown', (e) => {
            if (e.key.toLowerCase() === 'r') {
                if (!resendBtn.disabled) resendBtn.click();
            }
        });
    </script>
</body>

</html>

{{--

<div class="mt-4 flex items-center justify-between">
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf

        <div>
            <x-primary-button>
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </div>
    </form>


        <button type="submit"
            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ __('Log Out') }}
        </button>
    </form>
</div> --}}
