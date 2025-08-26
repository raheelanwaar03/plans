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
    </style>
</head>

<body>
    <x-alert />

    <div id="preloader">
        <div class="letters">
            <span class="p">P</span>
            <span class="g">G</span>
            <span class="n">N</span>
        </div>
    </div>

    <header>
        <div class=" icons">
            <!-- Menu/Profile Icon -->
            <i class="fa-solid fa-user menu-icon" id="profile-icon"></i>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-4">
                <h3 class="text-center">Earn Tokens</h3>
                <h4 class="text-center">{{ auth()->user()->balance }}PGN</h4>
            </div>
        </div>
    </div>

    <main>
        <div class="container-fluid">
            <div class="row mt-3 text-center">
                <p>Click on a link, stay for 20 seconds, and earn 2 tokens! You can only visit each site once every 24
                    hours.</p>
                <div id="links" class="text-center">
                    @foreach ($links as $item)
                        <a href="{{ route('User.Link.Amount', $item->id) }}" class="btn btn-primary m-2"
                            onclick="window.open('{{ $item->link }}', '_blank',alert('wait for 30 Second to given link to earn token'))">{{ $item->title }}</a>
                    @endforeach
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
        // Hide preloader once page loads
        window.addEventListener("load", function() {
            setTimeout(() => {
                document.getElementById("preloader").style.display = "none";
                document.getElementById("main-content").style.display = "block";
            }, 2500); // wait for animation to finish
        });
    </script>

</body>

</html>
