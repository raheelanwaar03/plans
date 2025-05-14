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
                    <div class="text-dark text-center">
                        <h3 style="font-size: 30px;margin-top:10px;"><b>KYC</b></h3>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="walletAddress" class="form-label">Trust Wallet Address:</label>
                            <div class="wallet-address">
                                <input type="text" class="form-control" id="kycWallet"
                                    value="0x7129C2aa9750BFf9d2C77C55A08f538b2d768c78" readonly>
                                <i style="margin-top:-30px;margin-right:10px;float:right;color:blue"
                                    class="bi bi-clipboard" id="kycCopyButton"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('User.KYC.Data') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="fullName" class="form-label">Full Name:</label>
                                <input type="text" class="form-control" id="fullName" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="mobileNumber" class="form-label">Mobile Number:</label>
                                <input type="text" class="form-control" id="mobileNumber" name="number" required>
                            </div>

                            <div class="form-group">
                                <label for="idFront" class="form-label">ID Card (Front):</label>
                                <input type="file" class="form-control" id="idFront" name="idFront"
                                    accept="image/*" required>
                            </div>

                            <div class="form-group">
                                <label for="idBack" class="form-label">ID Card (Back):</label>
                                <input type="file" class="form-control" id="idBack" name="idBack"
                                    accept="image/*" required>
                            </div>
                            <div class="form-group">
                                <label for="selfie" class="form-label">Selfie:</label>
                                <input type="file" class="form-control" id="selfie" name="selfie"
                                    accept="image/*" required>
                            </div>

                            <div class="form-group">
                                <label for="paymentScreenshot" class="form-label">Payment Screenshot:</label>
                                <input type="file" class="form-control" id="paymentScreenshot"
                                    name="paymentScreenshot" accept="image/*" required>
                            </div>
                            <div class="mt-3">
                                <input type="submit" class="btn btn-primary" value="Submit KYC Data">
                            </div>
                        </form>
                    </div>
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
        $(document).ready(function() {
            $('#kycCopyButton').click(function() {
                let input = $('#kycWallet');
                input.select();
                document.execCommand('copy');
                alert('Link copied to clipboard: ' + input.val());
            });
        });

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
