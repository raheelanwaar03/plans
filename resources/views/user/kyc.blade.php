<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>KYC Form with Live ID Scanner</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo.png') }}">
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
            box-sizing: border-box;
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
            padding: 32px;
        }

        .wrap {
            max-width: 980px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 28px;
        }

        .card {
            background: linear-gradient(180deg, rgba(77, 184, 231, 0.02), rgba(255, 255, 255, 0.01));
            border-radius: 16px;
            padding: 26px;
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        h1 {
            margin: 0 0 8px;
            font-size: 22px;
        }

        p.lead {
            color: var(--muted);
            margin-top: 0;
            margin-bottom: 18px;
        }

        label {
            font-size: 13px;
            color: var(--muted);
            display: block;
            margin-bottom: 6px;
        }

        input[type=text],
        input[type=file],
        input[type=number] {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.04);
            background: var(--glass);
            color: inherit;
            font-size: 15px;
        }

        .muted {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.55);
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
            border: 1px dashed rgba(255, 255, 255, 0.03);
        }

        .scanner-preview img {
            max-width: 100%;
            height: auto;
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
            cursor: pointer;
        }

        .btn.secondary {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.345);
            color: var(--muted);
        }

        .camera-modal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, rgba(2, 6, 23, 0.6), rgba(2, 6, 23, 0.9));
            z-index: 999;
        }

        .camera-modal.open {
            display: flex;
        }

        .camera-box {
            width: 920px;
            max-width: 96%;
            background: #041226;
            border-radius: 14px;
            padding: 14px;
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        .camera-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        video {
            width: 100%;
            border-radius: 10px;
            background: #000;
        }

        canvas {
            display: none;
        }

        @media(max-width:980px) {
            .wrap {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="wrap">

        <!-- Left: KYC Form -->
        <section class="card">
            <h1>KYC - Secure ID Scan</h1>
            <p class="lead">Capture front & back of your identity card using your device camera. Also upload selfie and payment screenshot.</p>

            <form id="form" action="{{ route('User.KYC.Data') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- User Details -->
                <div style="display:flex;gap:12px;flex-wrap:wrap">
                    <div style="flex:1;min-width:220px">
                        <label>Full Name</label>
                        <input name="name" type="text" placeholder="e.g. Ali Khan" required />
                    </div>
                    <div style="width:220px">
                        <label>Phone Number</label>
                        <input name="number" type="text" maxlength="11" pattern="\d{11}" inputmode="numeric" required />
                    </div>
                    <div style="width:220px">
                        <label>CNIC</label>
                        <input name="cnic" type="number" maxlength="13" pattern="\d{13}" inputmode="numeric" required />
                    </div>
                    <div style="width:220px">
                        <label>Transaction ID (Trx ID)</label>
                        <input name="trx_id" type="text" maxlength="11" pattern="\d{11}" inputmode="numeric" required />
                    </div>
                </div>

                <!-- Selfie & Payment Screenshot -->
                <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:13px;">
                    <div style="flex:1;min-width:220px">
                        <label>Selfie</label>
                        <input type="file" name="selfie" accept="image/*" required />
                    </div>
                    <div style="flex:1;min-width:220px">
                        <label>Payment Screenshot</label>
                        <input type="file" name="paymentScreenshot" accept="image/*" required />
                    </div>
                </div>

                <hr style="margin:18px 0;border:none;border-top:1px solid rgba(255,255,255,0.03)" />

                <!-- Identity Card Scanning -->
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">

                    <!-- Front -->
                    <div>
                        <label>Identity Card — Front</label>
                        <div class="scanner-preview" id="frontPreview">
                            <div style="text-align:center;padding:12px;color:var(--muted)">
                                <div>No front image</div>
                                <div class="muted">Use Scanner</div>
                            </div>
                        </div>
                        <div style="display:flex;gap:8px;margin-top:10px">
                            <button type="button" class="btn" onclick="openScanner('front')">Scan</button>
                            {{-- <button type="button" class="btn secondary" onclick="document.getElementById('frontUpload').click()">Upload</button> --}}
                            <input type="file" id="frontUpload" accept="image/*" style="display:none" onchange="handleUpload(event,'front')">
                            <input type="hidden" id="frontImageInput" name="idFront">
                        </div>
                    </div>

                    <!-- Back -->
                    <div>
                        <label>Identity Card — Back</label>
                        <div class="scanner-preview" id="backPreview">
                            <div style="text-align:center;padding:12px;color:var(--muted)">
                                <div>No back image</div>
                                <div class="muted">Use Scanner</div>
                            </div>
                        </div>
                        <div style="display:flex;gap:8px;margin-top:10px">
                            <button type="button" class="btn" onclick="openScanner('back')">Scan</button>
                            {{-- <button type="button" class="btn secondary" onclick="document.getElementById('backUpload').click()">Upload</button> --}}
                            <input type="file" id="backUpload" accept="image/*" style="display:none" onchange="handleUpload(event,'back')">
                            <input type="hidden" id="backImageInput" name="back_image">
                        </div>
                    </div>
                </div>

                <div style="margin-top:16px">
                    <button type="submit" class="btn">Submit</button>
                </div>
            </form>
        </section>

        <!-- Right: Camera Modal -->
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
                <div style="margin-top:8px;color:var(--muted);font-size:13px">
                    Hold the card steady and press Capture
                </div>
            </div>
        </div>

    </div>

    <!-- JS: Camera + Preview -->
    <script>
        let currentSide = null;
        let stream = null;
        const video = document.getElementById('video');
        const canvas = document.getElementById('captureCanvas');

        function openScanner(side) {
            currentSide = side;
            document.getElementById('cameraModal').classList.add('open');
            document.getElementById('cameraModal').setAttribute('aria-hidden', 'false');
            document.getElementById('cameraTitle').innerText =
                'Scanner — ' + (side === 'front' ? 'Front Side' : 'Back Side');
            startCamera();
        }

        async function startCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' }, audio: false });
                video.srcObject = stream;
            } catch (err) {
                alert("Camera permission denied: " + err.message);
                closeScanner();
            }
        }

        function closeScanner() {
            document.getElementById('cameraModal').classList.remove('open');
            document.getElementById('cameraModal').setAttribute('aria-hidden', 'true');
            if (stream) { stream.getTracks().forEach(t => t.stop()); stream = null; }
        }

        function captureFrame() {
            if (!video.srcObject) return;
            const w = video.videoWidth;
            const h = video.videoHeight;
            canvas.width = w;
            canvas.height = h;
            canvas.getContext("2d").drawImage(video, 0, 0, w, h);
            const dataUrl = canvas.toDataURL("image/jpeg", 0.9);
            closeScanner();
            setPreview(currentSide, dataUrl);
        }

        function handleUpload(e, side) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = () => setPreview(side, reader.result);
            reader.readAsDataURL(file);
        }

        function setPreview(side, dataUrl) {
            const previewBox = document.getElementById(side + "Preview");
            previewBox.innerHTML = `<img src="${dataUrl}" style="width:100%;border-radius:10px;">`;
            if (side === "front") document.getElementById("frontImageInput").value = dataUrl;
            if (side === "back") document.getElementById("backImageInput").value = dataUrl;
        }

        window.addEventListener("keydown", e => { if (e.key === "Escape") closeScanner(); });
    </script>

</body>
</html>
