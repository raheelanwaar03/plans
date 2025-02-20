<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        header,
        footer {
            background: #333;
            color: #fff;
            padding: 10px 0;
        }

        .timer {
            font-size: 1.5em;
            color: #555;
        }

        button {
            margin: 5px;
            padding: 5px 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        textarea {
            width: 80%;
            margin: 10px 0;
        }

        /* Links Section */
        .links a {
            text-decoration: none;
            color: #007BFF;
        }

        .links a:hover {
            text-decoration: underline;
        }

        /* List Styling */
        ul {
            list-style: none;
            padding: 0;
        }

        /* KYC Form */
        .kyc-form {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            margin: 20px auto;
            width: 80%;
            text-align: left;
        }

        .kyc-form h2 {
            text-align: center;
        }

        .kyc-form label {
            display: block;
            margin: 10px 0 5px;
        }

        .kyc-form input[type="file"],
        .kyc-form input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }

        .kyc-form .wallet-address {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }

        .kyc-form .wallet-address input {
            width: calc(100% - 110px);
            padding: 8px;
        }

        .kyc-form .wallet-address button {
            width: 100px;
            margin-left: 10px;
        }

        .kyc-form input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        .kyc-form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .btn {
            padding: 8px;
            background-color: red;
            text-decoration: none;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: white;
            color: red;
            border: 1px solid red
        }
    </style>
</head>

