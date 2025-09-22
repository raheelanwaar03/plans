<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KYC ID Scanner</title>

  <!-- OpenCV.js (for document detection) -->
  <script async src="https://docs.opencv.org/4.x/opencv.js" ></script>

  <!-- Optional: Tesseract.js if you want OCR later (not required) -->
  <script src="https://unpkg.com/tesseract.js@v4.0.2/dist/tesseract.min.js"></script>

  <style>
    body { font-family: Arial, sans-serif; margin: 16px; }
    .camera-wrapper { display:flex; gap:16px; flex-wrap:wrap; }
    .preview-card { border-radius:8px; box-shadow:0 6px 18px rgba(0,0,0,0.12); padding:8px; width:360px; }
    video { width:100%; border-radius:6px; background:#000; }
    canvas { width:100%; display:block; margin-top:8px; border-radius:6px; }
    .controls { margin-top:8px; display:flex; gap:8px; justify-content:space-between; align-items:center; }
    .btn { padding:8px 12px; border-radius:6px; border:none; cursor:pointer; }
    .btn-primary { background:#2563eb; color:#fff; }
    .btn-ghost { background:#f3f4f6; color:#111; }
    small { color:#555; }
  </style>
</head>
<body>

<h2>Scan Identity Document (Front & Back)</h2>
<p><small>Allow camera access. After document is steady and fills the frame, the scanner will auto-capture.</small></p>

<form id="kycForm" method="POST" action="#" enctype="multipart/form-data">
  @csrf

  <label>ID Number (max 11 chars)</label><br>
  <input name="id_number" id="id_number" maxlength="11" pattern=".{0,11}" placeholder="Enter up to 11 chars" style="padding:8px; width:360px;">
  <br><br>

  <div class="camera-wrapper">
    <!-- FRONT -->
    <div class="preview-card">
      <h4>Front Side</h4>
      <video id="videoFront" playsinline></video>
      <canvas id="canvasFront" width="1280" height="720" style="display:none;"></canvas>
      <img id="thumbFront" style="width:100%; margin-top:8px; display:none; border-radius:6px;" />
      <div class="controls">
        <button type="button" class="btn btn-ghost" id="openScannerFront">Open Scanner</button>
        <button type="button" class="btn btn-primary" id="captureFront">Capture</button>
        <input type="file" id="fileFront" accept="image/*" style="display:none;">
      </div>
      <small>Status: <span id="statusFront">idle</span></small>
    </div>

    <!-- BACK -->
    <div class="preview-card">
      <h4>Back Side</h4>
      <video id="videoBack" playsinline></video>
      <canvas id="canvasBack" width="1280" height="720" style="display:none;"></canvas>
      <img id="thumbBack" style="width:100%; margin-top:8px; display:none; border-radius:6px;" />
      <div class="controls">
        <button type="button" class="btn btn-ghost" id="openScannerBack">Open Scanner</button>
        <button type="button" class="btn btn-primary" id="captureBack">Capture</button>
        <input type="file" id="fileBack" accept="image/*" style="display:none;">
      </div>
      <small>Status: <span id="statusBack">idle</span></small>
    </div>
  </div>

  <!-- Hidden inputs that will be filled with blob files -->
  <input type="hidden" name="front_blob" id="front_blob">
  <input type="hidden" name="back_blob" id="back_blob">

  <br>
  <button type="submit" class="btn btn-primary">Submit KYC</button>
</form>

<script>
/*
  Approach:
  - Use getUserMedia to stream camera into <video>.
  - Use OpenCV.js to detect large rectangular contour (document).
  - When stable detection occurs for several frames, auto-capture (or allow manual capture).
  - Put captured image into a dataURL and also into a hidden input that the server will accept (base64).
*/

// Helper to get camera stream constraints (prefer back camera on mobile)
function getCameraConstraints() {
  return {
    audio: false,
    video: {
      facingMode: { ideal: "environment" },
      width: { ideal: 1280 },
      height: { ideal: 720 }
    }
  };
}

// Utility: convert dataURL to Blob (so you can send as file if needed)
function dataURLtoBlob(dataurl) {
  var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
      bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
  while(n--) { u8arr[n] = bstr.charCodeAt(n); }
  return new Blob([u8arr], {type:mime});
}

// Scanner object
function IDScanner(videoElem, canvasElem, thumbElem, statusElem) {
  this.video = videoElem;
  this.canvas = canvasElem;
  this.thumb = thumbElem;
  this.status = statusElem;

  this.stream = null;
  this.detectRunning = false;
  this.opencvReady = false;
  this.stableCount = 0; // counts consecutive frames with doc detection
  this.stableThreshold = 3; // require N consecutive frames
  this.captureCooldownMs = 1200;
  this.lastCapture = 0;
}

IDScanner.prototype.init = async function() {
  // wait for opencv to be ready
  if (typeof cv === 'undefined') {
    this.status.innerText = 'loading OpenCV...';
    await new Promise((res)=> {
      let tries=0;
      const iv=setInterval(()=> {
        if (typeof cv !== 'undefined' && cv && cv.Mat) {
          clearInterval(iv); res();
        }
        tries++;
        if (tries>200) { clearInterval(iv); res(); }
      }, 50);
    });
  }
  this.opencvReady = (typeof cv !== 'undefined' && cv.Mat);
  this.status.innerText = 'ready';
};

IDScanner.prototype.start = async function() {
  if (this.stream) return;
  try {
    this.stream = await navigator.mediaDevices.getUserMedia(getCameraConstraints());
    this.video.srcObject = this.stream;
    await this.video.play();
    this.status.innerText = 'camera on';
    this.detectRunning = true;
    this.runDetectionLoop();
  } catch (err) {
    console.error(err);
    this.status.innerText = 'camera error';
  }
};

IDScanner.prototype.stop = function() {
  this.detectRunning = false;
  if (this.stream) {
    this.stream.getTracks().forEach(t=>t.stop());
    this.stream = null;
    this.video.srcObject = null;
    this.status.innerText = 'stopped';
  }
};

IDScanner.prototype.manualCapture = function() {
  // draw current frame to canvas and return dataURL
  const ctx = this.canvas.getContext('2d');
  this.canvas.width = this.video.videoWidth || 1280;
  this.canvas.height = this.video.videoHeight || 720;
  ctx.drawImage(this.video, 0, 0, this.canvas.width, this.canvas.height);
  const dataUrl = this.canvas.toDataURL('image/jpeg', 0.9);
  this.showThumb(dataUrl);
  return dataUrl;
};

IDScanner.prototype.showThumb = function(dataUrl) {
  this.thumb.src = dataUrl;
  this.thumb.style.display = 'block';
};

IDScanner.prototype.autoCapture = function(dataUrl) {
  // put into hidden input (base64) and show thumb; debounce
  const now = Date.now();
  if (now - this.lastCapture < this.captureCooldownMs) return;
  this.lastCapture = now;
  this.showThumb(dataUrl);
  // set a named hidden field on form; caller will map this
};

IDScanner.prototype.runDetectionLoop = function() {
  // performs edge detection and tries to find a big approx polygon (document)
  if (!this.detectRunning) return;
  if (!this.opencvReady) {
    setTimeout(()=>this.runDetectionLoop(), 200);
    return;
  }

  const vw = this.video.videoWidth, vh = this.video.videoHeight;
  if (!vw || !vh) { setTimeout(()=>this.runDetectionLoop(), 100); return; }

  // use temporary canvas to draw video frame, then to OpenCV Mat
  let tmpCanvas = document.createElement('canvas');
  tmpCanvas.width = vw; tmpCanvas.height = vh;
  let tctx = tmpCanvas.getContext('2d');
  tctx.drawImage(this.video, 0, 0, vw, vh);

  let src = cv.imread(tmpCanvas);
  try {
    let dst = new cv.Mat();
    let gray = new cv.Mat();
    cv.cvtColor(src, gray, cv.COLOR_RGBA2GRAY, 0);
    cv.GaussianBlur(gray, gray, new cv.Size(5,5), 0);
    cv.Canny(gray, dst, 50, 150);

    // find contours
    let contours = new cv.MatVector();
    let hierarchy = new cv.Mat();
    cv.findContours(dst, contours, hierarchy, cv.RETR_LIST, cv.CHAIN_APPROX_SIMPLE);

    let foundLargeQuad = false;
    for (let i = 0; i < contours.size(); ++i) {
      let cnt = contours.get(i);
      let peri = cv.arcLength(cnt, true);
      let approx = new cv.Mat();
      cv.approxPolyDP(cnt, approx, 0.02 * peri, true);

      if (approx.rows === 4) {
        // check area ratio
        let rect = cv.boundingRect(approx);
        let area = rect.width * rect.height;
        if (area > (vw*vh*0.20)) { // >20% of frame
          foundLargeQuad = true;
          approx.delete();
          cnt.delete();
          break;
        }
      }
      approx.delete(); cnt.delete();
    }

    if (foundLargeQuad) {
      this.stableCount++;
      this.status.innerText = `detected (${this.stableCount})`;
      if (this.stableCount >= this.stableThreshold) {
        // capture frame
        this.canvas.width = vw; this.canvas.height = vh;
        let ctx = this.canvas.getContext('2d');
        ctx.drawImage(this.video, 0, 0, vw, vh);
        const dataUrl = this.canvas.toDataURL('image/jpeg', 0.9);
        this.autoCapture(dataUrl);
        this.stableCount = 0; // reset
      }
    } else {
      this.stableCount = 0;
      this.status.innerText = 'scanning...';
    }

    dst.delete(); gray.delete(); contours.delete(); hierarchy.delete();
  } catch (e) {
    console.error(e);
  } finally {
    src.delete();
    // schedule next frame
    requestAnimationFrame(()=>this.runDetectionLoop());
  }
};
</script>

<script>
/* Wiring: one scanner instance for front and one for back.
   When auto/manual capture happens, we set hidden inputs front_blob/back_blob (base64)
   and also set visible thumbnail.
*/

document.addEventListener('DOMContentLoaded', async ()=> {
  const videoFront = document.getElementById('videoFront');
  const canvasFront = document.getElementById('canvasFront');
  const thumbFront = document.getElementById('thumbFront');
  const statusFront = document.getElementById('statusFront');

  const videoBack = document.getElementById('videoBack');
  const canvasBack = document.getElementById('canvasBack');
  const thumbBack = document.getElementById('thumbBack');
  const statusBack = document.getElementById('statusBack');

  const scannerFront = new IDScanner(videoFront, canvasFront, thumbFront, statusFront);
  const scannerBack  = new IDScanner(videoBack, canvasBack, thumbBack, statusBack);

  await scannerFront.init();
  await scannerBack.init();

  // Buttons
  document.getElementById('openScannerFront').addEventListener('click', ()=> scannerFront.start());
  document.getElementById('openScannerBack').addEventListener('click', ()=> scannerBack.start());

  document.getElementById('captureFront').addEventListener('click', ()=> {
    const dataUrl = scannerFront.manualCapture();
    document.getElementById('front_blob').value = dataUrl; // base64
  });

  document.getElementById('captureBack').addEventListener('click', ()=> {
    const dataUrl = scannerBack.manualCapture();
    document.getElementById('back_blob').value = dataUrl; // base64
  });

  // When auto-capture occurs (scanner.autoCapture), we need to set the hidden field.
  // We patch IDScanner.autoCapture to also set the relevant field when invoked.
  const originalAutoCaptureFront = scannerFront.autoCapture.bind(scannerFront);
  scannerFront.autoCapture = function(dataUrl) {
    originalAutoCaptureFront(dataUrl);
    document.getElementById('front_blob').value = dataUrl;
  };

  const originalAutoCaptureBack = scannerBack.autoCapture.bind(scannerBack);
  scannerBack.autoCapture = function(dataUrl) {
    originalAutoCaptureBack(dataUrl);
    document.getElementById('back_blob').value = dataUrl;
  };

  // If user chooses to upload file instead (fallback)
  document.getElementById('fileFront').addEventListener('change', function(e) {
    const f = e.target.files[0];
    if (!f) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
      document.getElementById('front_blob').value = ev.target.result;
      thumbFront.src = ev.target.result; thumbFront.style.display = 'block';
    };
    reader.readAsDataURL(f);
  });
  document.getElementById('fileBack').addEventListener('change', function(e) {
    const f = e.target.files[0];
    if (!f) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
      document.getElementById('back_blob').value = ev.target.result;
      thumbBack.src = ev.target.result; thumbBack.style.display = 'block';
    };
    reader.readAsDataURL(f);
  });

  // Allow clicking the hidden file inputs from UI if user wants manual file upload
  document.getElementById('openScannerFront').addEventListener('contextmenu', (ev)=> {
    ev.preventDefault();
    document.getElementById('fileFront').click();
  });
  document.getElementById('openScannerBack').addEventListener('contextmenu', (ev)=> {
    ev.preventDefault();
    document.getElementById('fileBack').click();
  });

  // Form submission: before sending to server, convert base64 dataURLs into real File objects
  document.getElementById('kycForm').addEventListener('submit', async function(e) {
    // Ensure ID number length limit is respected (front-end)
    const idnum = document.getElementById('id_number').value || '';
    if (idnum.length > 11) {
      alert('ID number must be maximum 11 characters.');
      e.preventDefault();
      return;
    }

    // We'll create actual file inputs dynamically to allow Laravel file validation
    function appendFileFromDataUrl(form, dataUrl, name) {
      if (!dataUrl) return;
      const blob = dataURLtoBlob(dataUrl);
      const file = new File([blob], name, { type: blob.type });
      const dt = new DataTransfer();
      dt.items.add(file);
      const input = document.createElement('input');
      input.type = 'file';
      input.name = name;
      input.style.display = 'none';
      input.files = dt.files;
      document.getElementById('kycForm').appendChild(input);
    }

    // Add files if base64 present
    const frontData = document.getElementById('front_blob').value;
    const backData = document.getElementById('back_blob').value;
    if (frontData) appendFileFromDataUrl(this, frontData, 'id_front');
    if (backData)  appendFileFromDataUrl(this, backData,  'id_back');

    // remove the large hidden base64 fields to reduce payload (optional)
    // document.getElementById('front_blob').value = '';
    // document.getElementById('back_blob').value = '';
    // allow submit to continue (files will be included)
  });

});
</script>
</body>
</html>
