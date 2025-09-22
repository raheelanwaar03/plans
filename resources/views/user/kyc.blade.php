<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KYC Verification</title>
  <script async src="https://docs.opencv.org/4.x/opencv.js"></script>
  <style>
    body {font-family:Arial;background:#f3f4f6;margin:0;padding:0;display:flex;justify-content:center;align-items:center;min-height:100vh;}
    .form-box{background:#fff;border-radius:1rem;box-shadow:0 8px 20px rgba(0,0,0,0.2);padding:1.5rem;max-width:500px;width:100%;}
    h2{text-align:center;color:#2563eb;}
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

    <div class="scanner">
      <h4>Front of ID</h4>
      <button type="button" class="scan-btn" onclick="startDocScan('front')">Scan Now</button>
      <video id="videoFront" playsinline></video>
      <img id="thumbFront">
      <div class="status" id="statusFront">Not scanned yet</div>
      <input type="hidden" name="id_front" id="id_front">
    </div>

    <div class="scanner">
      <h4>Back of ID</h4>
      <button type="button" class="scan-btn" onclick="startDocScan('back')">Scan Now</button>
      <video id="videoBack" playsinline></video>
      <img id="thumbBack">
      <div class="status" id="statusBack">Not scanned yet</div>
      <input type="hidden" name="id_back" id="id_back">
    </div>

    <div class="scanner">
      <h4>Selfie</h4>
      <button type="button" class="scan-btn" onclick="startFaceScan()">Scan Now</button>
      <video id="videoSelfie" playsinline></video>
      <img id="thumbSelfie">
      <div class="status" id="statusSelfie">Not scanned yet</div>
      <input type="hidden" name="selfie" id="selfie">
    </div>

    <button type="submit" id="submitBtn" disabled>Submit Verification</button>
  </form>
</div>

<script>
function capitalize(s){return s.charAt(0).toUpperCase()+s.slice(1);}

async function startDocScan(type){
  let video=document.getElementById("video"+capitalize(type));
  let thumb=document.getElementById("thumb"+capitalize(type));
  let hidden=document.getElementById(type=="front"?"id_front":"id_back");
  let status=document.getElementById("status"+capitalize(type));

  status.innerText="Opening camera...";
  thumb.style.display="none";
  video.style.display="block";

  let stream=await navigator.mediaDevices.getUserMedia({video:{facingMode:"environment"}});
  video.srcObject=stream;
  await video.play();

  let canvas=document.createElement("canvas");
  let captured=false, stable=0;

  function detectID(){
    if(captured) return;
    if(video.readyState<2){requestAnimationFrame(detectID);return;}

    canvas.width=video.videoWidth;
    canvas.height=video.videoHeight;
    let ctx=canvas.getContext("2d");
    ctx.drawImage(video,0,0,canvas.width,canvas.height);

    let src=cv.imread(canvas);
    let gray=new cv.Mat();
    cv.cvtColor(src,gray,cv.COLOR_RGBA2GRAY);
    let edges=new cv.Mat();
    cv.Canny(gray,edges,75,200);

    let contours=new cv.MatVector();
    let hierarchy=new cv.Mat();
    cv.findContours(edges,contours,hierarchy,cv.RETR_LIST,cv.CHAIN_APPROX_SIMPLE);

    let foundRect=false;
    for(let i=0;i<contours.size();i++){
      let cnt=contours.get(i);
      let peri=cv.arcLength(cnt,true);
      let approx=new cv.Mat();
      cv.approxPolyDP(cnt,approx,0.02*peri,true);
      if(approx.rows===4){
        // Found a rectangle
        foundRect=true;
        break;
      }
      approx.delete();
    }

    if(foundRect){
      stable++;
      status.innerText="ID detected, hold steady ("+stable+")";
      if(stable>10){ // ~0.3 sec stable
        captured=true;
        let dataUrl=canvas.toDataURL("image/jpeg",0.9);
        hidden.value=dataUrl;
        thumb.src=dataUrl; thumb.style.display="block";
        status.innerText="Captured ✅";
        video.srcObject.getTracks().forEach(t=>t.stop());
        video.style.display="none";
        checkReady();
      }
    }else{
      stable=0;
      status.innerText="No ID detected";
    }

    src.delete();gray.delete();edges.delete();contours.delete();hierarchy.delete();
    requestAnimationFrame(detectID);
  }
  detectID();
}

async function startFaceScan(){
  let video=document.getElementById("videoSelfie");
  let thumb=document.getElementById("thumbSelfie");
  let hidden=document.getElementById("selfie");
  let status=document.getElementById("statusSelfie");

  status.innerText="Opening front camera...";
  video.style.display="block";thumb.style.display="none";

  let stream=await navigator.mediaDevices.getUserMedia({video:{facingMode:"user"}});
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
    if(stable>30){
      captured=true;
      let dataUrl=canvas.toDataURL("image/jpeg",0.9);
      hidden.value=dataUrl;
      thumb.src=dataUrl; thumb.style.display="block";
      status.innerText="Selfie captured ✅";
      video.srcObject.getTracks().forEach(t=>t.stop());
      video.style.display="none";
      checkReady();
    }else{
      status.innerText="Scanning face... ("+stable+")";
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

cv['onRuntimeInitialized']=()=>{console.log("OpenCV ready");};
</script>
</body>
</html>
