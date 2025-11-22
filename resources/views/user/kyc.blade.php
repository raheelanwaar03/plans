<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Eye-catching KYC Form with ID Scanner</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@4.0.2/dist/tesseract.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" />
    <style>
        :root {
            --bg: #6b97ff;
            --card: #3a7cff;
            --accent: #06b6d4;
            --glass: rgba(77, 46, 46, 0.04);
            --muted: rgba(17, 17, 17, 0.7);
        }

        * {
            box-sizing: border-box
        }

        body {
            font-family: Inter, system-ui, Segoe UI, Roboto, 'Helvetica Neue', Arial;
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            color: #0364db;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px
        }

        .wrap {
            max-width: 980px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 28px
        }

        .card {
            background: linear-gradient(180deg, rgba(77, 184, 231, 0.02), rgba(255, 255, 255, 0.01));
            border-radius: 16px;
            padding: 26px;
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.04)
        }

        h1 {
            margin: 0 0 8px;
            font-size: 22px
        }

        p.lead {
            color: var(--muted);
            margin-top: 0;
            margin-bottom: 18px
        }

        form .row {
            display: flex;
            gap: 12px
        }

        label {
            font-size: 13px;
            color: var(--muted);
            display: block;
            margin-bottom: 6px
        }

        input[type=text],
        input[type=file],
        input[type=date],
        input[type=number],
        input[type=tel] {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.04);
            background: var(--glass);
            color: inherit;
            font-size: 15px
        }

        .muted {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.55)
        }

        .scanner-preview {
            width: 100%;
            height: 220px;
            background: #29446d;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            border: 1px dashed rgba(255, 255, 255, 0.03)
        }

        .scanner-preview img {
            max-width: 100%;
            height: auto
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 10px;
            border: 0;
            background: linear-gradient(90deg, var(--accent), #7c3aed);
            color: #021026;
            font-weight: 600;
            cursor: pointer
        }

        .btn.secondary {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.345);
            color: var(--muted)
        }

        .camera-modal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, rgba(2, 6, 23, 0.6), rgba(2, 6, 23, 0.9));
            z-index: 999
        }

        .camera-modal.open {
            display: flex
        }

        .camera-box {
            width: 920px;
            max-width: 96%;
            background: #041226;
            border-radius: 14px;
            padding: 14px;
            border: 1px solid rgba(255, 255, 255, 0.04)
        }

        .camera-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px
        }

        video {
            width: 100%;
            border-radius: 10px;
            background: #000
        }

        canvas {
            display: none
        }

        .note {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 12px
        }

        .right-panel {
            display: flex;
            flex-direction: column;
            gap: 16px
        }

        .card.small {
            padding: 16px
        }

        .kpi {
            display: flex;
            gap: 12px
        }

        .kpi .item {
            flex: 1;
            padding: 12px;
            border-radius: 10px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.01), rgba(255, 255, 255, 0.01));
            border: 1px solid rgba(255, 255, 255, 0.03)
        }

        .kpi h3 {
            margin: 0;
            font-size: 20px
        }

        footer {
            margin-top: 14px;
            font-size: 13px;
            color: var(--muted)
        }

        @media(max-width:980px) {
            .wrap {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <x-alert />

    <div class="wrap">
        <div class="card small">
            <h3 style="margin:0 0 6px">Wallet Details</h3>
            <div style="display:flex;gap:12px">
                <div class="">
                    <h4>Wallet: {{ $wallet->kyc_wallet }}</h4>
                    <h4>Account Title: {{ $wallet->kyc_name }}</h4>
                    <div>Account Number:
                        <h3>
                            <span id="copyText">{{ $wallet->kyc_number }}</span>
                            <span class="copy-icon" onclick="copyById('copyText')">📋</span>
                        </h3>
                    </div>
                </div>
            </div>
            <hr>

            <div style="display:flex;gap:12px">
                <div class="">
                    <h4>Wallet: {{ $wallet->binance_wallet }}</h4>
                    <h4>
                        Address:
                        <span id="binance_address">{{ $wallet->binance_address }}</span>
                        <span class="copy-icon" onclick="copyBinance()"
                            style="cursor:pointer; margin-left:6px;">📋</span>
                    </h4>
                </div>
            </div>
        </div>

        <div class="card small" style="margin-top: 30px">
            <h3 style="margin:0 0 6px">Scanned Preview</h3>
            <div style="display:flex;gap:12px">
                <div style="flex:1">
                    <label class="muted">Front (preview)</label>
                    <div class="scanner-preview" id="frontThumb"></div>
                </div>
                <div style="flex:1">
                    <label class="muted">Back (preview)</label>
                    <div class="scanner-preview" id="backThumb"></div>
                </div>
            </div>
        </div>

        <section class="card">
            <h1><a href="{{ route('User.Dashboard') }}" class="btn secondary" style="text-decoration:none;">Back</a>
                Secure
                ID Scan</h1>
            <p class="lead">Capture front & back of your identity card using your device camera. Pay 580pkr to given
                account and upload screenshot and add TrxID in form while doing kyc.
            </p>
            <form id="form" action="{{ route('User.KYC.Data') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display:flex;gap:12px;flex-wrap:wrap">
                    <div style="flex:1;min-width:220px">
                        <label for="fullName">Full name</label>
                        <input id="fullName" name="name" type="text" placeholder="e.g. Ali Khan"
                            autocomplete="name" required />
                    </div>

                    <div style="width:220px">
                        <label for="cnic">Phone Num:</label>
                        <input id="cnic" name="number" type="text" placeholder="12345123451"
                            class="form-control" maxlength="11" pattern="\d{11}" title="Enter 11 digits"
                            inputmode="numeric" required />
                        <div class="muted">Max 11 digits — enforced in input.</div>
                    </div>

                    <div style="width:220px">
                        <label for="cnic">Cnic:</label>
                        <input id="cnic" name="cnic" type="number" placeholder="3370512345670" maxlength="13"
                            pattern="\d{13}" title="Enter 13 digits" inputmode="numeric" required />
                        <div class="muted">Max 13 digits — enforced in input.</div>
                    </div>

                    <div style="width:220px">
                        <label for="cnic">Transaction ID (Trx ID)</label>
                        <input id="cnic" name="trx_id" type="text" placeholder="12345123451" maxlength="11"
                            pattern="\d{11}" title="Enter 11 digits" inputmode="numeric" required />
                        <div class="muted">Max 11 digits — enforced in input.</div>
                    </div>
                </div>

                <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:13px;">
                    <div style="flex:1;min-width:220px">
                        <label for="Selfie">Selfie</label>
                        <input id="selfie" name="selfie" type="file" required />
                    </div>

                    <div style="width:220px">
                        <label for="cnic">Payment Screen Shot:</label>
                        <input id="cnic" name="paymentScreenshot" type="file" placeholder="12345123451"
                            maxlength="11" pattern="\d{11}" title="Enter 11 digits" inputmode="numeric" required />
                    </div>
                </div>

                <hr style="margin:18px 0;border:none;border-top:1px solid rgba(255,255,255,0.03)" />

                {{-- camera --}}

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <!-- Front -->
                    <div>
                        <label>Identity Card — Front</label>
                        <div class="scanner-preview" id="frontPreview">
                            <div style="text-align:center;padding:12px;color:var(--muted)">
                                <div style="font-weight:600">No front image</div>
                                <div class="muted"><span style="font-weight:700;color:#9be7ef">Upload Front
                                        Side</span>
                                </div>
                            </div>
                        </div>
                        <div style="display:flex;gap:8px;margin-top:10px">
                            {{-- <button type="button" class="btn" onclick="openScanner('front')">
                                Scan</button> --}}
                            <input id="frontUpload" type="file" onchange="handleUpload(event,'front')"
                                name="idFront" />
                            <div style="flex:1"></div>
                        </div>
                    </div>
                    <div>
                        <label>Identity Card — Back</label>
                        <div class="scanner-preview" id="backPreview">
                            <div style="text-align:center;padding:12px;color:var(--muted)">
                                <div style="font-weight:600">No Back image</div>
                                <div class="muted"><span style="font-weight:700;color:#9be7ef">Upload Back
                                        Side</span>
                                </div>
                            </div>
                        </div>
                        <div style="display:flex;gap:8px;margin-top:10px">
                            {{-- <button type="button" class="btn" onclick="openScanner('back')">Scan</button> --}}
                            <input id="backUpload" type="file" onchange="handleUpload(event,'back')"
                                name="idBack" />
                            <div style="flex:1"></div>
                        </div>
                    </div>
                </div>

                <div style="margin-top:16px;display:flex;gap:10px;align-items:center">
                    <button type="submit" class="btn">Submit</button>
                </div>
            </form>

            <footer>
                <small>Works best on mobile devices with a rear camera. Allow camera permission when prompted.</small>
            </footer>
        </section>

        <!-- RIGHT: Info / Previews -->
    </div>

    <!-- Camera modal -->
    <div id="cameraModal" class="camera-modal" role="dialog" aria-hidden="true">
        <div class="camera-box">
            <div class="camera-head">
                <strong id="cameraTitle">Scanner</strong>
                <div style="display:flex;gap:8px;align-items:center">
                    <button class="btn secondary" onclick="closeScanner()">Close</button>
                    <button class="btn" onclick="captureFrame()">Capture</button>
                </div>
            </div>
            <video id="video" autoplay playsinline></video>
            <canvas id="captureCanvas"></canvas>
            <div style="margin-top:8px;color:var(--muted);font-size:13px">Hold the card steady and press Capture. The
                app will try to extract text automatically.</div>
        </div>
    </div>

    <script>
        // State
        let currentSide = null; // 'front' or 'back'
        let stream = null;
        const video = document.getElementById('video');
        const canvas = document.getElementById('captureCanvas');

        function openScanner(side) {
            currentSide = side;
            document.getElementById('cameraModal').classList.add('open');
            document.getElementById('cameraModal').setAttribute('aria-hidden', 'false');
            document.getElementById('cameraTitle').innerText = 'Scanner — ' + (side === 'front' ? 'Front side' :
                'Back side');
            startCamera();
        }

        async function startCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment'
                    },
                    audio: false
                });
                video.srcObject = stream;
            } catch (err) {
                alert('Could not access camera. Please allow camera permission or use Upload Image.\nError: ' + err
                    .message);
                closeScanner();
            }
        }

        function closeScanner() {
            document.getElementById('cameraModal').classList.remove('open');
            document.getElementById('cameraModal').setAttribute('aria-hidden', 'true');
            if (stream) {
                stream.getTracks().forEach(t => t.stop());
                stream = null;
            }
        }

        function captureFrame() {
            if (!video.srcObject) return;
            const w = video.videoWidth;
            const h = video.videoHeight;
            canvas.width = w;
            canvas.height = h;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, w, h);
            const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
            closeScanner();
            setPreview(currentSide, dataUrl);
            runOCR(dataUrl, currentSide);
        }

        function handleUpload(e, side) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = () => {
                setPreview(side, reader.result);
                runOCR(reader.result, side);
            }
            reader.readAsDataURL(file);
        }

        function setPreview(side, dataUrl) {
            const el = document.getElementById(side + 'Preview');
            const thumb = document.getElementById(side + 'Thumb');
            el.innerHTML = '<img src="' + dataUrl + '" alt="' + side + ' image' + '">';
            thumb.innerHTML = '<img src="' + dataUrl + '" alt="' + side + ' thumb' + '">';
        }

        function resetForm() {
            document.getElementById('kycForm').reset();
            document.getElementById('frontPreview').innerHTML =
                '<div style="text-align:center;padding:12px;color:var(--muted)"><div style="font-weight:600">No front image</div><div class="muted">Click Open Scanner to use camera or choose upload.</div></div>';
            document.getElementById('backPreview').innerHTML =
                '<div style="text-align:center;padding:12px;color:var(--muted)"><div style="font-weight:600">No back image</div><div class="muted">Click Open Scanner to use camera or choose upload.</div></div>';
            document.getElementById('frontThumb').innerHTML = '';
            document.getElementById('backThumb').innerHTML = '';
            document.getElementById('detectedName').innerText = '—';
            document.getElementById('detectedCnic').innerText = '—';
        }

        // Accessibility: close modal on Esc
        window.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeScanner();
        });
    </script>

    <script>
        function copyById(id) {
            const text = document.getElementById(id).innerText;

            // Create a temporary textarea
            const ta = document.createElement("textarea");
            ta.value = text;
            document.body.appendChild(ta);

            // Copy the text
            ta.select();
            document.execCommand("copy");

            // Remove temporary element
            document.body.removeChild(ta);

            alert("Copied: " + text);
        }
    </script>

    <script>
        function copyBinance() {
            const el = document.getElementById("binance_address");
            if (!el) {
                alert("Address element not found.");
                return;
            }
            const text = el.innerText.trim();

            // Preferred modern API
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(() => {
                    alert("Copied: " + text);
                }).catch(err => {
                    // Fallback if navigator.clipboard fails
                    fallbackCopyTextToClipboard(text);
                });
            } else {
                // Fallback for older browsers
                fallbackCopyTextToClipboard(text);
            }
        }

        function fallbackCopyTextToClipboard(text) {
            try {
                // create a temporary textarea to select & copy
                const textarea = document.createElement("textarea");
                textarea.value = text;
                // avoid showing on screen
                textarea.style.position = "fixed";
                textarea.style.left = "-9999px";
                document.body.appendChild(textarea);
                textarea.select();
                textarea.setSelectionRange(0, textarea.value.length);

                const successful = document.execCommand('copy');
                document.body.removeChild(textarea);

                if (successful) {
                    alert("Copied: " + text);
                } else {
                    alert("Unable to copy automatically. Please copy manually:\n\n" + text);
                }
            } catch (err) {
                alert("Copy failed. Please copy manually:\n\n" + text);
            }
        }
    </script>

</body>

</html>