<body>
    <x-alert />
    <header>
        <h1>Pigeon Mining</h1>
        <div id="mainTimer" class="timer">2400:00:00</div>
        <h2>First Withdraw</h2>
    </header>
    <main>
        <!-- Mining Section -->
        <div id="miningTimer" class="timer">24:00:00</div>
        <div id="minedAmount" class="mined-amount">Mined PGN: 0</div>
        <button id="startButton" class="start-button">Start Mining</button>
        {{-- add logout button --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
        <!-- Tasks Section -->
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Token Earning Program</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    text-align: center;
                    background-color: #f4f4f9;
                    padding: 20px;
                }

                .link {
                    margin: 10px 0;
                    display: inline-block;
                    padding: 10px 20px;
                    background-color: #007bff;
                    color: #fff;
                    text-decoration: none;
                    border-radius: 5px;
                }

                .link:hover {
                    background-color: #0056b3;
                }

                .tokens {
                    margin-top: 20px;
                    font-size: 18px;
                    color: green;
                }
            </style>
        </head>

        <body>
            <h1>Earn Tokens</h1>
            <p>Click on a link, stay for 20 seconds, and earn 2 tokens! You can only visit each site once every 24
                hours.</p>
            <div id="links">
                <a href="https://towelinfo.com" class="link" target="_blank" data-url="https://towelinfo.com">Towel
                    Info</a>
                <a href="https://allserieshub.com" class="link" target="_blank"
                    data-url="https://allserieshub.com">All Series Hub</a>
                <a href="https://aerecipes.com" class="link" target="_blank" data-url="https://aerecipes.com">AE
                    Recipes</a>
                <a href="https://servicesh.xyz" class="link" target="_blank" data-url="https://servicesh.xyz">Service
                    SH</a>
                <a href="https://earbudsu.com" class="link" target="_blank" data-url="https://earbudsu.com">Earbuds
                    U</a>
                <a href="https://namemean.xyz" class="link" target="_blank" data-url="https://namemean.xyz">Name
                    Mean</a>
            </div>
            <div class="tokens">Tokens Earned: <span id="tokenCount">0</span></div>

            <script src="script.js"></script>
        </body>

        </html>


        <!-- Boost Section -->
        <ul>
            <h2>Boost</h2>
            <li>100 PGN - 10 fee mon <button>Boost now</button></li>
            <li>300 PGN - 30 fee mon <button>Boost now</button></li>
            <li>50 PGN - 60 fee mon <button>Boost now</button></li>

            <form action="/boost" method="POST">
                <input type="email" name="userEmail" placeholder="Your Email" required>
                <select name="boostOption">
                    <option value="100 PGN">100 PGN</option>
                    <option value="300 PGN">300 PGN</option>
                    <option value="500 PGN">500 PGN</option>
                </select>
                <button type="submit">Buy Boost</button>
            </form>

        </ul>

        <!-- Premium Section -->
        <ul>
            <h2>Premium</h2>
            <li>$5 - 10 PGN</li>
            <li>$10 - 25 PGN</li>
            <li>$15 - 40 PGN</li>
            <form action="/premium" method="POST" enctype="multipart/form-data" id="premiumForm">
                <input type="email" name="userEmail" placeholder="Your Email" required>
                <select name="premiumOption">
                    <option value="$5 - 10 PGN">$5 - 10 PGN</option>
                    <option value="$10 - 25 PGN">$10 - 25 PGN</option>
                    <option value="$15 - 40 PGN">$15 - 40 PGN</option>
                </select>
                <label for="paymentScreenshot">Payment Screenshot:</label>
                <input type="file" id="paymentScreenshot" name="paymentScreenshot" accept="image/*" required>

                <label for="walletAddress">Trust Wallet Address:</label>
                <div class="wallet-address">
                    <input type="text" id="walletAddress" name="walletAddress"
                        value="0xf574c7c90a86727301D184403cfCB63ca81d4E58" readonly>
                    <button type="button" id="copyAddressButton">Copy Address</button>
                </div>

                <button type="submit">Buy Premium</button>
            </form>
            <script>
                // Copy Wallet Address to Clipboard
                document.getElementById("copyAddressButton").addEventListener("click", () => {
                    const walletAddress = document.getElementById("walletAddress");
                    navigator.clipboard.writeText(walletAddress.value).then(() => {
                        alert("Wallet address copied to clipboard!");
                    });
                });

                // Handle Premium Form Submission
                document.getElementById("premiumForm").addEventListener("submit", async (e) => {
                    e.preventDefault(); // Prevent default form submission

                    const formData = new FormData(document.getElementById("premiumForm"));

                    try {
                        const response = await fetch('/premium', {
                            method: 'POST',
                            body: formData,
                        });

                        if (response.ok) {
                            alert("Your premium purchase has been submitted successfully!");
                            document.getElementById("premiumForm").reset(); // Reset the form
                        } else {
                            alert("Failed to submit. Please try again.");
                        }
                    } catch (error) {
                        console.error("Error submitting premium purchase:", error);
                        alert("An error occurred. Please try again.");
                    }
                });
            </script>

        </ul>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Referral Dashboard</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f9f9f9;
                    padding: 20px;
                }

                .container {
                    max-width: 800px;
                    margin: auto;
                    background: #fff;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }

                h2 {
                    text-align: center;
                    color: #333;
                }

                .referral-box,
                .details-box {
                    margin-top: 20px;
                    padding: 15px;
                    background: #f4f4f9;
                    border: 1px dashed #007bff;
                    border-radius: 5px;
                }

                button {
                    margin-top: 10px;
                    padding: 10px 20px;
                    background-color: #007bff;
                    color: #fff;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }

                button:hover {
                    background-color: #0056b3;
                }

                table {
                    width: 100%;
                    \n margin-top: 20px;
                    border-collapse: collapse;
                }

                table,
                th,
                td {
                    border: 1px solid #ddd;
                }

                th,
                td {
                    padding: 10px;
                    text-align: center;
                }

                th {
                    background-color: #007bff;
                    color: white;
                }
            </style>
        </head>

        <body>
            <div class="container">
                <h2>Referral Dashboard</h2>
                <div class="referral-box">
                    <p>Your Referral Link:</p>
                    <input type="text" id="referralLink" readonly>
                    <button onclick="copyReferralLink()">Copy Link</button>
                </div>
                <div class="details-box">
                    <h3>Referral Details</h3>
                    <p>Total Tokens Earned: <span id="totalTokens">0</span></p>
                    <h4>Referred Users:</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Joined Date</th>
                            </tr>
                        </thead>
                        <tbody id="referralTable">
                            <!-- Referral data will be inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <script>
                const username = 'yourUsername'; // Replace with dynamic username

                // Set referral link
                document.getElementById('referralLink').value = `https://example.com/signup?ref=${username}`;

                // Copy referral link to clipboard
                function copyReferralLink() {
                    const referralLink = document.getElementById('referralLink');
                    referralLink.select();
                    referralLink.setSelectionRange(0, 99999); // Mobile devices
                    navigator.clipboard.writeText(referralLink.value)
                        .then(() => alert('Referral link copied to clipboard!'))
                        .catch(() => alert('Failed to copy the link.'));
                }

                // Fetch referral data
                async function fetchReferralData() {
                    const response = await fetch(`/api/referrals?ref=${username}`);
                    const data = await response.json();

                    // Update tokens
                    document.getElementById('totalTokens').innerText = data.totalTokens;

                    // Update referred users table
                    const referralTable = document.getElementById('referralTable');
                    referralTable.innerHTML = '';
                    data.referrals.forEach((referral, index) => {
                        const row = `<tr>
                    <td>${index + 1}</td>
                    <td>${referral.username}</td>
                    <td>${referral.joinedDate}</td>
                </tr>`;
                        referralTable.innerHTML += row;
                    });
                }

                // Load data on page load
                fetchReferralData();
            </script>
        </body>

        </html>



        </form>

        <!-- KYC Form -->
        <section class="kyc-form">
            <h2>KYC Verification</h2>
            <form action="{{ route('User.KYC.Data') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="fullName">Full Name:</label>
                <input type="text" id="fullName" name="name" required>

                <label for="mobileNumber">Mobile Number:</label>
                <input type="text" id="mobileNumber" name="number" required>

                <label for="idFront">ID Card (Front):</label>
                <input type="file" id="idFront" name="idFront" accept="image/*" required>

                <label for="idBack">ID Card (Back):</label>
                <input type="file" id="idBack" name="idBack" accept="image/*" required>

                <label for="selfie">Selfie:</label>
                <input type="file" id="selfie" name="selfie" accept="image/*" required>

                <label for="paymentScreenshot">Payment Screenshot:</label>
                <input type="file" id="paymentScreenshot" name="paymentScreenshot" accept="image/*" required>

                <label for="walletAddress">Trust Wallet Address:</label>
                <div class="wallet-address">
                    <input type="text" id="walletAddress" value="0xf574c7c90a86727301D184403cfCB63ca81d4E58"
                        readonly>
                    <button type="button" id="copyAddressButton">Copy Address</button>
                </div>
                <input type="submit" value="Submit KYC">
            </form>
        </section>
    </main>
    <script>
        // Copy Wallet Address
        const copyAddressButton = document.getElementById('copyAddressButton');
        const walletAddressInput = document.getElementById('walletAddress');
        copyAddressButton.addEventListener('click', () => {
            navigator.clipboard.writeText(walletAddressInput.value);
            alert('Wallet Address copied to clipboard!');
        });
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 60%;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
        }

        input[type="file"] {
            margin-top: 10px;
        }

        .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Contact Us</h1>
        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="country">Country</label>
                <select id="country" name="country" required>
                    <option value="">Select your country</option>
                    <option value="Afghanistan">Afghanistan</option>
                    <option value="Albania">Albania</option>
                    <option value="Algeria">Algeria</option>
                    <option value="Andorra">Andorra</option>
                    <option value="Angola">Angola</option>
                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Armenia">Armenia</option>
                    <option value="Australia">Australia</option>
                    <option value="Austria">Austria</option>
                    <option value="Azerbaijan">Azerbaijan</option>
                    <option value="Bahamas">Bahamas</option>
                    <option value="Bahrain">Bahrain</option>
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="Barbados">Barbados</option>
                    <option value="Belarus">Belarus</option>
                    <option value="Belgium">Belgium</option>
                    <option value="Belize">Belize</option>
                    <option value="Benin">Benin</option>
                    <option value="Bhutan">Bhutan</option>
                    <option value="Bolivia">Bolivia</option>
                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                    <option value="Botswana">Botswana</option>
                    <option value="Brazil">Brazil</option>
                    <option value="Brunei">Brunei</option>
                    <option value="Bulgaria">Bulgaria</option>
                    <option value="Burkina Faso">Burkina Faso</option>
                    <option value="Burundi">Burundi</option>
                    <option value="Cambodia">Cambodia</option>
                    <option value="Cameroon">Cameroon</option>
                    <option value="Canada">Canada</option>
                    <option value="Cape Verde">Cape Verde</option>
                    <option value="Central African Republic">Central African Republic</option>
                    <option value="Chad">Chad</option>
                    <option value="Chile">Chile</option>
                    <option value="China">China</option>
                    <option value="Colombia">Colombia</option>
                    <option value="Comoros">Comoros</option>
                    <option value="Congo">Congo</option>
                    <option value="Costa Rica">Costa Rica</option>
                    <option value="Croatia">Croatia</option>
                    <option value="Cuba">Cuba</option>
                    <option value="Cyprus">Cyprus</option>
                    <option value="Czech Republic">Czech Republic</option>
                    <option value="Denmark">Denmark</option>
                    <option value="Djibouti">Djibouti</option>
                    <option value="Dominica">Dominica</option>
                    <option value="Dominican Republic">Dominican Republic</option>
                    <option value="Ecuador">Ecuador</option>
                    <option value="Egypt">Egypt</option>
                    <option value="El Salvador">El Salvador</option>
                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                    <option value="Eritrea">Eritrea</option>
                    <option value="Estonia">Estonia</option>
                    <option value="Eswatini">Eswatini</option>
                    <option value="Ethiopia">Ethiopia</option>
                    <option value="Fiji">Fiji</option>
                    <option value="Finland">Finland</option>
                    <option value="France">France</option>
                    <option value="Gabon">Gabon</option>
                    <option value="Gambia">Gambia</option>
                    <option value="Georgia">Georgia</option>
                    <option value="Germany">Germany</option>
                    <option value="Ghana">Ghana</option>
                    <option value="Greece">Greece</option>
                    <option value="Grenada">Grenada</option>
                    <option value="Guatemala">Guatemala</option>
                    <option value="Guinea">Guinea</option>
                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                    <option value="Guyana">Guyana</option>
                    <option value="Haiti">Haiti</option>
                    <option value="Honduras">Honduras</option>
                    <option value="Hungary">Hungary</option>
                    <option value="Iceland">Iceland</option>
                    <option value="India">India</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Iran">Iran</option>
                    <option value="Iraq">Iraq</option>
                    <option value="Ireland">Ireland</option>
                    <option value="Israel">Israel</option>
                    <option value="Italy">Italy</option>
                    <option value="Jamaica">Jamaica</option>
                    <option value="Japan">Japan</option>
                    <option value="Jordan">Jordan</option>
                    <option value="Kazakhstan">Kazakhstan</option>
                    <option value="Kenya">Kenya</option>
                    <option value="Kiribati">Kiribati</option>
                    <option value="Korea, North">Korea, North</option>
                    <option value="Korea, South">Korea, South</option>
                    <option value="Kuwait">Kuwait</option>
                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                    <option value="Laos">Laos</option>
                    <option value="Latvia">Latvia</option>
                    <option value="Lebanon">Lebanon</option>
                    <option value="Lesotho">Lesotho</option>
                    <option value="Liberia">Liberia</option>
                    <option value="Libya">Libya</option>
                    <option value="Liechtenstein">Liechtenstein</option>
                    <option value="Lithuania">Lithuania</option>
                    <option value="Luxembourg">Luxembourg</option>
                    <option value="Madagascar">Madagascar</option>
                    <option value="Malawi">Malawi</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Maldives">Maldives</option>
                    <option value="Mali">Mali</option>
                    <option value="Malta">Malta</option>
                    <option value="Marshall Islands">Marshall Islands</option>
                    <option value="Mauritania">Mauritania</option>
                    <option value="Mauritius">Mauritius</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Micronesia">Micronesia</option>
                    <option value="Moldova">Moldova</option>
                    <option value="Monaco">Monaco</option>
                    <option value="Mongolia">Mongolia</option>
                    <option value="Montenegro">Montenegro</option>
                    <option value="Morocco">Morocco</option>
                    <option value="Mozambique">Mozambique</option>
                    <option value="Myanmar">Myanmar</option>
                    <option value="Namibia">Namibia</option>
                    <option value="Nauru">Nauru</option>
                    <option value="Nepal">Nepal</option>
                    <option value="Netherlands">Netherlands</option>
                    <option value="New Zealand">New Zealand</option>
                    <option value="Nicaragua">Nicaragua</option>
                    <option value="Niger">Niger</option>
                    <option value="Nigeria">Nigeria</option>
                    <option value="North Macedonia">North Macedonia</option>
                    <option value="Norway">Norway</option>
                    <option value="Oman">Oman</option>
                    <option value="Pakistan">Pakistan</option>
                    <option value="Palau">Palau</option>
                    <option value="Panama">Panama</option>
                    <option value="Papua New Guinea">Papua New Guinea</option>
                    <option value="Paraguay">Paraguay</option>
                    <option value="Peru">Peru</option>
                    <option value="Philippines">Philippines</option>
                    <option value="Poland">Poland</option>
                    <option value="Portugal">Portugal</option>
                    <option value="Qatar">Qatar</option>
                    <option value="Romania">Romania</option>
                    <option value="Russia">Russia</option>
                    <option value="Rwanda">Rwanda</option>
                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                    <option value="Saint Lucia">Saint Lucia</option>
                    <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                    <option value="Samoa">Samoa</option>
                    <option value="San Marino">San Marino</option>
                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                    <option value="Saudi Arabia">Saudi Arabia</option>
                    <option value="Senegal">Senegal</option>
                    <option value="Serbia">Serbia</option>
                    <option value="Seychelles">Seychelles</option>
                    <option value="Sierra Leone">Sierra Leone</option>
                    <option value="Singapore">Singapore</option>
                    <option value="Slovakia">Slovakia</option>
                    <option value="Slovenia">Slovenia</option>
                    <option value="Solomon Islands">Solomon Islands</option>
                    <option value="Somalia">Somalia</option>
                    <option value="South Africa">South Africa</option>
                    <option value="South Sudan">South Sudan</option>
                    <option value="Spain">Spain</option>
                    <option value="Sri Lanka">Sri Lanka</option>
                    <option value="Sudan">Sudan</option>
                    <option value="Suriname">Suriname</option>
                    <option value="Sweden">Sweden</option>
                    <option value="Switzerland">Switzerland</option>
                    <option value="Syria">Syria</option>
                    <option value="Taiwan">Taiwan</option>
                    <option value="Tajikistan">Tajikistan</option>
                    <option value="Tanzania">Tanzania</option>
                    <option value="Thailand">Thailand</option>
                    <option value="Timor-Leste">Timor-Leste</option>
                    <option value="Togo">Togo</option>
                    <option value="Tonga">Tonga</option>
                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                    <option value="Tunisia">Tunisia</option>
                    <option value="Turkey">Turkey</option>
                    <option value="Turkmenistan">Turkmenistan</option>
                    <option value="Tuvalu">Tuvalu</option>
                    <option value="Uganda">Uganda</option>
                    <option value="Ukraine">Ukraine</option>
                    <option value="United Arab Emirates">United Arab Emirates</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="United States">United States</option>
                    <option value="Uruguay">Uruguay</option>
                    <option value="Uzbekistan">Uzbekistan</option>
                    <option value="Vanuatu">Vanuatu</option>
                    <option value="Vatican City">Vatican City</option>
                    <option value="Venezuela">Venezuela</option>
                    <option value="Vietnam">Vietnam</option>
                    <option value="Yemen">Yemen</option>
                    <option value="Zambia">Zambia</option>
                    <option value="Zimbabwe">Zimbabwe</option>
                </select>
            </div>
            <div class="form-group">
                <label for="pick">Pick (Optional)</label>
                <input type="file" id="pick" name="pick">
            </div>

            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="4" required></textarea>
            </div>

            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>

</body>

</html>
