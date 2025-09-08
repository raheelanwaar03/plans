<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }} | User Dashboard</title>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo.png') }}">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            color: #fff;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-x: hidden;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #2e3b4e;
        }

        header .icons {
            display: flex;
            gap: 15px;
        }

        header .icons .menu-icon {
            font-size: 24px;
            color: #fff;
            cursor: pointer;
        }

        main {
            flex: 1;
            font-size: 15px;
            padding: 20px;
        }

        footer {
            background-color: #2e3b4e;
            color: #fff;
            padding: 10px 20px;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: -100%;
            width: 300px;
            height: 100%;
            background-color: #fff;
            color: #333;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
            transition: left 0.3s ease;
            overflow-y: auto;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .sidebar header .close-icon {
            font-size: 20px;
            color: #333;
            cursor: pointer;
        }

        .sidebar section {
            margin-bottom: 30px;
        }

        .sidebar section h3 {
            font-size: 16px;
            color: #2e3b4e;
            margin-bottom: 10px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar ul li .fa-chevron-right {
            color: #ccc;
        }

        .sidebar .logout {
            color: red;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }

        .sidebar .logout a {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }

        .icon-style {
            background-color: white;
            font-size: 20px;
            color: #00a99d;
            padding: 15px;
            border-radius: 40px;
        }

        .font-2 {
            font-size: 13px;
        }

        .pointer {
            cursor: pointer;
        }

        a#startMining {
            display: inline-block;
            padding: 10px 20px;
            background-color: rgb(44, 44, 225);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }

        a#startMining.disabled {
            background-color: gray;
            pointer-events: none;
            cursor: not-allowed;
        }

        #popup {
            display: none;
            position: fixed;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -30%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            z-index: 1000;
            border-radius: 8px;
        }

        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        #closeBtn {
            margin-top: 10px;
            padding: 5px 10px;
        }

        /* preloader */

        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f172a;
            z-index: 9999;
        }


        .loader {
            font-size: 64px;
            font-weight: 800;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }


        .p {
            color: #7c3aed;
            position: relative;
            z-index: 2;
        }


        .g,
        .n {
            color: #e5e7eb;
            position: relative;
            opacity: 0;
        }


        .g {
            animation: fromBehind 3s infinite;
            animation-delay: 0.3s;
        }

        .n {
            animation: fromBehind 3s infinite;
            animation-delay: 1.6s;
        }


        @keyframes fromBehind {
            0% {
                opacity: 0;
                transform: translateX(-30px);
            }

            20% {
                opacity: 1;
                transform: translateX(0);
            }

            50% {
                opacity: 1;
                transform: translateX(0);
            }

            70% {
                opacity: 0;
                transform: translateX(30px);
            }

            100% {
                opacity: 0;
                transform: translateX(30px);
            }
        }

        /* Modal background */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            z-index: 9999;
        }

        .modal-overlay.active {
            visibility: visible;
            opacity: 1;
        }

        /* Modal box */
        .modal-box {
            background: linear-gradient(135deg, #4facfe, #00f2fe, #4facfe);
            color: #fff;
            padding: 2rem;
            border-radius: 20px;
            text-align: center;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            animation: popUp 0.5s ease;
        }

        @keyframes popUp {
            0% {
                transform: scale(0.7);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal-box h2 {
            margin-bottom: 1rem;
            font-size: 1.8rem;
        }

        .modal-box p {
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }

        .modal-box button {
            background: #fff;
            color: #0abbec;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        .modal-box button:hover {
            background: #ffe6ec;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class=" icons">
            <!-- Menu/Profile Icon -->
            <i class="fa-solid fa-user menu-icon" id="profile-icon"></i>
        </div>
    </header>

    {{-- preloader --}}

    <div id="preloader">
        <div class="loader">
            <span class="p">P</span>
            <span class="g">G</span>
            <span class="n">N</span>
        </div>
    </div>

    <x-alert />

    <div id="overlay"></div>
    <div id="popup">
        <h4 style="color: black;">Important Annoucment!</h4>
        <p style="color: black">
            If you did not mine for three days your Tokens will be zero.
        </p>
        <button id="closeBtn"
            style="background-color:rgb(51, 51, 205);color:white;border-radius:20px;border:1px solid white;">Close</button>
    </div>

    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="text-dark d-flex justify-content-between align-items-center">
                        <p style="font-size: 20px;margin-top:10px;"><b>Pigeon Mining</b></p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-between align-items-center my-4 text-center">
                <div class="col-12 bg-white text-dark text-center p-4 mb-3" style="border-radius: 10px;">
                    <h3>
                        <i class="bi bi-coin"></i>
                    </h3>
                    <p><span style="font-size: 12px;">Mined PGN</span> <br>
                        <span><b>{{ auth()->user()->balance }} PGN</b></span>
                    </p>
                </div>
                <div class="col-12 bg-white text-dark text-center p-4" style="border-radius: 10px;">
                    <h3>
                        <i class="bi bi-alarm"></i>
                    </h3>
                    <p id="timerDisplay"></p>
                    <button id="startMining" class="btn btn-primary"
                        onclick="window.open('{{ route('User.Start.Mine') }}')">Start Mining</button>
                    <script>
                        $(document).ready(function() {
                            const TIMER_DURATION = 24 * 60 * 60 * 1000; // 24 hours in ms
                            const $link = $('#startMining');
                            const $display = $('#timerDisplay');

                            function updateTimerDisplay(timeLeft) {
                                const totalSeconds = Math.floor(timeLeft / 1000);
                                const hours = Math.floor(totalSeconds / 3600);
                                const minutes = Math.floor((totalSeconds % 3600) / 60);
                                const seconds = totalSeconds % 60;

                                $display.text(
                                    `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`
                                );
                            }

                            function startCountdown(endTime) {
                                const interval = setInterval(() => {
                                    const now = Date.now();
                                    const timeLeft = endTime - now;

                                    if (timeLeft <= 0) {
                                        clearInterval(interval);
                                        localStorage.removeItem('miningStartTime');
                                        $link.removeClass('disabled').attr('href', '#');
                                        $display.text('You can start mining again!');
                                    } else {
                                        updateTimerDisplay(timeLeft);
                                    }
                                }, 1000);
                            }

                            function initializeTimer() {
                                const startTime = localStorage.getItem('miningStartTime');
                                if (startTime) {
                                    const endTime = parseInt(startTime) + TIMER_DURATION;
                                    const now = Date.now();

                                    if (now < endTime) {
                                        $link.addClass('disabled').removeAttr('href');
                                        startCountdown(endTime);
                                    } else {
                                        localStorage.removeItem('miningStartTime');
                                        $link.removeClass('disabled').attr('href', '#');
                                    }
                                }
                            }

                            // On page load
                            initializeTimer();

                            // Click event
                            $link.click(function(e) {
                                if (!$link.hasClass('disabled')) {
                                    e.preventDefault(); // Stop actual link action
                                    const startTime = Date.now();
                                    localStorage.setItem('miningStartTime', startTime.toString());
                                    $link.addClass('disabled').removeAttr('href');
                                    startCountdown(startTime + TIMER_DURATION);
                                }
                            });
                        });
                    </script>
                    </p>
                </div>
            </div>

            {{-- second model --}}

            <div class="modal-overlay" id="dailyModal">
                <div class="modal-box">
                    <h2>🎉 Marketing Offer!</h2>
                    <p>If you want to promot your website. Contact Us.</p>
                    <a href="{{ route('User.Contact') }}" class="btn btn-primary">Contact Us</a>
                        <button onclick="closeModal()">Close</button>
                </div>
            </div>

            <div class="row">
                <p class="text-dark">Important Notice
                    <br>
                    <small>For any query, contact CS</small>
                </p>
            </div>
        </div>
    </main>

    @include('layouts.links')

    <!-- Sidebar -->

    @include('layouts.sidebar')

    <!-- JavaScript for Sidebar -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

    <script>
        const profileIcon = document.getElementById('profile-icon');
        const sidebar = document.getElementById('sidebar');
        const closeIcon = document.getElementById('close-icon');

        // Toggle Sidebar
        profileIcon.addEventListener('click', () => {
            sidebar.classList.add('active');
        });

        // Hide Sidebar
        closeIcon.addEventListener('click', () => {
            sidebar.classList.remove('active');
        });
    </script>

    <script>
        function shouldShowPopup() {
            const lastShown = localStorage.getItem('popupShownDate');
            const today = new Date().toISOString().split('T')[0]; // Get YYYY-MM-DD

            if (lastShown !== today) {
                localStorage.setItem('popupShownDate', today);
                return true;
            }
            return false;
        }

        function showPopup() {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('popup').style.display = 'block';
        }

        function hidePopup() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('popup').style.display = 'none';
        }

        document.getElementById('closeBtn').addEventListener('click', hidePopup);

        if (shouldShowPopup()) {
            showPopup();
        }
    </script>

    <script>
        window.addEventListener('load', () => {
            document.getElementById('preloader').style.display = 'none';
            document.getElementById('content').style.display = 'block';
        });
    </script>

    <script>
        const modal = document.getElementById("dailyModal");

        // Function to close modal
        function closeModal() {
            modal.classList.remove("active");
        }

        // Check last shown date in localStorage
        window.onload = function() {
            let today = new Date().toISOString().split("T")[0]; // format: YYYY-MM-DD
            let lastShown = localStorage.getItem("modalLastShown");

            if (lastShown !== today) {
                modal.classList.add("active");
                localStorage.setItem("modalLastShown", today);
            }
        };
    </script>

</body>

</html>
