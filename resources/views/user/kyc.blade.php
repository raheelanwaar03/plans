<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KYC — Scan Front / Back</title>

  <!-- OpenCV.js (document detection) -->
  <script async src="https://docs.opencv.org/4.x/opencv.js"></script>

  <style>
    :root{--primary:#2563eb;--accent:#9333ea;}
    body{font-family:Inter,Segoe UI,Arial;margin:0;background:linear-gradient(180deg,#0f172a,#071130);color:#fff;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;}
    .card{background:linear-gradient(180deg,#ffffff,#f8fafc);color:#0b1220;border-radius:16px;padding:22px;max-width:720px;width:100%;box-shadow:0 20px 40px rgba(2,6,23,0.6);}
    h1{color:var(--primary);margin:0 0 8px;font-size:20px;}
    p.lead{color:#334155;margin:0 0 18px;}
    .row{display:flex;gap:14px;flex-wrap:wrap;}
    .col{flex:1;min-width:200px;background:#fff;border-radius:12px;padding:12px;border:1px solid #e6e9ee;}
    .col h3{margin:0 0 8px;color:#0b1220;font-size:14px;}
    .thumb{width:100%;height:160px;border-radius:8px;background:#0f172a;display:flex;align-items:center;justify-content:center;color:#94a3b8;overflow:hidden;}
    .thumb img{width:100%;height:100%;object-fit:cover;display:block;}
    .btn{display:inline-block;margin-top:10px;padding:10px 12px;border-radius:10px;border:none;cursor:pointer;font-weight:700;}
    .btn-primary{background:var(--primary);color:#fff;}
    .btn-ghost{background:transparent;border:2px solid var(--primary);color:var(--primary);}
    .small{font-size:13px;color:#64748b;margin-top:8px;}
    form{margin-top:14px;}

    /* Overlay modal for camera */
    .overlay{position:fixed;inset:0;background:rgba(2,6,23,0.85);display:none;align-items:center;justify-content:center;z-index:9999;padding:20px;}
    .cam-box{width:100%;max-width:920px;background:#071130;border-radius:14px;padding:14px;box-shadow:0 12px 40px rgba(2,6,23,0.7);border:1px solid rgba(255,255,255,0.04);}
    video{width:100%;border-radius:10px;background:#000;}
    .controls{display:flex;gap:10px;align-items:center;margin-top:8px;}
    .status{color:#e2e8f0;font-weight:700;}
    .toggle{padding:8px 10px;border-radius:8px;background:#0b1220;color:#fff;border:none;cursor:pointer;}
    .cancel{margin-left:auto;background:transparent;border:2px solid #ef4444;color:#ef4444;padding:8px 10px;border-radius:8px;cursor:pointer;}

    @media (max-width:600px){
      .row{flex-direction:column;}
      .thumb{height:140px;}
    }
  </style>
</head>
<body>
  <div class="card">
    <h1>KYC — Scan ID (Front & Back)</h1>
    <p class="lead">Click "Scan Now" for Front or Back. The camera will open, auto-detect the card and auto-capture. Toggle torch if available.</p>

    <form id="kycForm" method="POST" action="#">
      @csrf

      <label style="font-weight:700;color:#0b1220;">Full Name</label>
      <input type="text" name="full_name" required style="width:100%;padding:10px;border-radius:10px;border:1px solid #e6e9ee;margin-top:8px;font-size:15px;">

      <div class="row" style="margin-top:14px;">
        <div class="col">
          <h3>Front of ID</h3>
          <div class="thumb" id="thumbFrontPlaceholder"><span>Not scanned yet</span></div>
          <button type="button" class="btn btn-primary" id="btnScanFront">Scan Now</button>
          <div class="small">Auto-capture when ID is detected and steady.</div>
          <input type="hidden" name="id_front" id="id_front">
        </div>

        <div class="col">
          <h3>Back of ID</h3>
          <div class="thumb" id="thumbBackPlaceholder"><span>Not scanned yet</span></div>
          <button type="button" class="btn btn-primary" id="btnScanBack">Scan Now</button>
          <div class="small">Use torch if needed (Chrome Android only).</div>
          <input type="hidden" name="id_back" id="id_back">
        </div>

        <div class="col">
          <h3>Selfie (optional)</h3>
          <div class="thumb" id="thumbSelfiePlaceholder"><span>Not scanned yet</span></div>
          <button type="button" class="btn btn-ghost" id="btnScanSelfie">Scan Selfie</button>
          <div class="small">Front camera will be used. Auto-capture when face steady.</div>
          <input type="hidden" name="selfie" id="selfie">
        </div>
      </div>

      <button type="submit" class="btn btn-primary" style="margin-top:18px;width:100%;">Submit KYC</button>
    </form>
  </div>

  <!-- Overlay camera modal -->
  <div class="overlay" id="overlay">
    <div class="cam-box">
      <video id="camVideo" playsinline autoplay></video>
      <div class="controls">
        <div class="status" id="camStatus">Initializing...</div>
        <button id="toggleTorch" class="toggle" style="display:none;">Torch On</button>
        <button id="cancelCam" class="cancel">Cancel</button>
      </div>
    </div>
  </div>

<script>
/*
  Workflow:
  - User clicks Scan Now (Front/Back/Selfie).
  - Open overlay, start camera with constraints (environment or user).
  - Use OpenCV.js rectangle detection (for IDs) or a face-ish heuristic for selfie.
  - Wait for stable detection for N consecutive frames => capture.
  - If device supports torch, show toggle.
  - On capture: show thumbnail, set hidden input to base64, stop stream, close overlay.
*/

let overlay = document.getElementById('overlay');
let camVideo = document.getElementById('camVideo');
let camStatus = document.getElementById('camStatus');
let toggleTorchBtn = document.getElementById('toggleTorch');
let cancelCamBtn = document.getElementById('cancelCam');

let currentResolve = null;
let currentTrack = null;
let torchOn = false;
let opencvReady = false;

// wait until OpenCV runtime is ready
function waitOpencv() {
  return new Promise((resolve) => {
    if (typeof cv !== 'undefined' && cv && cv.Mat) return resolve();
    let iv = setInterval(()=>{
      if (typeof cv !== 'undefined' && cv && cv.Mat) { clearInterval(iv); resolve(); }
    }, 50);
  });
}

// start camera and show overlay; returns stream
async function openCamera(facingMode = 'environment') {
  camStatus.innerText = 'Starting camera...';
  overlay.style.display = 'flex';
  const constraints = { video: { facingMode: facingMode, width:{ideal:1280}, height:{ideal:720} }, audio:false };
  const stream = await navigator.mediaDevices.getUserMedia(constraints);
  camVideo.srcObject = stream;
  await camVideo.play();
  // keep first video track for torch toggling
  currentTrack = stream.getVideoTracks()[0];
  // show torch toggle if supported
  const caps = currentTrack.getCapabilities ? currentTrack.getCapabilities() : {};
  if (caps && caps.torch) {
    toggleTorchBtn.style.display = 'inline-block';
    toggleTorchBtn.innerText = 'Torch Off';
    torchOn = false;
  } else {
    toggleTorchBtn.style.display = 'none';
  }
  return stream;
}

// toggle torch (if supported)
async function toggleTorch() {
  if (!currentTrack) return;
  try {
    torchOn = !torchOn;
    await currentTrack.applyConstraints({ advanced: [{ torch: torchOn }] });
    toggleTorchBtn.innerText = torchOn ? 'Torch On' : 'Torch Off';
  } catch (e) {
    console.warn('Torch toggle failed', e);
  }
}

// stop camera tracks and hide overlay
function stopCamera() {
  try {
    if (camVideo && camVideo.srcObject) {
      camVideo.srcObject.getTracks().forEach(t=>t.stop());
      camVideo.srcObject = null;
    }
    currentTrack = null;
    torchOn = false;
  } catch(e){}
  overlay.style.display = 'none';
  camStatus.innerText = 'Initializing...';
}

// rectangle detection & auto-capture for ID
async function autoScanDocument(targetHiddenInputId, targetThumbPlaceholderId) {
  await waitOpencv();

  // open camera
  const stream = await openCamera('environment');
  camStatus.innerText = 'Point the ID in the frame';
  // run detection loop
  let stableCount = 0;
  let stableThreshold = 3; // consecutive frames
  let captured = false;

  // temp offscreen canvas
  const tmp = document.createElement('canvas');

  function detectFrame() {
    if (captured) return;
    if (camVideo.readyState < 2) { requestAnimationFrame(detectFrame); return; }
    const vw = camVideo.videoWidth, vh = camVideo.videoHeight;
    if (!vw || !vh) { requestAnimationFrame(detectFrame); return; }
    tmp.width = vw; tmp.height = vh;
    const ctx = tmp.getContext('2d');
    ctx.drawImage(camVideo, 0, 0, vw, vh);

    try {
      let src = cv.imread(tmp);
      let gray = new cv.Mat();
      cv.cvtColor(src, gray, cv.COLOR_RGBA2GRAY, 0);
      let blurred = new cv.Mat();
      cv.GaussianBlur(gray, blurred, new cv.Size(5,5), 0);
      let edges = new cv.Mat();
      cv.Canny(blurred, edges, 50, 150);
      let contours = new cv.MatVector();
      let hierarchy = new cv.Mat();
      cv.findContours(edges, contours, hierarchy, cv.RETR_LIST, cv.CHAIN_APPROX_SIMPLE);

      let foundQuad = false;
      for (let i = 0; i < contours.size(); i++) {
        let cnt = contours.get(i);
        let peri = cv.arcLength(cnt, true);
        let approx = new cv.Mat();
        cv.approxPolyDP(cnt, approx, 0.02 * peri, true);
        if (approx.rows === 4) {
          let rect = cv.boundingRect(approx);
          let area = rect.width * rect.height;
          // require card to occupy at least ~20% of the frame
          if (area > vw * vh * 0.18) {
            foundQuad = true;
            approx.delete(); cnt.delete();
            break;
          }
        }
        approx.delete(); cnt.delete();
      }

      if (foundQuad) {
        stableCount++;
        camStatus.innerText = `Detected (${stableCount}) — keep steady`;
        if (stableCount >= stableThreshold) {
          // capture
          captured = true;
          // draw final frame to canvas and get base64
          const c = document.createElement('canvas');
          c.width = vw; c.height = vh;
          c.getContext('2d').drawImage(camVideo, 0, 0, vw, vh);
          const dataUrl = c.toDataURL('image/jpeg', 0.92);
          // set hidden input & thumbnail
          document.getElementById(targetHiddenInputId).value = dataUrl;
          const ph = document.getElementById(targetThumbPlaceholderId);
          ph.innerHTML = ''; // clear
          const im = document.createElement('img'); im.src = dataUrl;
          ph.appendChild(im);
          camStatus.innerText = 'Captured ✅';
          // cleanup mats
          src.delete(); gray.delete(); blurred.delete(); edges.delete(); contours.delete(); hierarchy.delete();
          // stop camera after a short delay to allow user see capture
          setTimeout(()=>stopCamera(), 600);
          return;
        }
      } else {
        stableCount = 0;
        camStatus.innerText = 'No ID detected — align the card inside the frame';
      }
      src.delete(); gray.delete(); blurred.delete(); edges.delete(); contours.delete(); hierarchy.delete();
    } catch (err) {
      console.error('OpenCV error', err);
      camStatus.innerText = 'Detection error';
    }

    requestAnimationFrame(detectFrame);
  }

  requestAnimationFrame(detectFrame);
}

// simple auto-capture for selfie using face detection approximate (face area or just stable)
async function autoScanSelfie(targetHiddenInputId, targetThumbPlaceholderId) {
  // For simplicity, we'll just ensure a face-like object fills some portion or user holds steady.
  // A production solution should use a face detector (e.g., BlazeFace). Here we use stability heuristic.
  const stream = await openCamera('user');
  camStatus.innerText = 'Align your face in the frame';

  let stable = 0, threshold = 20, captured = false;
  const tmp = document.createElement('canvas');

  function selfieLoop() {
    if (captured) return;
    if (camVideo.readyState < 2) { requestAnimationFrame(selfieLoop); return; }
    const vw = camVideo.videoWidth, vh = camVideo.videoHeight;
    if (!vw || !vh) { requestAnimationFrame(selfieLoop); return; }
    tmp.width = vw; tmp.height = vh;
    const ctx = tmp.getContext('2d');
    ctx.drawImage(camVideo, 0, 0, vw, vh);

    // quick brightness/skin-tone heuristic: check center area variance — crude but works for many cases
    const img = ctx.getImageData(vw*0.3, vh*0.2, Math.round(vw*0.4), Math.round(vh*0.6));
    let sum=0;
    for (let i=0;i<img.data.length;i+=4){
      // luminance
      sum += 0.299*img.data[i] + 0.587*img.data[i+1] + 0.114*img.data[i+2];
    }
    const avg = sum / (img.data.length/4);
    if (avg > 30 && avg < 220) {
      stable++;
      camStatus.innerText = `Face steady (${Math.floor((stable/threshold)*100)}%)`;
      if (stable >= threshold) {
        captured = true;
        const c = document.createElement('canvas');
        c.width = vw; c.height = vh;
        c.getContext('2d').drawImage(camVideo, 0, 0, vw, vh);
        const dataUrl = c.toDataURL('image/jpeg', 0.9);
        document.getElementById(targetHiddenInputId).value = dataUrl;
        const ph = document.getElementById(targetThumbPlaceholderId);
        ph.innerHTML = '';
        const im = document.createElement('img'); im.src = dataUrl;
        ph.appendChild(im);
        camStatus.innerText = 'Selfie captured ✅';
        setTimeout(()=>stopCamera(), 600);
        return;
      }
    } else {
      stable = 0;
      camStatus.innerText = 'Adjust face into center';
    }
    requestAnimationFrame(selfieLoop);
  }

  requestAnimationFrame(selfieLoop);
}

// Wire buttons
document.getElementById('btnScanFront').addEventListener('click', ()=> {
  autoScanDocument('id_front', 'thumbFrontPlaceholder').catch(e=>{ console.error(e); stopCamera(); });
});
document.getElementById('btnScanBack').addEventListener('click', ()=> {
  autoScanDocument('id_back', 'thumbBackPlaceholder').catch(e=>{ console.error(e); stopCamera(); });
});
document.getElementById('btnScanSelfie').addEventListener('click', ()=> {
  autoScanSelfie('selfie', 'thumbSelfiePlaceholder').catch(e=>{ console.error(e); stopCamera(); });
});

// torch toggle
toggleTorchBtn.addEventListener('click', async ()=> {
  await toggleTorch();
});

// cancel
cancelCamBtn.addEventListener('click', ()=> {
  stopCamera();
});

// Ensure OpenCV ready message
waitOpencv().then(()=>{ opencvReady = true; console.log('OpenCV ready'); camStatus.innerText = 'Ready — Click Scan Now'; }).catch(()=>{ camStatus.innerText = 'OpenCV load failed'; });
</script>
</body>
</html>
