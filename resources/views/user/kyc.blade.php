<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>KYC — Capture ID</title>
  <style>
    :root{--bg:#0f1724;--card:#0b1220;--muted:#94a3b8;--accent:#06b6d4;--white:#e6eef6}
    *{box-sizing:border-box}
    body{margin:0;font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,Helvetica,Arial; background:linear-gradient(180deg,#071028 0%, #071824 100%);color:var(--white);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
    .container{width:100%;max-width:980px;background:linear-gradient(180deg,rgba(255,255,255,0.02),rgba(255,255,255,0.01));border-radius:14px;padding:20px;box-shadow:0 6px 30px rgba(2,6,23,0.7);display:grid;grid-template-columns:440px 1fr;gap:18px}
    .panel{background:rgba(255,255,255,0.02);border-radius:10px;padding:12px}
    header{display:flex;align-items:center;gap:12px}
    h1{margin:0;font-size:18px}
    p.lead{color:var(--muted);margin:6px 0 12px;font-size:13px}
    .video-wrap{background:#050816;border-radius:10px;padding:8px;display:flex;flex-direction:column;align-items:center;gap:8px}
    video{width:100%;height:260px;border-radius:8px;object-fit:cover;background:#000}
    canvas{display:none}
    .preview{width:100%;height:140px;border-radius:8px;object-fit:contain;background:#071022;display:flex;align-items:center;justify-content:center}
    .controls{display:flex;gap:8px;flex-wrap:wrap}
    button{background:var(--accent);border:none;padding:8px 12px;border-radius:8px;color:#032;cursor:pointer;font-weight:600}
    button.ghost{background:transparent;color:var(--white);border:1px solid rgba(255,255,255,0.06)}
    .muted{color:var(--muted);font-size:13px}
    .small{font-size:12px}
    .form{display:flex;flex-direction:column;gap:12px}
    .field{display:flex;flex-direction:column;gap:6px}
    .row{display:flex;gap:8px}
    .success{color:#4ade80}
    .error{color:#fb7185}
    select{padding:8px;border-radius:8px;background:#071022;border:1px solid rgba(255,255,255,0.04);color:var(--white)}
    @media(max-width:880px){.container{grid-template-columns:1fr;}}
  </style>
</head>
<body>
  <div class="container">
    <div class="panel">
      <header>
        <div style="width:44px;height:44px;background:linear-gradient(90deg,#053047,#0683a6);border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:700">KYC</div>
        <div>
          <h1>Verify your identity — Live ID capture</h1>
          <p class="lead">Use your device camera to take live photos of your ID document. We accept national IDs and passports. Make sure text is readable.</p>
        </div>
      </header>

      <div style="margin-top:12px" class="video-wrap">
        <div style="width:100%;display:flex;justify-content:space-between;align-items:center">
          <div class="muted small">Camera</div>
          <div class="row">
            <select id="deviceSelect"></select>
            <button id="toggleFacing" class="ghost small">Toggle Front/Back</button>
          </div>
        </div>

        <video id="camera" autoplay playsinline></video>
        <canvas id="captureCanvas"></canvas>

        <div class="controls">
          <button id="captureFront">Capture Front</button>
          <button id="captureBack">Capture Back</button>
          <button id="openFallback" class="ghost">Upload from device</button>
        </div>

        <div style="width:100%;display:flex;gap:8px;margin-top:6px">
          <div style="flex:1">
            <div class="muted small">Front preview</div>
            <div id="previewFront" class="preview muted">No image</div>
          </div>
          <div style="flex:1">
            <div class="muted small">Back preview</div>
            <div id="previewBack" class="preview muted">No image</div>
          </div>
        </div>

      </div>

      <div style="margin-top:12px;display:flex;justify-content:space-between;align-items:center">
        <div class="muted small">Accepted formats: JPG/PNG. Max 5 MB each.</div>
        <div id="status" class="muted small">Not uploaded</div>
      </div>

    </div>

    <div class="panel">
      <div class="form">
        <div>
          <h2 style="margin:0">Your details</h2>
          <p class="muted small">Fill fields below — we'll link the photos with this record.</p>
        </div>

        <div class="field">
          <label class="muted small">Full name</label>
          <input id="fullName" type="text" placeholder="As on the document" style="padding:10px;border-radius:8px;background:transparent;border:1px solid rgba(255,255,255,0.04);color:var(--white)" />
        </div>

        <div class="field">
          <label class="muted small">Document type</label>
          <select id="docType">
            <option value="national_id">National ID</option>
            <option value="passport">Passport</option>
            <option value="driver_license">Driver's license</option>
          </select>
        </div>

        <div style="display:flex;gap:8px">
          <button id="submitBtn">Submit KYC</button>
          <button id="resetBtn" class="ghost">Reset</button>
        </div>

        <div id="messages" class="muted small"></div>

        <form id="fallbackForm" style="display:none">
          <input id="fileInput" type="file" accept="image/*" multiple />
        </form>

      </div>
    </div>
  </div>

  <script>
    // Elements
    const video = document.getElementById('camera');
    const canvas = document.getElementById('captureCanvas');
    const deviceSelect = document.getElementById('deviceSelect');
    const toggleFacing = document.getElementById('toggleFacing');
    const captureFrontBtn = document.getElementById('captureFront');
    const captureBackBtn = document.getElementById('captureBack');
    const previewFront = document.getElementById('previewFront');
    const previewBack = document.getElementById('previewBack');
    const statusEl = document.getElementById('status');
    const submitBtn = document.getElementById('submitBtn');
    const resetBtn = document.getElementById('resetBtn');
    const fileInput = document.getElementById('fileInput');
    const openFallback = document.getElementById('openFallback');
    const messages = document.getElementById('messages');

    let stream = null;
    let currentDeviceId = null;
    let useFacingMode = 'environment'; // 'user' or 'environment'
    let frontBlob = null;
    let backBlob = null;

    async function startCamera(deviceId = null){
      if(stream){
        stream.getTracks().forEach(t=>t.stop());
        stream = null;
      }

      const constraints = {
        video: deviceId ? {deviceId: {exact: deviceId}} : {facingMode: useFacingMode, width: {ideal:1280}, height: {ideal:720}},
        audio: false
      };

      try{
        stream = await navigator.mediaDevices.getUserMedia(constraints);
        video.srcObject = stream;
        await video.play();
        populateDeviceList();
      }catch(err){
        console.error('camera error', err);
        messages.innerText = 'Unable to access camera. Use "Upload from device" as fallback.';
      }
    }

    async function populateDeviceList(){
      try{
        const devices = await navigator.mediaDevices.enumerateDevices();
        const cams = devices.filter(d=>d.kind === 'videoinput');
        deviceSelect.innerHTML = '';
        cams.forEach(c=>{
          const opt = document.createElement('option');
          opt.value = c.deviceId;
          opt.text = c.label || 'Camera ' + (deviceSelect.length+1);
          deviceSelect.appendChild(opt);
        });
        if(cams.length && !currentDeviceId){
          currentDeviceId = cams[0].deviceId;
          deviceSelect.value = currentDeviceId;
        }
      }catch(e){console.warn(e)}
    }

    deviceSelect.addEventListener('change', ()=>{
      currentDeviceId = deviceSelect.value;
      startCamera(currentDeviceId);
    });

    toggleFacing.addEventListener('click', ()=>{
      useFacingMode = useFacingMode === 'user' ? 'environment' : 'user';
      startCamera();
    });

    function captureToBlob(){
      if(!video.videoWidth) return null;
      const w = Math.min(1920, video.videoWidth);
      const h = Math.min(1080, video.videoHeight);
      canvas.width = w; canvas.height = h;
      const ctx = canvas.getContext('2d');
      ctx.drawImage(video, 0, 0, w, h);
      return new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', 0.9));
    }

    captureFrontBtn.addEventListener('click', async ()=>{
      messages.innerText = '';
      const blob = await captureToBlob();
      if(!blob){ messages.innerText = 'Capture failed.'; return }
      frontBlob = blob;
      previewFront.innerHTML = '';
      const img = document.createElement('img');
      img.style.maxWidth='100%'; img.style.maxHeight='100%';
      img.src = URL.createObjectURL(blob);
      previewFront.appendChild(img);
    });

    captureBackBtn.addEventListener('click', async ()=>{
      messages.innerText = '';
      const blob = await captureToBlob();
      if(!blob){ messages.innerText = 'Capture failed.'; return }
      backBlob = blob;
      previewBack.innerHTML = '';
      const img = document.createElement('img');
      img.style.maxWidth='100%'; img.style.maxHeight='100%';
      img.src = URL.createObjectURL(blob);
      previewBack.appendChild(img);
    });

    openFallback.addEventListener('click', ()=> fileInput.click());

    fileInput.addEventListener('change', (e)=>{
      const files = Array.from(e.target.files);
      // simple mapping: first to front, second to back
      if(files[0]){ frontBlob = files[0]; previewFront.innerHTML=''; const i=document.createElement('img'); i.src=URL.createObjectURL(files[0]); i.style.maxWidth='100%'; previewFront.appendChild(i); }
      if(files[1]){ backBlob = files[1]; previewBack.innerHTML=''; const i2=document.createElement('img'); i2.src=URL.createObjectURL(files[1]); i2.style.maxWidth='100%'; previewBack.appendChild(i2); }
    });

    resetBtn.addEventListener('click', ()=>{
      frontBlob = null; backBlob = null; previewFront.innerHTML='No image'; previewBack.innerHTML='No image'; messages.innerText=''; statusEl.innerText='Not uploaded';
    });

    submitBtn.addEventListener('click', async ()=>{
      messages.innerText = '';
      if(!frontBlob && !backBlob){ messages.innerText = 'Please capture at least one side of the document.'; return }
      submitBtn.disabled = true; submitBtn.innerText = 'Uploading...';

      const fd = new FormData();
      fd.append('full_name', document.getElementById('fullName').value);
      fd.append('doc_type', document.getElementById('docType').value);
      if(frontBlob) fd.append('front', frontBlob, 'front.jpg');
      if(backBlob) fd.append('back', backBlob, 'back.jpg');

      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

      try{
        const res = await fetch('/kyc/upload', {
          method:'POST',
          headers: token ? { 'X-CSRF-TOKEN': token } : {},
          body: fd
        });
        if(!res.ok){ throw new Error('Upload failed: ' + res.status) }
        const j = await res.json();
        statusEl.innerText = 'Uploaded';
        messages.innerHTML = '<span class="success">KYC submitted successfully.</span>';
      }catch(err){
        console.error(err);
        messages.innerHTML = '<span class="error">Upload failed. Please try again.</span>';
      }finally{
        submitBtn.disabled = false; submitBtn.innerText = 'Submit KYC';
      }
    });

    // Initialize
    (async ()=>{
      if(!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia){
        messages.innerText = 'getUserMedia not supported in this browser. Use file upload fallback.';
        return;
      }
      await startCamera();
    })();

    // stop camera when navigating away
    window.addEventListener('pagehide', ()=>{ if(stream) stream.getTracks().forEach(t=>t.stop()); });
  </script>
</body>
</html>
