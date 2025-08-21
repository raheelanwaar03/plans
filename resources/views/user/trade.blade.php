    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Buy/Sell Token</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" />
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

            .card-bg {
                padding: 10px;
                background-color: #ffffff;
                border-radius: 10px;
                text-align: center;
                width: 500px;
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

            #preloader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background-color: #000;
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 9999;
                transition: opacity 0.5s ease, visibility 0.5s ease;
            }

            #preloader.hide {
                opacity: 0;
                visibility: hidden;
            }

            /* Text style */
            .loader-text {
                font-size: 5rem;
                font-weight: bold;
                font-family: Arial, sans-serif;
                color: white;
                display: flex;
                gap: 15px;
            }

            .p {
                color: #00ffff;
            }

            .g,
            .n {
                display: inline-block;
                animation: rotate 1s linear infinite;
            }

            .g {
                color: #00ffff;
                animation-delay: 0.1s;
            }

            .n {
                color: #00ffff;
                animation-delay: 0.3s;
            }

            @keyframes rotate {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            .content {
                display: none;
                padding: 50px;
                text-align: center;
            }
        </style>
    </head>

    <body>

        <div id="preloader">
            <div class="loader-text">
                <span class="p">P</span>
                <span class="g">G</span>
                <span class="n">N</span>
            </div>
        </div>

        <x-alert />

        <!-- Back Arrow Button -->
        <a href="{{ route('User.Dashboard') }}" class="back-arrow">←</a>

        <h1>Buy or Sell Tokens</h1>

        {{-- make a card for show easypaisa wallet details --}}
        <div class="card-bg">
            <div class="card-body">
                <h4>Wallet Details</h4>
                <p><b>Account Title:</b> {{ $wallet->name }}</p>
                <div class="d-flex justify-content-center align-items-center">
                    <p><b>Account Number:</b> <span id="number">{{ $wallet->number }}</span></p>
                    {{-- add icon to copy the account number --}}
                    <i class="bi bi-clipboard" onclick="copyNumber()"
                        style="cursor: pointer; color: blue;margin-top:-17px"></i>
                </div>
                <p><b>Bank Name:</b> {{ $wallet->wallet }}</p>
            </div>
        </div>
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
                <form action="{{ route('User.Sell.Token') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="phoneNO" placeholder="Easypais JazzCash Number" required>
                    <input type="text" name="title" placeholder="Easypais JazzCash Name" required>
                    <input type="number" name="amount" placeholder="Token Amount" required>
                    <select name="bank" id="bank" class="form-control mb-2">
                        <option value="Easypaisa">Easypaisa</option>
                        <option value="Jazzcash">Jazzcash</option>
                        <option value="Nayapay">Nayapay</option>
                        <option value="Sadapay">Sadapay</option>
                    </select>
                    <button type="submit">Sell</button>
                </form>
            </div>

            <div id="buyForm" class="form-box">
                <span class="close-btn" onclick="closeForms()">✖</span>
                <h3>Buy Tokens</h3>
                <form action="{{ route('User.Buy.Token') }}" method="POST" enctype="multipart/form-data">
                    @csrf
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
            // make a function to copy the account number from paragraph tag using id account-num and show in alert
            function copyNumber() {
                var number = document.getElementById("number").innerText.replace("📋", "").trim();

                var tempInput = document.createElement("input");
                tempInput.value = number;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);

                alert("Number " + number + " has been copied!");
            }
        </script>

        <script>
            // Hide preloader after page load
            window.addEventListener("load", () => {
                const preloader = document.getElementById("preloader");
                const content = document.querySelector(".content");

                preloader.classList.add("hide");

                setTimeout(() => {
                    preloader.style.display = "none";
                    content.style.display = "block";
                }, 600); // Match fade out time
            });
        </script>

    </body>

    </html>
