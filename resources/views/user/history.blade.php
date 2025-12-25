<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw History</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: linear-gradient(to right, #4facfe, #00f2fe);
            /* neutral background */
            padding: 16px;
        }

        /* HEADER */
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
        }

        .back {
            font-size: 22px;
            cursor: pointer;
            margin-right: 10px;
            color: #333;
        }

        .title {
            font-size: 18px;
            font-weight: 600;
            color: #222;
        }

        /* TRANSACTION ROW */
        .tx {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 14px;
            border-radius: 12px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        /* LIGHT COLOR VARIANTS */
        .tx.green {
            background: #ecfdf3;
            color: #1f9254;
        }

        .tx.red {
            background: #fff1f2;
            color: #c0362c;
        }

        .tx.blue {
            background: #eef4ff;
            color: #2b5fd9;
        }

        .tx.purple {
            background: #f4f1ff;
            color: #6b4eff;
        }

        /* LEFT */
        .tx-left {
            display: flex;
            flex-direction: column;
        }

        .method {
            font-weight: 600;
            color: #222;
        }

        .status-text {
            font-size: 12px;
            opacity: 0.85;
        }

        /* RIGHT */
        .amount {
            font-weight: 700;
            font-size: 15px;
        }

        /* MOBILE */
        @media (max-width: 480px) {
            .tx {
                padding: 10px 12px;
            }
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="back" onclick="history.back()">←</div>
        <div class="title">Withdraw History</div>
    </div>

    @foreach ($history as $item)
        <div class="tx blue">
            <div class="tx-left">
                <div class="method">{{ $item->title }}</div>
                <div class="status-text">{{ $item->status }} ({{ $item->created_at }})</div>
            </div>
            <div class="amount">-{{ $item->amount }} PGN</div>
        </div>
    @endforeach

</body>

</html>
