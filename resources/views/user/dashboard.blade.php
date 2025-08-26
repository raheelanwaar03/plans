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
            width: 100%;
            height: 100%;
            background: #0f172a;
            /* dark navy */
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            overflow: hidden;
        }

        .letters {
            font-size: 4rem;
            font-weight: bold;
            font-family: Arial, sans-serif;
            display: flex;
            color: #22c55e;
            /* bright green */
            position: relative;
        }

        .letters span {
            opacity: 0;
        }

        .letters .p {
            opacity: 0;
            animation: showP 0.8s forwards;
        }

        .letters .g {
            position: absolute;
            left: 0;
            transform: translateX(-100%);
            animation: slideG 1s forwards;
            animation-delay: 1s;
        }

        .letters .n {
            position: absolute;
            left: 0;
            transform: translateX(-100%);
            animation: slideN 1s forwards;
            animation-delay: 1.8s;
        }

        /* Animations */
        @keyframes showP {
            from {
                opacity: 0;
                transform: scale(0.5);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideG {
            from {
                opacity: 0;
                transform: translateX(-100%);
            }

            to {
                opacity: 1;
                transform: translateX(65px);
            }
        }

        @keyframes slideN {
            from {
                opacity: 0;
                transform: translateX(-100%);
            }

            to {
                opacity: 1;
                transform: translateX(130px);
            }
        }


        /* Overlay */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 9999;
        }

        /* Centered popup */
        .popup {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            max-width: 90%;
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        button {
            margin: 10px;
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }

        .yes {
            background: #e63946;
            color: white;
        }

        .no {
            background: #457b9d;
            color: white;
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
        <div class="letters">
            <span class="p">P</span>
            <span class="g">G</span>
            <span class="n">N</span>
        </div>
    </div>

    <x-alert />

    {{-- confirmation --}}
    <div class="overlay" id="exitPopup">
        <div class="popup">
            <h2>Are you sure?</h2>
            <p>Do you really want to leave this page?</p>
            <button class="yes" id="confirmExit">Yes, Leave</button>
            <button class="no" id="cancelExit">Cancel</button>
        </div>
    </div>

    {{-- popup --}}

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

            <div class="row">
                <p class="text-dark">Important Notice
                    <br>
                    <small>For any query, contact CS</small>
                </p>
            </div>
        </div>

        {{-- pop-up --}}

        <!-- Exit Confirmation Modal -->
        <div id="exitConfirmModal"
            class="fixed inset-0 bg-gray-800 bg-opacity-60 hidden items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm text-center">
                <h2 class="text-lg font-bold mb-4">Are you sure you want to quit?</h2>
                <div class="flex justify-center space-x-4">
                    <button id="confirmExitYes"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Yes</button>
                    <button id="confirmExitNo" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">No</button>
                </div>
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

    {{-- pop up --}}

    <script>
        let exitModal = document.getElementById("exitConfirmModal");
        let btnYes = document.getElementById("confirmExitYes");
        let btnNo = document.getElementById("confirmExitNo");

        let allowExit = false;

        // Detect back navigation or tab close
        window.onbeforeunload = function(e) {
            if (!allowExit) {
                e.preventDefault();
                e.returnValue = ""; // Required for Chrome
                exitModal.classList.remove("hidden");
                exitModal.classList.add("flex");
                return "";
            }
        };

        // If user clicks "Yes" -> allow exit
        btnYes.addEventListener("click", function() {
            allowExit = true;
            exitModal.classList.add("hidden");
            exitModal.classList.remove("flex");
            window.close(); // For closing tab (only works if opened via script)
            window.location.href = "about:blank"; // Fallback to blank page
        });

        // If user clicks "No" -> cancel exit
        btnNo.addEventListener("click", function() {
            allowExit = false;
            exitModal.classList.add("hidden");
            exitModal.classList.remove("flex");
        });
    </script>


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
        // Hide preloader once page loads
        window.addEventListener("load", function() {
            setTimeout(() => {
                document.getElementById("preloader").style.display = "none";
                document.getElementById("main-content").style.display = "block";
            }, 2500); // wait for animation to finish
        });
    </script>


    <script>
        const overlay = document.getElementById('exitPopup');
        const confirmExit = document.getElementById('confirmExit');
        const cancelExit = document.getElementById('cancelExit');

        // Push a dummy state so back button won't close immediately
        history.pushState(null, null, location.href);

        window.onpopstate = function(event) {
            // Show popup instead of going back
            overlay.style.display = 'block';

            // Push state again so back button works after closing popup
            history.pushState(null, null, location.href);
        };

        confirmExit.addEventListener('click', function() {
            overlay.style.display = 'none';
            history.back(); // Actually go back now
        });

        cancelExit.addEventListener('click', function() {
            overlay.style.display = 'none';
        });
    </script>

</body>

</html>
