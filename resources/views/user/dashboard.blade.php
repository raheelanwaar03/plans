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

    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="text-dark d-flex justify-content-between align-items-center">
                        <p style="font-size: 20px;margin-top:10px;"><b>Pigeon Mining</b></p>
                        <div id="timer" class="timer text-white">Loading...</div>
                        <script>
                            function startTimer() {
                                const totalHours = 2400; // 2400 hours
                                let startTime = localStorage.getItem("timerStart");

                                // Initialize start time if not set
                                if (!startTime) {
                                    startTime = Date.now();
                                    localStorage.setItem("timerStart", startTime);
                                } else {
                                    startTime = parseInt(startTime);
                                }

                                function updateTimer() {
                                    const currentTime = Date.now();
                                    const elapsedTime = (currentTime - startTime) / 1000; // in seconds
                                    const remainingTime = (totalHours * 3600) - elapsedTime; // total seconds remaining

                                    if (remainingTime <= 0) {
                                        document.getElementById("timer").textContent = "Time's up!";
                                        localStorage.removeItem("timerStart");
                                        return;
                                    }

                                    const hours = Math.floor(remainingTime / 3600);
                                    const minutes = Math.floor((remainingTime % 3600) / 60);
                                    const seconds = Math.floor(remainingTime % 60);

                                    document.getElementById("timer").textContent =
                                        `(${hours}h ${minutes}m ${seconds}s)`;

                                    requestAnimationFrame(updateTimer);
                                }

                                updateTimer();
                            }

                            window.onload = startTimer;
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
                    <p><span style="font-size: 12px;">Today Timmer</span>
                    <div id="24timer" class="timer" style="margin-top:-15px">24:00:00</div>
                    <script>
                        function start24HourTimer() {
                            const timerDisplay = document.getElementById('24timer');

                            function updateTimer() {
                                const now = new Date();
                                const hours = 23 - now.getHours();
                                const minutes = 59 - now.getMinutes();
                                const seconds = 59 - now.getSeconds();

                                const formattedTime =
                                    String(hours).padStart(2, '0') + ':' +
                                    String(minutes).padStart(2, '0') + ':' +
                                    String(seconds).padStart(2, '0');

                                timerDisplay.textContent = formattedTime;
                            }
                            setInterval(updateTimer, 1000);
                            updateTimer();
                        }
                        start24HourTimer();
                    </script>
                    <a href="{{ route('User.Start.Mine') }}" class="btn btn-primary">Start Mining</a>
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

</body>

</html>
