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

    {{-- preloader --}}

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
                        <h3 style="font-size: 30px;margin-top:10px;"><b>KYC</b></h3>
                        <p class="text-white"><b>(540 Fees for KYC)</b></p>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-body">
                        <h4 class="text-center"><u>Wallet Details</u></h4>
                        <div class="wallet-address">
                            <div class="d-flex justify-content-around align-items-center mb-2">
                                <h5>
                                    Title: <b class="text-warning">{{ $wallet->name }}</b>
                                </h5>
                                <h5>
                                    Wallet: <b class="text-danger">{{ $wallet->wallet }}</b>
                                </h5>
                            </div>
                            <input type="text" class="form-control" id="kycWallet" value="{{ $wallet->number }}"
                                readonly>
                            <i style="margin-top:-30px;margin-right:10px;float:right;color:blue" class="bi bi-clipboard"
                                id="kycCopyButton"></i>
                        </div>
                    </div>
                </div>
                {{-- if kyc status is not null then show this card else not --}}

                @if ($kyc_status_check)
                    @if ($kyc_status_check->status == 'rejected')
                        <div class="card mb-2">
                            <div class="card-body">
                                <h4 class="text-center"><u>Notification</u></h4>
                                <div class="wallet-address">
                                    <div class="d-flex justify-content-around align-items-center mb-2">
                                        <h5>
                                            Your Kyc Rejected to suspicious reasons. Please contact us on our <a
                                                href="{{ route('User.Contact') }}">Help Desk</a>.
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

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
                                <label for="id_front">Upload ID (Front Side):</label><br>
                                <input type="file" id="id_front" name="idFront" accept="image/*"
                                    capture="environment" style="display:none;"
                                    onchange="previewFile(event, 'previewFront')">
                                <button type="button" onclick="document.getElementById('id_front').click()">📷 Scan
                                    Front</button>
                                <div id="previewFront" style="margin-top:10px;"></div>
                            </div>

                            <div class="form-group">
                                <label for="id_back">Upload ID (Back Side):</label><br>
                                <input type="file" id="id_back" name="idBack" accept="image/*"
                                    capture="environment" style="display:none;"
                                    onchange="previewFile(event, 'previewBack')">
                                <button type="button" onclick="document.getElementById('id_back').click()">📷 Scan
                                    Back</button>
                                <div id="previewBack" style="margin-top:10px;"></div>
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

                            <div class="form-group">
                                <label for="trx_id" class="form-label">Trx ID:</label>
                                <input type="number" class="form-control" id="trx_id" name="trx_id" required
                                    maxlength="11">
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

    @include('layouts.links')

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

    {{-- scaner --}}

    <script>
        function previewFile(event, previewId) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).innerHTML =
                    `<img src="${e.target.result}" width="300" style="border:1px solid #ccc; border-radius:8px;">`;
            };
            reader.readAsDataURL(file);
        }
    </script>

    <script>
        window.addEventListener('load', () => {
            document.getElementById('preloader').style.display = 'none';
            document.getElementById('content').style.display = 'block';
        });
    </script>



</body>

</html>
