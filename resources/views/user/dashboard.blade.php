<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }} | User Dashboard</title>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" />
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
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

        .pointer {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class=" icons">
            <!-- Menu/Profile Icon -->
            <i class="fa-solid fa-user menu-icon" id="profile-icon"></i>
        </div>
    </header>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        window.addEventListener('showAlert', event => {
            swal("Success!", event.detail.message, "success");
        })
    </script>

    <main>
        <x-alert />
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="text-dark d-flex justify-content-between align-items-center">
                        <p style="font-size: 20px;margin-top:10px;"><b>Pigeon Mining</b></p>
                        <div id="timer" class="timer text-white">Loading...</div>
                        <script>
                            function startTimer() {
                                const totalHours = 2400; // 2400 hours
                                let startTime = localStorage.getItem("timerStart");

                                // Initialize start time if not set
                                if (!startTime) {
                                    startTime = Date.now();
                                    localStorage.setItem("timerStart", startTime);
                                } else {
                                    startTime = parseInt(startTime);
                                }

                                function updateTimer() {
                                    const currentTime = Date.now();
                                    const elapsedTime = (currentTime - startTime) / 1000; // in seconds
                                    const remainingTime = (totalHours * 3600) - elapsedTime; // total seconds remaining

                                    if (remainingTime <= 0) {
                                        document.getElementById("timer").textContent = "Time's up!";
                                        localStorage.removeItem("timerStart");
                                        return;
                                    }

                                    const hours = Math.floor(remainingTime / 3600);
                                    const minutes = Math.floor((remainingTime % 3600) / 60);
                                    const seconds = Math.floor(remainingTime % 60);

                                    document.getElementById("timer").textContent =
                                        `(${hours}h ${minutes}m ${seconds}s)`;

                                    requestAnimationFrame(updateTimer);
                                }

                                updateTimer();
                            }

                            window.onload = startTimer;
                        </script>
                    </div>
                    <p style="font-size:10px;float: right;margin-top:-10px;color:black">First Withdraw</p>
                </div>
            </div>

            <div class="row justify-content-between align-items-center my-4 text-center">
                <div class="col-12 bg-white text-dark text-center p-4 mb-3" style="border-radius: 10px;">
                    <h3>
                        <i class="bi bi-coin"></i>
                    </h3>
                    <p><span style="font-size: 12px;">Mined PGN</span> <br>
                        <span><b>{{ auth()->user()->balance }} PGN</b></span>
                    </p>
                </div>
                <div class="col-12 bg-white text-dark text-center p-4" style="border-radius: 10px;">
                    <h3>
                        <i class="bi bi-alarm"></i>
                    </h3>
                    <p><span style="font-size: 12px;">Today Timmer</span>
                    <div id="24timer" class="timer" style="margin-top:-15px">24:00:00</div>
                    <script>
                        function start24HourTimer() {
                            const timerDisplay = document.getElementById('24timer');

                            function updateTimer() {
                                const now = new Date();
                                const hours = 23 - now.getHours();
                                const minutes = 59 - now.getMinutes();
                                const seconds = 59 - now.getSeconds();

                                const formattedTime =
                                    String(hours).padStart(2, '0') + ':' +
                                    String(minutes).padStart(2, '0') + ':' +
                                    String(seconds).padStart(2, '0');

                                timerDisplay.textContent = formattedTime;
                            }
                            setInterval(updateTimer, 1000);
                            updateTimer();
                        }
                        start24HourTimer();
                    </script>
                    <a href="{{ route('User.Start.Mine') }}" class="btn btn-primary">Start Mining</a>
                    </p>
                </div>
            </div>

            <div class="row">
                <p class="text-dark">Important Notice
                    <br>
                    <small>For any query, contact CS</small>
                </p>
            </div>
        </div>
    </main>

    <footer>
        <nav class="d-flex justify-content-around align-items-center">
            <a href="{{ route('User.Dashboard') }}" style="color: white;text-decoration: none;"><i class="bi bi-house"
                    style="font-size: 20px;"></i><br><span style="font-size:13px;margin-left: -7px;">Home</span></a>
            <a href="{{ route('User.Boost.Token') }}" style="color: white;text-decoration: none;">
                <i class="bi bi-rocket" style="font-size: 20px;"></i>
                <br><span style="font-size:13px;margin-left: -7px;">Booster</span></a>
            <a href="{{ route('User.KYC.Data') }}" style="color: white;text-decoration: none;">
                <i class="bi bi-patch-question" style="font-size: 20px;"></i><br><span
                    style="font-size:13px;margin-left: -3px;">KYC</span></a>
        </nav>



        <div class="modal fade" id="faq" tabindex="-1" role="dialog" aria-labelledby="faq" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark" id="exampleModalLongTitle">Faq's</h5>
                    </div>
                    <div class="modal-body">
                        <p class="text-dark">
                            Q: What is the minimum account balance required to start submitting products?
                            A: A minimum advance payment of 100 USDT is required to start submitting tasks. After
                            completing
                            the daily task, users must apply for a full withdrawal and receive the withdrawal amount
                            before
                            resetting tasks.
                            <br><br>
                            Q: Can users request an account reset?
                            A: Yes, users can request an account reset from customer service after completing the first
                            set
                            of data.
                            <br><br>
                            Q: Can users request a withdrawal after completing both product sets?
                            A: Yes, users can request a withdrawal only after completing the entire data set.
                            <br><br>
                            Q: Can a withdrawal or refund be requested if a user withdraws or gives up in the middle of
                            product optimization?
                            A: No, withdrawals or refunds cannot be requested in such cases. Users must complete all
                            product
                            submissions before requesting a withdrawal.
                            <br><br>
                            Q: How are funds held in the user’s account?
                            A: All funds are securely held in the user's account and can be withdrawn in full with no
                            processing fee once all data tasks are completed.
                            <br><br>
                            Q: What precautions should users take regarding account security?
                            A: Users should never disclose their login or withdrawal password to others. The platform is
                            not
                            responsible for any loss in such cases. Avoid using personal information like birthdays or
                            phone
                            numbers in passwords.
                            <br><br>
                            Q: What should users do if they forget their login or withdrawal password?
                            A: Users should contact Customer Service for a password reset.
                            <br><br>
                            Q: Can product data that has been assigned to the user’s account be canceled or edited?
                            A: No, once product data has been assigned to your account, it cannot be canceled or edited.
                            <br><br>
                            Q: What is a Combination Product?
                            A: A Combination Product consists of 1 to 3 merged products randomly allocated to the user's
                            account based on availability.
                            <br><br>
                            Q: What is the commission rate for combination products compared to regular products?
                            A: Users can earn 10-100 times the commission rate on combination products compared to
                            regular
                            products.
                            <br><br>
                            Q: Can the combination product be canceled or edited after allocation?
                            A: No, due to contractual obligations with merchants/vendors, combination products cannot be
                            canceled or edited once allocated.
                            <br><br>
                            Q: Is the deposit amount determined by the platform?
                            A: No, the deposit amount is chosen by the user based on their preferences and experience
                            with
                            the platform.
                            <br><br>
                            Q: How can users ensure the accuracy of deposit details?
                            A: Users should always confirm deposit details with Customer Service before making a
                            deposit.
                            <br><br>
                            Q: What happens if a user makes a deposit to the wrong details?
                            A: The platform is not responsible for any deposits made to incorrect details.
                            <br><br>
                            Q: How does delaying product completion affect merchants/vendors?
                            A: Delays can harm vendor progress, product sales, and affect user credibility. Timely
                            completion is crucial for maintaining a positive reputation.
                            <br><br>
                            Q: Can users invite others to join their team?
                            A: Yes, users at VIP3 or higher can invite others using an invitation code and receive about
                            20%
                            of the recommended user’s daily income.
                            <br><br>
                            Q: How much funds are needed on this platform?
                            A: There is no specific amount required. Users are encouraged to manage their funds
                            responsibly.
                            <br><br>
                            Notice: For more details, please click "Contact Us" on the platform to reach our online
                            customer
                            service!
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">okay</button>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="t&C" tabindex="-1" role="dialog" aria-labelledby="t&C" aria-hidden="true">
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
                        <button type="button" class="btn btn-info" data-dismiss="modal">okay</button>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="event" tabindex="-1" role="dialog" aria-labelledby="event" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark" id="exampleModalLongTitle">Events</h5>
                    </div>
                    <div class="modal-body">
                        <p class="text-dark">
                            If your withdrawal amount exceeds your current membership level, you must deposit and
                            upgrade to
                            the corresponding level for approval from the platform and financial department.
                            <br><br>
                            Upgrade Deposit: 5,000 USDT per membership level.
                            Any deposits made will be refunded to your binding address along with the withdrawal amount
                            after the upgrade.
                            Credit Score Policy:
                            <br><br>
                            To maintain a 100% credit score, users must complete all product submissions.
                            Failing to complete tasks on the same day will result in a reduction of your credit score.
                            Your credit score is based on the number of unfinished orders and the completion time.
                            A decreased credit score may affect your ability to process withdrawal requests.
                            Tax Regulations:
                            <br><br>
                            Users with personal funds exceeding 10,000 USDT are required to pay a 35% personal income
                            tax
                            before withdrawing funds.
                            The personal income tax will be refunded 2 hours after the withdrawal is processed.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">okay</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="about" tabindex="-1" role="dialog" aria-labelledby="about"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark" id="exampleModalLongTitle">About</h5>
                    </div>
                    <div class="modal-body">
                        <p class="text-dark">
                            We transform complex business challenges into technology solutions to support the growth of
                            your
                            eCommerce brand.
                            <br><br>
                            ASO (App Store Optimization) is the process of enhancing the visibility and ranking of
                            mobile
                            applications in app store search results, such as the App Store for iOS and Google Play for
                            Android. By optimizing key elements of your app, the aim is to attract more users and
                            increase
                            downloads. Think of ASO as SEO (Search Engine Optimization) for mobile apps.
                            <br><br>
                            ASO is an ongoing effort that involves continuously evaluating and adjusting strategies to
                            keep
                            up with changes in app store algorithms and shifting user needs. A strong ASO strategy not
                            only
                            boosts your app's visibility but also helps attract more users and drive revenue growth.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">okay</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="walletAddress" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark" id="exampleModalLongTitle">Add Wallet Details</h5>
                    </div>
                    <div class="modal-body">
                        <form action="https://usventurs.com/User/Add/Wallet" method="POST">
                            <input type="hidden" name="_token" value="CdZhgKSibdPF5rFR6AUKgun1rtrXt75zTYQFA5wu"
                                autocomplete="off">
                            <div class="form-group" class="form-label">
                                <label for="address" class="form-label text-dark">Wallet Address</label>
                                <input type="text" class="form-control" name="address" id="address">
                            </div>
                            <div class="form-group">
                                <label for="name" class="form-label text-dark">Username</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>

                            <div class="form-group">
                                <label for="wallet_type" class="form-label text-dark">Wallet Type</label>
                                <select class="form-control" name="wallet_type" id="wallet_type">
                                    <option value="BTC">BTC</option>
                                    <option value="ETH">ETH</option>
                                    <option value="TRC">USDT</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Wallet</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </footer>

    <!-- Sidebar -->

    @include('layouts.sidebar')

    <!-- JavaScript for Sidebar -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

    <script>
        const profileIcon = document.getElementById('profile-icon');
        const sidebar = document.getElementById('sidebar');
        const closeIcon = document.getElementById('close-icon');

        // Toggle Sidebar
        profileIcon.addEventListener('click', () => {
            sidebar.classList.add('active');
        });

        // Hide Sidebar
        closeIcon.addEventListener('click', () => {
            sidebar.classList.remove('active');
        });
    </script>

</body>

</html>
