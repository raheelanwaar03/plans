<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" />
    <style>
        body {
            background: linear-gradient(to right, #4facfe, #00f2fe);
            font-family: 'Arial', sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .profile-container {
            max-width: 900px;
            margin: 50px auto;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .profile-header {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            padding: 50px 20px;
            text-align: center;
            color: #fff;
        }

        .profile-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #fff;
            margin-bottom: 15px;
        }

        .profile-header h2 {
            margin: 10px 0;
            font-size: 28px;
            font-weight: bold;
        }

        .profile-header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .profile-body {
            padding: 30px 20px;
        }

        .profile-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 15px 20px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            background: #f9f9f9;
        }

        .profile-info div {
            text-align: center;
        }

        .profile-info h5 {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .profile-info p {
            font-size: 14px;
            color: #666;
        }

        .referral-section {
            text-align: center;
            margin-top: 20px;
        }

        .referral-box {
            font-size: 18px;
            font-weight: bold;
            background: #f1f5f9;
            color: #333;
            padding: 15px;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 10px;
        }

        .copy-button {
            background: #2575fc;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .copy-button:hover {
            background: #1a5ecb;
        }

        .success-message {
            color: green;
            margin-top: 10px;
            display: none;
        }

        .footer {
            background: #f1f5f9;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>

<body>
    <!-- Profile Container -->
    <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">


            <div class="d-flex justify-content-start align-items-center">
                <a href="{{ route('User.Dashboard') }}" style="font-size: 30px;color:white"><i
                        class="bi bi-arrow-left-circle"></i></a>
            </div>

            <img src="http://usventures.test/assets/images/user.png" alt="Profile Picture">
            <h2 class="text-capitalize">User</h2>
            <p></p>
        </div>

        <!-- Profile Body -->
        <div class="profile-body">
            <!-- User Information -->
            <div class="profile-info">
                <div>
                    <h5>Username</h5>
                    <p class="text-capitalize">{{ auth()->user()->name }}</p>
                </div>
                <div>
                    <h5>Joined</h5>
                    <p>{{ auth()->user()->created_at }}</p>
                </div>
            </div>
            <div class="profile-info">
                <div>
                    <h5>Wallet Balance</h5>
                    <p>
                        {{ auth()->user()->balance }}
                    </p>
                </div>
                <div>
                    <h5>Status</h5>
                    <p>

                        <span class="badge bg-success">{{ auth()->user()->status }}</span>
                    </p>
                </div>
            </div>

            <!-- Referral Section -->
            <div class="referral-section">
                <h4>Your Referral Code</h4>
                <div id="referralCode" class="referral-box">{{ route('register', ['referral' => Auth::user()->email]) }}
                </div>
                <button class="copy-button" onclick="copyReferralCode()">Copy Code</button>
                <div id="successMessage" class="success-message">Referral code copied to clipboard!</div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        © 2025 Profile Page. All rights reserved.
    </div>

    <script>
        function copyReferralCode() {
            var referralCode = document.getElementById('referralCode');
            var textArea = document.createElement('textarea');
            textArea.value = referralCode.textContent;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('Copy');
            textArea.remove();
            document.getElementById('successMessage').style.display = 'block';
        }
    </script>
</body>

</html>
