<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KYC Form - Live ID Capture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            padding: 20px;
        }

        .card {
            max-width: 700px;
            margin: auto;
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
        }

        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
        }

        input[type=text],
        input[type=file] {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .scanner-preview {
            width: 100%;
            height: 200px;
            background: #ddd;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            overflow: hidden;
        }

        .scanner-preview img {
            width: 100%;
            height: auto;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            background: #007bff;
            color: white;
            margin-right: 5px;
        }

        .btn.secondary {
            background: #6c757d;
        }

        #cameraModal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        #cameraModal.open {
            display: flex;
        }

        video {
            border-radius: 8px;
        }

        canvas {
            display: none;
        }
    </style>
</head>

<body>
    <x-alert />
    <div class="card">
        <h2>KYC Form</h2>
        <form id="kycForm" action="{{ route('User.KYC.Data') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label>Full Name</label>
            <input type="text" name="name" required>

            <label>Phone Number</label>
            <input type="text" name="number" maxlength="11" required>

            <label>CNIC</label>
            <input type="text" name="cnic" maxlength="13" required>

            <label>Transaction ID (Trx ID)</label>
            <input type="text" name="trx_id" required>

            <label>Selfie</label>
            <input type="file" name="selfie" accept="image/*" required>

            <label>Payment Screenshot</label>
            <input type="file" name="paymentScreenshot" accept="image/*" required>

            <!-- ID Front -->
            <label>Identity Card — Front</label>
            <div class="scanner-preview" id="frontPreview">No image</div>
            <button type="button" class="btn" onclick="openCamera('front')">Scan Front</button>
            <input type="hidden" name="idFront" id="frontHidden">

            <!-- ID Back -->
            <label>Identity Card — Back</label>
            <div class="scanner-preview" id="backPreview">No image</div>
            <button type="button" class="btn" onclick="openCamera('back')">Scan Back</button>
            <input type="hidden" name="back_image" id="backHidden">

            <br><br>
            <button type="submit" class="btn">Submit KYC</button>
        </form>
    </div>

    <!-- Camera Modal -->
    <div id="cameraModal">
        <div>
            <video id="video" autoplay playsinline></video>
            <br>
            <button class="btn" onclick="captureImage()">Capture</button>
            <button class="btn secondary" onclick="closeCamera()">Close</button>
        </div>
    </div>

    <canvas id="canvas"></canvas>

    <script>
        let currentSide = '';
        let stream = null;
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');

        function openCamera(side) {
            currentSide = side;
            document.getElementById('cameraModal').classList.add('open');

            navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: "environment"
                    }
                })
                .then(s => {
                    stream = s;
                    video.srcObject = stream;
                })
                .catch(err => {
                    alert("Camera access denied: " + err.message);
                    closeCamera();
                });
        }

        function closeCamera() {
            document.getElementById('cameraModal').classList.remove('open');
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
        }

        function captureImage() {
            if (!video.srcObject) return;

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);

            const dataUrl = canvas.toDataURL('image/jpeg', 0.9);

            if (currentSide === 'front') {
                document.getElementById('frontPreview').innerHTML = `<img src="${dataUrl}">`;
                document.getElementById('frontHidden').value = dataUrl;
            } else if (currentSide === 'back') {
                document.getElementById('backPreview').innerHTML = `<img src="${dataUrl}">`;
                document.getElementById('backHidden').value = dataUrl;
            }

            closeCamera();
        }

        // Optional: close camera modal on ESC
        window.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeCamera();
        });
    </script>
</body>

</html>
