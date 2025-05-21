<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }} | Register Page</title>
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
            /* add gradient color to the body with #00a99d */
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
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="icons">
        </div>
    </header>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        window.addEventListener('showAlert', event => {
            swal("Success!", event.detail.message, "success");
        })
    </script>

    <!-- Main Content -->
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo" height="80px" width="180px">
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="row p-3">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <div class="">
                                    <h5>Register Now</h5>
                                </div>
                                <div class="">
                                    <a href="{{ route('login') }}">Login Now!</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('register') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="form-label">Username</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Enter your username">
                                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
                                </div>
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" name="email" id="email" class="form-control"
                                        placeholder="Enter your email">
                                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                                </div>
                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="d-flex">
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Enter your password">
                                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                                        <i class="bi bi-eye" style="margin-left: -28px;margin-top:8px"
                                            onclick="togglePasswordVisibility('password')"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="form-label"> Confirm Password</label>
                                    <div class="d-flex">
                                        <input type="password" name="password_confirmation" id="confirm_password"
                                            class="form-control" placeholder="Enter your password">
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
                                        <i class="bi bi-eye" style="margin-left: -28px;margin-top:8px"
                                            onclick="togglePasswordVisibility('confirm_password')"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="referral" class="form-label">Refer By:</label>
                                    <input type="text" name="referral" readonly id="referral" class="form-control"
                                        value="{{ $referral }}">
                                </div>

                                <div class="form-group mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="terms" id="terms"
                                            value="1">
                                        <label class="form-check-label" for="terms">
                                            I agree to the <span style="color:rgb(105, 105, 239)" data-toggle="modal"
                                                data-target="#t&C"><u>Term's and Conditions</u></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-2 d-flex justify-content-between align-items-center">
                                    <button type="submit" class="btn btn-info text-white">Register</button>
                                    <a href="{{ route('login') }}" class="btn btn-outline-info text-dark">Already have
                                        Account?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <script>
            function togglePasswordVisibility(fieldId) {
                const field = document.getElementById(fieldId);
                field.type = field.type === 'password' ? 'text' : 'password';
            }
        </script>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    </footer>
</body>

</html>
