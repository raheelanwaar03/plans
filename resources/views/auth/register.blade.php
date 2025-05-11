<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USVentures | Register Page</title>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" />
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
                <div class="col-12 text-center">
                    <h1>{{ env('APP_NAME') }}</h1>
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
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" name="email" id="email" class="form-control"
                                        placeholder="Enter your email">
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="d-flex">
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Enter your password">
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        <i class="bi bi-eye" style="margin-left: -28px;margin-top:8px"
                                            onclick="togglePasswordVisibility('password')"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="form-label"> Confirm Password</label>
                                    <div class="d-flex">
                                        <input type="password" name="password_confirmation" id="confirm_password"
                                            class="form-control" placeholder="Enter your password">
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                        <i class="bi bi-eye" style="margin-left: -28px;margin-top:8px"
                                            onclick="togglePasswordVisibility('confirm_password')"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="referral" class="form-label">Refer By:</label>
                                    <input type="text" name="referral" id="referral" class="form-control"
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

        {{-- <div class="modal fade" id="t&C" tabindex="-1" role="dialog" aria-labelledby="t&C"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark" id="exampleModalLongTitle">T&C</h5>
                    </div>
                    <div class="modal-body">
                        <p class="text-dark">
                            By accessing and using our services, you agree to comply with these terms and conditions.
                            <br><br>
                            Use of Services:
                            <br><br>
                            Our services are provided for informational and transactional purposes only. You agree to
                            use
                            them in accordance with applicable laws and regulations.
                            <br><br>
                            Intellectual Property:
                            <br><br>
                            All intellectual property rights related to our services, including trademarks, copyrights,
                            and
                            patents, are owned by our company. Unauthorized use or reproduction is strictly prohibited.
                            <br><br>
                            Privacy and Data Protection:
                            <br><br>
                            We prioritize your privacy and handle your personal information as outlined in our Privacy
                            Policy. By using our services, you consent to the collection, use, and disclosure of your
                            data
                            as specified in the Privacy Policy.
                            <br><br>
                            Limitation of Liability:
                            <br><br>
                            While we aim to provide accurate and reliable information, we do not guarantee the
                            completeness
                            or accuracy of the content on our platform. We are not liable for any direct or indirect
                            damages
                            arising from your use of our services.
                            <br><br>
                            Third-Party Links:
                            <br><br>
                            Our platform may include links to third-party websites or resources. We do not endorse or
                            assume
                            responsibility for the content, products, or services provided by third parties. Use of
                            these
                            links is at your own risk.
                            <br><br>
                            Termination:
                            <br><br>
                            We reserve the right to suspend or terminate your access to our services at any time,
                            without
                            notice, for any reason we deem necessary.
                            <br><br>
                            Modifications:
                            <br><br>
                            We may update these terms periodically. Any changes will take effect immediately upon
                            posting.
                            It is your responsibility to review these terms regularly to stay informed of the most
                            current
                            version.
                            <br><br>
                            Governing Law:
                            <br><br>
                            These terms are governed by the laws of the CA. Any disputes arising from your use of our
                            services will be resolved in the exclusive jurisdiction of CA courts.
                            <br><br>
                            Severability:
                            <br><br>
                            If any provision of these terms is deemed invalid or unenforceable, the remaining provisions
                            will remain valid and enforceable to the fullest extent allowed by law.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">okay</button>
                    </div>
                </div>
            </div>
        </div> --}}

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
