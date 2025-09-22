<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KYC Verification</title>
  <style>
    body {font-family:Arial;background:#f3f4f6;margin:0;padding:0;display:flex;justify-content:center;align-items:center;min-height:100vh;}
    .form-box{background:#fff;border-radius:1rem;box-shadow:0 8px 20px rgba(0,0,0,0.2);padding:1.5rem;max-width:500px;width:100%;}
    h2{text-align:center;color:#2563eb;}
    label{display:block;margin-top:1rem;font-weight:bold;}
    input[type=text]{width:100%;padding:0.7rem;border:1px solid #ccc;border-radius:0.5rem;}
    .scanner{margin-top:1rem;padding:1rem;border:2px dashed #ccc;border-radius:1rem;text-align:center;background:#fafafa;}
    video{width:100%;border-radius:0.5rem;background:#000;}
    img{width:100%;margin-top:0.5rem;border-radius:0.5rem;display:none;}
    .status{margin-top:0.5rem;font-size:0.9rem;color:#9333ea;}
    button.scan-btn{margin-top:0.8rem;padding:0.6rem 1rem;border:none;border-radius:0.5rem;background:#2563eb;color:#fff;font-weight:bold;}
    button[type=submit]{margin-top:1.5rem;width:100%;padding:0.9rem;border:none;border-radius:0.5rem;background:#16a34a;color:#fff;font-weight:bold;font-size:1rem;}
  </style>
</head>
<body>
<div class="form-box">
  <h2>KYC Verification</h2>
  <form id="kycForm" method="POST" action="#">
    @csrf

    <label>Full Name</label>
    <input type="text" name="full_name" required>

    <div class="scanner">
      <h4>Front of ID</h4>
      <button type="button" class="scan-btn" onclick="startScan('front')">Scan Now</button>
      <video id="videoFront" playsinline></video>
      <img id="thumbFront">
      <div class="status" id="statusFront">Not scanned yet</div>
      <input type="hidden" name="id_front" id="id_front">
    </div>

    <div class="scanner">
      <h4>Back of ID</h4>
      <button type="button" class="scan-btn" onclick="startScan('back')">Scan Now</button>
      <video id="videoBack" playsinline></video>
      <img id="thumbBack">
      <div class="status" id="statusBack">Not scanned yet</div>
      <input type="hidden" name="id_back" id="id_back">
    </div>

    <div class="scanner">
      <h4>Selfie</h4>
      <button type="button" class="scan-btn" onclick="startScan('selfie')">Scan Now</button>
      <video id="videoSelfie" playsinline></video>
      <img id="thumbSelfie">
      <div class="status" id="statusSelfie">Not scanned yet</div>
      <input type="hidden" name="selfie" id="selfie">
    </div>

    <button type="submit" id="submitBtn" disabled>Submit Verification</button>
  </form>
</div>

<script>
async function startScan(type){
  let video=document.getElementById("video"+capitalize(type));
  let thumb=document.getElementById("thumb"+capitalize(type));
  let hidden=document.getElementById(type=="front"?"id_front":type=="back"?"id_back":"selfie");
  let status=document.getElementById("status"+capitalize(type));

  status.innerText="Opening camera...";
  thumb.style.display="none";
  video.style.display="block";

  let facing=(type==="selfie")?"user":"environment";
  let stream=await navigator.mediaDevices.getUserMedia({video:{facingMode:facing}});
  video.srcObject=stream;
  await video.play();

  let canvas=document.createElement("canvas");
  let captured=false, stable=0;

  function loop(){
    if(captured) return;
    if(video.readyState<2){requestAnimationFrame(loop);return;}

    canvas.width=video.videoWidth;
    canvas.height=video.videoHeight;
    let ctx=canvas.getContext("2d");
    ctx.drawImage(video,0,0,canvas.width,canvas.height);

    stable++;
    if(stable>30){ // ~1 sec stable
      captured=true;
      let dataUrl=canvas.toDataURL("image/jpeg",0.9);
      hidden.value=dataUrl;
      thumb.src=dataUrl; thumb.style.display="block";
      status.innerText="Captured ✅";
      video.srcObject.getTracks().forEach(t=>t.stop());
      video.style.display="none";
      checkReady();
    }else{
      status.innerText="Scanning... Hold steady ("+stable+")";
      requestAnimationFrame(loop);
    }
  }
  loop();
}

function checkReady(){
  let ok=document.getElementById("id_front").value &&
           document.getElementById("id_back").value &&
           document.getElementById("selfie").value;
  if(ok) document.getElementById("submitBtn").disabled=false;
}

function capitalize(s){return s.charAt(0).toUpperCase()+s.slice(1);}
</script>
</body>
</html>
