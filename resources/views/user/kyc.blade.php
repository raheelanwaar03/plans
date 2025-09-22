<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>KYC Verification</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f4f6f9; display:flex; justify-content:center; align-items:center; height:100vh; }
    .kyc-box { background:#fff; padding:25px; border-radius:12px; box-shadow:0 6px 20px rgba(0,0,0,0.1); width:400px; text-align:center; }
    video, canvas { width:100%; border-radius:10px; margin:10px 0; }
    .btn { background:#4CAF50; color:#fff; border:none; padding:10px 16px; border-radius:6px; cursor:pointer; margin:5px; }
    .btn:hover { background:#45a049; }
    .preview img { width:100%; margin:10px 0; border-radius:10px; }
  </style>
</head>
<body>
  <div class="kyc-box">
    <h2>KYC Verification</h2>
    <form>
      <input type="text" name="name" placeholder="Full Name" required><br><br>

      <!-- Camera -->
      <video id="camera" autoplay playsinline></video>
      <canvas id="canvas" hidden></canvas>

      <!-- Buttons -->
      <button type="button" class="btn" onclick="scanDocument('front')">Scan Front ID</button>
      <button type="button" class="btn" onclick="scanDocument('back')">Scan Back ID</button>
      <button type="button" class="btn" onclick="takeSelfie()">Take Selfie</button>

      <!-- Previews -->
      <div class="preview">
        <p><b>Front ID:</b></p>
        <img id="frontPreview" src="">
        <p><b>Back ID:</b></p>
        <img id="backPreview" src="">
        <p><b>Selfie:</b></p>
        <img id="selfiePreview" src="">
      </div>

      <br><button type="submit" class="btn">Submit KYC</button>
    </form>
  </div>

  <!-- OpenCV for document detection -->
  <script async src="https://docs.opencv.org/4.x/opencv.js"></script>
  <script>
    const video = document.getElementById('camera');
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');

    // Start camera
    navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
      .then(stream => video.srcObject = stream)
      .catch(err => alert("Camera access denied: " + err));

    // Capture & crop ID using opencv.js
    function scanDocument(type) {
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
      let img = canvas.toDataURL("image/png");

      if (type === 'front') document.getElementById('frontPreview').src = img;
      if (type === 'back') document.getElementById('backPreview').src = img;
    }

    // Capture selfie
    function takeSelfie() {
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
      document.getElementById('selfiePreview').src = canvas.toDataURL("image/png");
    }
  </script>
</body>
</html>
