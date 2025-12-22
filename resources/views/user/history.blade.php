<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }} | User Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.min.css" rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo.png') }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            color: #fff;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Header */
        header {
            background: #2e3b4e;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header .menu-icon {
            font-size: 24px;
            cursor: pointer;
        }

        @media (max-width: 576px) {
            header {
                flex-direction: column;
                gap: 10px;
            }
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: -100%;
            width: 300px;
            height: 100%;
            background: #fff;
            color: #333;
            padding: 20px;
            transition: 0.3s ease;
            z-index: 1050;
            overflow-y: auto;
        }

        .sidebar.active {
            left: 0;
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 85%;
            }
        }

        .sidebar h5 {
            color: #2e3b4e;
            margin-bottom: 15px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 12px;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .logout a {
            color: red;
            font-weight: bold;
        }

        /* Preloader */
        #preloader {
            position: fixed;
            inset: 0;
            background: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .loader {
            font-size: 64px;
            font-weight: 800;
            display: flex;
            gap: 5px;
        }

        .p {
            color: #7c3aed;
        }

        .g,
        .n {
            color: #e5e7eb;
            opacity: 0;
            animation: fadeMove 3s infinite;
        }

        .g {
            animation-delay: .3s;
        }

        .n {
            animation-delay: 1.6s;
        }

        @keyframes fadeMove {
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
            }

            70% {
                opacity: 0;
                transform: translateX(30px);
            }

            100% {
                opacity: 0;
            }
        }

        /* Table */
        .dataTables_wrapper {
            color: #000;
        }
    </style>
</head>

<body>

    <x-alert />

    <!-- Preloader -->
    <div id="preloader">
        <div class="loader">
            <span class="p">P</span>
            <span class="g">G</span>
            <span class="n">N</span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-4">

        <!-- Back Button -->
        <div class="mb-3">
            <a href="{{ route('User.Dashboard') }}" class="text-white fs-3">
                <i class="bi bi-arrow-left-circle"></i>
            </a>
        </div>

        <!-- Title -->
        <h3 class="text-center fw-bold fs-4 fs-md-3 mb-4">History</h3>

        <!-- Table -->
        <div class="d-flex justify-content-center">
            <div class="table-responsive w-50">
                <table id="example" class="table table-striped table-bordered nowrap w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($history as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
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
                </table>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                responsive: true,
                pageLength: 10,
                autoWidth: false
            });
        });

        window.addEventListener('load', () => {
            document.getElementById('preloader').style.display = 'none';
        });
    </script>

</body>

</html>
