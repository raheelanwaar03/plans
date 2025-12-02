<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo.png') }}">
    <title>Authentication | Pigeon Mining</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
        }

        /* Pigeon animation */
        .pigeon {
            position: absolute;
            width: 120px;
            top: -200px;
            left: 50%;
            transform: translateX(-50%);
            animation: dropIn 4s ease forwards;
        }

        @keyframes dropIn {
            0% {
                top: -200px;
                opacity: 0;
            }

            50% {
                top: 10%;
                opacity: 1;
            }

            100% {
                top: 25%;
                opacity: 1;
            }
        }

        /* Logo animation */
        .logo {
            position: absolute;
            top: 5%;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            opacity: 0;
            animation: fadeLogo 2s ease forwards;
            animation-delay: 5s;
            /* appears after pigeon */
        }

        @keyframes fadeLogo {
            to {
                opacity: 1;
                transform: translateX(-50%) scale(1.1);
            }
        }

        /* Login card */
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
            width: 320px;
            text-align: center;
            opacity: 0;
            transform: translateY(100px);
            animation: riseUp 2s ease forwards;
            animation-delay: 3s;
        }

        @keyframes riseUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card h2 {
            margin-bottom: 20px;
            color: #333;
            font-weight: 600;
        }

        .login-card input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            transition: border 0.3s, box-shadow 0.3s;
        }

        .login-card input:focus {
            border-color: #6c63ff;
            box-shadow: 0 0 8px rgba(108, 99, 255, 0.4);
        }

        .login-card button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #6c63ff, #4b42d4);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: transform 0.2s, box-shadow 0.3s;
            margin-top: 10px;
        }

        .login-card button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(108, 99, 255, 0.4);
        }

        .login-card .links {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }

        .login-card .links a {
            text-decoration: none;
            color: #6c63ff;
            transition: color 0.3s;
        }

        .login-card .links a:hover {
            color: #4b42d4;
        }

        /* Mobile responsiveness */
        @media (max-width: 480px) {
            .login-card {
                width: 90%;
                padding: 25px;
            }

            .logo {
                width: 80px;
            }

            .pigeon {
                width: 90px;
            }
        }
    </style>
</head>

<body>
    <!-- Pigeon -->
    <img src="{{ asset('assets/images/pigeon.png') }}" alt="Pigeon" class="pigeon">

    <!-- Logo (replace with your own logo image) -->
    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="logo">

    <!-- Login Card -->
    <div class="login-card">
        <h2>Welcome Back</h2>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <button type="submit">Login</button>
            <div class="links">
                <a href="#">Forgot Password?</a>
                <a href="{{ route('register') }}">Register Now</a>
            </div>
        </form>
    </div>
</body>

</html>
