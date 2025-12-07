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
        }

        @keyframes fadeLogo {
            to {
                opacity: 1;
                transform: translateX(-50%) scale(1.1);
            }
        }

        /* Register card */
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.25);
            width: 340px;
            text-align: center;
            opacity: 0;
            transform: translateY(100px);
            animation: riseUp 2s ease forwards;
            animation-delay: 3s;
            backdrop-filter: blur(8px);
        }

        @keyframes riseUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-card h2 {
            margin-bottom: 20px;
            color: #333;
            font-weight: 700;
            font-size: 24px;
        }

        .register-card .input-group {
            position: relative;
            width: 100%;
            margin: 10px 0;
        }

        .register-card input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            outline: none;
            transition: border 0.3s, box-shadow 0.3s;
        }

        .register-card input:focus {
            border-color: #ff6ec7;
            box-shadow: 0 0 8px rgba(255, 110, 199, 0.4);
        }

        /* Toggle icon */
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 16px;
            color: #6c63ff;
        }

        .register-card .checkbox {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #444;
            margin: 15px 0;
        }

        .register-card .checkbox input {
            margin-right: 8px;
            accent-color: #6c63ff;
            height: 15px;
            width: 15px;
        }

        .register-card button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #ff6ec7, #6c63ff);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.3s;
            margin-top: 10px;
        }

        .register-card button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 110, 199, 0.4);
        }

        .register-card .links {
            margin-top: 15px;
            font-size: 14px;
        }

        .register-card .links a {
            text-decoration: none;
            color: #6c63ff;
            transition: color 0.3s;
        }

        .register-card .links a:hover {
            color: #4b42d4;
        }

        /* Mobile responsiveness */
        @media (max-width: 480px) {
            .register-card {
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

    <!-- Logo -->
    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="logo">

    <!-- Register Card -->
    <div class="register-card">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <h2>Login to your account</h2>
            <div class="">
                <input type="email" name="email" placeholder="Email">
            </div>

            <!-- Password with toggle -->
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password">
                <span class="toggle-password" onclick="togglePassword('password')">👁️</span>
            </div>

            <!-- Terms & Conditions checkbox -->
            <div class="checkbox">
                <label>
                    <input type="checkbox"> Keep me login in</a>
                </label>
            </div>

            <button>Login</button>
        </form>
        <div class="links">
            <a href="{{ route('login') }}">Already have an account? Login</a>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>

</html>
