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
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
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
    <x-alert />
    <header>
        <div class=" icons">
            <!-- Menu/Profile Icon -->
            <i class="fa-solid fa-user menu-icon" id="profile-icon"></i>
        </div>
    </header>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        window.addEventListener('showAlert', event => {
            swal("Success!", event.detail.message, "success");
        })
    </script>

    <style>
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .wallet-logo {
            width: 50px;
            height: 50px;
        }

        .copy-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .copy-btn:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="text-dark text-center">
                    <h3 style="font-size: 30px;"><b>Premium</b></h3>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-body">
                    <div class="form-group">
                        <label for="walletAddress" class="form-label">Trust Wallet Address:</label>
                        <div class="wallet-address">
                            <input type="text" class="form-control" id="kycWallet"
                                value="0x7129C2aa9750BFf9d2C77C55A08f538b2d768c78" readonly>
                            <i style="margin-top:-30px;margin-right:10px;float:right;color:blue" class="bi bi-clipboard"
                                id="kycCopyButton"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Deposit Amount Section -->
        <h5>PGN Amount</h5>
        <div class="row justify-content-around align-items-center my-3">
            <div class="col-3 text-center bg-white text-dark p-2" style="border-radius: 15px">
                <div class="deposit-option" onclick="setDepositAmount($5 - 10 PGN)">
                    <p>$5 - 10 PGN</p>
                </div>
            </div>
            <div class="col-3 text-center bg-white text-dark p-2" style="border-radius: 15px">
                <div class="deposit-option" onclick="setDepositAmount($10 - 25 PGN)">
                    <p>$10 - 25 PGN</p>

                </div>
            </div>
            <div class="col-3 text-center bg-white text-dark p-2" style="border-radius: 15px">
                <div class="deposit-option" onclick="setDepositAmount($15 - 40 PGN)">
                    <p>$15 - 40 PGN</p>
                </div>
            </div>
        </div>

        <!-- Custom Deposit Amount -->
        <div class="card my-2">
            <div class="card-body">
                <form action="{{ route('User.Premium.Option') }}" method="POST" enctype="multipart/form-data"
                    id="premiumForm">
                    @csrf
                    <div class="form-group mb-2">
                        <input type="email" class="form-control" name="userEmail" value="{{ auth()->user()->email }}"
                            readonly required>
                    </div>
                    <div class="form-group">
                        <select name="premiumOption" class="form-control">
                            <option value="$5 - 10 PGN">$5 - 10 PGN</option>
                            <option value="$10 - 25 PGN">$10 - 25 PGN</option>
                            <option value="$15 - 40 PGN">$15 - 40 PGN</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="paymentScreenshot" class="form-label">Payment Screenshot:</label>
                        <input type="file" id="paymentScreenshot" class="form-control" name="paymentScreenshot"
                            accept="image/*" required>
                    </div>
                    <div class="form-group mt-2">
                        <button type="submit" class="btn btn-sm btn-primary">Buy Premium</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
