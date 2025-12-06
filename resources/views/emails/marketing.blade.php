<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Email Update</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #eef1f7;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        .wrapper {
            width: 100%;
            padding: 30px 0;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.12);
        }

        .header {
            background: linear-gradient(135deg, #4e73df, #2e59d9);
            padding: 30px 20px;
            text-align: center;
            color: #fff;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            letter-spacing: 1px;
        }

        .body {
            padding: 30px 25px;
            color: #333;
        }

        .body p {
            font-size: 16px;
            line-height: 1.6em;
            margin: 0 0 15px;
        }

        .highlight-box {
            background: #f6f9ff;
            padding: 18px;
            border-left: 5px solid #4e73df;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 15px;
            color: #444;
        }

        .btn {
            display: inline-block;
            margin-top: 15px;
            padding: 12px 20px;
            background: #4e73df;
            color: #fff !important;
            font-weight: bold;
            border-radius: 6px;
            text-decoration: none;
        }

        .footer {
            padding: 18px;
            text-align: center;
            font-size: 13px;
            color: #777;
            background: #fafafa;
            border-top: 1px solid #eaeaea;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">

            <!-- Header -->
            <div class="header">
                <h1>📢 Latest Update</h1>
            </div>

            <!-- Body -->
            <div class="body">
                <p>Hello {{ $user->name ?? 'User' }},</p>

                <p>We are excited to share the latest update with you. Please see the details below:</p>

                <!-- Highlighted Box -->
                <div class="highlight-box">
                    {!! nl2br($content) !!}
                </div>

                <p>If you need more details, feel free to visit our website.</p>

                <a href="{{ url('/') }}" class="btn">Visit Website</a>
            </div>

            <!-- Footer -->
            <div class="footer">
                &copy; {{ date('Y') }} {{ config('app.name') }} — All Rights Reserved<br>
                You are receiving this email because you subscribed or registered on our platform.
            </div>

        </div>
    </div>
</body>

</html>
