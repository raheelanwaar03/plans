    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Buy/Sell Token</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
        <style>
            body {
                font-family: Arial, sans-serif;
                padding: 40px;
                background: linear-gradient(to right, #4facfe, #00f2fe);
                display: flex;
                flex-direction: column;
                align-items: center;
                position: relative;
            }

            .back-arrow {
                position: absolute;
                top: 20px;
                left: 20px;
                font-size: 24px;
                text-decoration: none;
                color: #333;
                background-color: #e0e0e0;
                padding: 8px 12px;
                border-radius: 50%;
                transition: 0.2s;
            }

            .back-arrow:hover {
                background-color: #ccc;
            }

            h1 {
                margin-top: 10px;
                margin-bottom: 30px;
            }

            .card-container {
                display: flex;
                gap: 20px;
                margin-bottom: 40px;
            }

            .card {
                padding: 10px;
                background-color: #ffffff;
                cursor: pointer;
                border: 2px solid #ccc;
                border-radius: 10px;
                text-align: center;
                width: 200px;
                transition: 0.3s;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            }

            .card:hover {
                background-color: #e0f0ff;
                border-color: #007bff;
            }

            .form-container {
                display: flex;
                justify-content: center;
                width: 100%;
            }

            .form-box {
                display: none;
                background-color: #ffffff;
                padding: 25px;
                border-radius: 10px;
                border: 1px solid #ccc;
                width: 350px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                position: relative;
            }

            .form-box h3 {
                margin-top: 0;
            }

            .form-box input {
                width: 100%;
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 6px;
            }

            .form-box button {
                padding: 10px 20px;
                background-color: #007bff;
                color: #fff;
                border: none;
                border-radius: 6px;
                cursor: pointer;
            }

            .form-box button:hover {
                background-color: #0056b3;
            }

            .close-btn {
                position: absolute;
                top: 10px;
                right: 15px;
                font-size: 18px;
                color: #888;
                cursor: pointer;
            }

            .close-btn:hover {
                color: #f00;
            }
        </style>
    </head>

    <body>

        <!-- Back Arrow Button -->
        <a href="javascript:history.back()" class="back-arrow">←</a>

        <h1>Buy or Sell Tokens</h1>
        <h5 style="color: rgb(255, 0, 128)"><b>Current Price ({{ $tokenPrice->price }} pkr)</b></h5>

        <div class="card-container">
            <div class="card bg-warning text-white" title="Click to Sell PGN" onclick="showForm('sell')">
                <h4>Selling Price</h4>
                <p>({{ $tokenPrice->selling_price }} pkr)</p>
            </div>
            <div class="card bg-success text-white" title="Click to Buy PGN" onclick="showForm('buy')">
                <h4>Buying Price</h4>
                <p>({{ $tokenPrice->buying_price }} pkr)</p>
            </div>
        </div>

        <div class="form-container">
            <div id="sellForm" class="form-box">
                <span class="close-btn" onclick="closeForms()">✖</span>
                <h3>Sell Tokens</h3>
                <form>
                    <input type="email" placeholder="Email" required>
                    <input type="number" placeholder="Easypais JazzCash Number" required>
                    <input type="text" placeholder="Easypais JazzCash Name" required>
                    <input type="number" placeholder="Token Amount" required>
                    <div class="form-group">
                        <label for="tokenSS">Sent Token Screen Shot</label>
                        <input type="file" class="form-control" required>
                    </div>
                    <button type="submit">Sell</button>
                </form>
            </div>

            <div id="buyForm" class="form-box">
                <span class="close-btn" onclick="closeForms()">✖</span>
                <h3>Buy Tokens</h3>
                <form>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="number" name="amount" placeholder="Token amount to buy" required>
                    <div class="form-group">
                        <label for="paySS" style="margin-bottom: 9px">Payment Screen Shot</label>
                        <input type="file" name="paySS" class="form-control" required>
                    </div>
                    <button type="submit">Buy</button>
                </form>
            </div>
        </div>

        <script>
            function showForm(type) {
                closeForms();
                if (type === "sell") {
                    document.getElementById("sellForm").style.display = "block";
                } else if (type === "buy") {
                    document.getElementById("buyForm").style.display = "block";
                }
            }

            function closeForms() {
                document.getElementById("sellForm").style.display = "none";
                document.getElementById("buyForm").style.display = "none";
            }
        </script>

    </body>

    </html>
