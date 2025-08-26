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
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            color: #fff;
            display: flex;
            flex-direction: column;
            height: auto;
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

    {{-- preloader --}}

    <div id="preloader">
        <div class="letters">
            <span class="p">P</span>
            <span class="g">G</span>
            <span class="n">N</span>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="">
                    <a href="{{ route('User.Dashboard') }}" style="font-size: 30px;color:white"><i
                            class="bi bi-arrow-left-circle"></i></a>
                </div>
                <div class="text-dark text-center">
                    <h3 style="font-size: 30px;"><b>History</b></h3>
                </div>
            </div>
        </div>

        {{-- Add Datatable --}}

        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="example" class="display">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($history as $item)
                                <tr>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->phoneNo }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>
                                        @if ($item->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif ($item->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>

        <script>
            // Hide preloader once page loads
            window.addEventListener("load", function() {
                setTimeout(() => {
                    document.getElementById("preloader").style.display = "none";
                    document.getElementById("main-content").style.display = "block";
                }, 2500); // wait for animation to finish
            });
        </script>
    </footer>

</body>

</html>
