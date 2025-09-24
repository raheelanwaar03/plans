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

    <div id="preloader">
        <div class="loader">
            <span class="p">P</span>
            <span class="g">G</span>
            <span class="n">N</span>
        </div>
    </div>

    <x-alert />

    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="text-dark text-center">
                        <h3 style="font-size: 30px;margin-top:10px;"><u>Buy VIP Class Membership</u></h3>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body text-center">
                    <h4>Wallet Details</h4>
                    <p><b>Account Title:</b> {{ $wallet->name }}</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <p><b>Account Number:</b> <span id="number">{{ $wallet->number }}</span></p>
                        <i class="bi bi-clipboard" onclick="copyNumber()"
                            style="cursor: pointer; color: blue;margin-top:-17px"></i>
                    </div>
                    <p><b>Bank Name:</b> {{ $wallet->wallet }}</p>
                </div>
            </div>

            <div class="row mt-3">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('User.Store.Vip.Membership') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="form-label" for="token">TRX ID or Till ID</label>
                                <input type="text" id="token" name="trxID" class="form-control" max="11"
                                    placeholder="Token Amount" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="SS">Screen Shot</label>
                                <input type="file" id="SS" name="screenShot" class="form-control" required>
                            </div>
                            <button class="btn btn-primary mt-2" type="submit">Buy</button>
                        </form>
                    </div>
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
        function copyNumber() {
            var number = document.getElementById("number").innerText.replace("📋", "").trim();

            var tempInput = document.createElement("input");
            tempInput.value = number;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);

            alert("Number " + number + " has been copied!");
        }

        window.addEventListener('load', () => {
            document.getElementById('preloader').style.display = 'none';
            document.getElementById('content').style.display = 'block';
        });
    </script>


</body>

</html>
