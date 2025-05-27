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
    <x-alert />

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
                        <div id="timer">
                            <span id="days">0</span>d :
                            <span id="hours">00</span>h :
                            <span id="minutes">00</span>m :
                            <span id="seconds">00</span>s
                        </div>

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                // 🔧 Set your fixed start date ONCE when deploying (e.g., May 19, 2025)
                                var startDate = new Date("2025-05-19T00:00:00Z"); // <-- Change this only once
                                var endDate = new Date(startDate.getTime());
                                endDate.setDate(startDate.getDate() + 100);

                                function updateTimer() {
                                    var now = new Date();
                                    var timeLeft = endDate - now;

                                    if (timeLeft <= 0) {
                                        $("#days").text("0");
                                        $("#hours").text("00");
                                        $("#minutes").text("00");
                                        $("#seconds").text("00");
                                        clearInterval(timerInterval);
                                        return;
                                    }

                                    var seconds = Math.floor(timeLeft / 1000) % 60;
                                    var minutes = Math.floor(timeLeft / (1000 * 60)) % 60;
                                    var hours = Math.floor(timeLeft / (1000 * 60 * 60)) % 24;
                                    var days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));

                                    $("#days").text(days);
                                    $("#hours").text(("0" + hours).slice(-2));
                                    $("#minutes").text(("0" + minutes).slice(-2));
                                    $("#seconds").text(("0" + seconds).slice(-2));
                                }

                                updateTimer();
                                var timerInterval = setInterval(updateTimer, 1000);
                            });
                        </script>
                    </div>
                    <p style="font-size:10px;float: right;margin-top:-10px;color:black">First Withdraw</p>
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
    </main>

    <footer>
        <nav class="d-flex justify-content-around align-items-center">
            <a href="{{ route('User.Dashboard') }}" style="color: white;text-decoration: none;"><i class="bi bi-house"
                    style="font-size: 20px;"></i><br><span style="font-size:13px;margin-left: -7px;">Home</span></a>
            <a href="{{ route('User.Booster') }}" style="color: white;text-decoration: none;">
                <i class="bi bi-rocket" style="font-size: 20px;"></i>
                <br><span style="font-size:13px;margin-left: -7px;">Booster</span></a>
            <a href="{{ route('User.KYC') }}" style="color: white;text-decoration: none;">
                <i class="bi bi-patch-question" style="font-size: 20px;"></i><br><span
                    style="font-size:13px;margin-left: -3px;">KYC</span></a>
        </nav>
    </footer>

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

</body>

</html>
