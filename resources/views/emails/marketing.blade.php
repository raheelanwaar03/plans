<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $subjectLine ?? 'Newsletter' }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f5f6f8; padding: 30px;">
    <div style="max-width: 600px; background: #fff; margin: auto; border-radius: 8px; padding: 20px;">
        <h2 style="color: #333; text-align:center;">{{ config('app.name') }}</h2>
        <hr>
        <p style="font-size: 16px; color: #444;">
            {!! nl2br(e($bodyMessage)) !!}
        </p>
        <hr>
        <p style="font-size: 14px; color: #888; text-align:center;">
            You’re receiving this email because you subscribed to {{ config('app.name') }} updates.
        </p>
    </div>
</body>
</html>
