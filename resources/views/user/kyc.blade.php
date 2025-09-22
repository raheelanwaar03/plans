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
    label{display:block;margin-top:1rem;font-weight:bold;}
    input[type=text]{width:100%;padding:0.7rem;border:1px solid #ccc;border-radius:0.5rem;}
    .scanner{margin-top:1rem;padding:1rem;border:2px dashed #ccc;border-radius:1rem;text-align:center;background:#fafafa;}
    video{width:100%;border-radius:0.5rem;background:#000;}
    img{width:100%;margin-top:0.5rem;border-radius:0.5rem;display:none;}
    .status{margin-top:0.5rem;font-size:0.9rem;color:#9333ea;}
    button{margin-top:1.5rem;width:100%;padding:0.9rem;border:none;border-radius:0.5rem;background:#2563eb;color:#fff;font-weight:bold;font-size:1rem;}
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
      <video id="videoFront" playsinline></video>
      <img id="thumbFront">
      <div class="status" id="statusFront">Waiting...</div>
      <input type="hidden" name="id_front" id="id_front">
    </div>

    <div class="scanner">
      <h4>Back of ID</h4>
      <video id="videoBack" playsinline></video>
      <img id="thumbBack">
      <div class="status" id="statusBack">Waiting...</div>
      <input type="hidden" name="id_back" id="id_back">
    </div>

    <div class="scanner">
      <h4>Selfie</h4>
      <video id="videoSelfie" playsinline></video>
      <img id="thumbSelfie">
      <div class="status" id="statusSelfie">Waiting...</div>
      <input type="hidden" name="selfie" id="selfie">
    </div>

    <button type="submit" id="submitBtn" disabled>Submit Verification</button>
  </form>
</div>

<script>
async function startCamera(videoEl, facing="environment", enableFlash=false){
  let stream = await navigator.mediaDevices.getUserMedia({
    video: { facingMode: facing, width:{ideal:1280}, height:{ideal:720} }
  });
  videoEl.srcObject = stream;
  await videoEl.play();

  // Torch (flash) if supported
  if(enableFlash){
    const track = stream.getVideoTracks()[0];
    const capabilities = track.getCapabilities();
    if(capabilities.torch){
      try{
        await track.applyConstraints({ advanced: [{torch:true}] });
        console.log("Torch enabled");
      }catch(e){ console.warn("Torch not supported",e); }
    }
  }
  return stream;
}

function autoCapture(videoEl, thumbEl, hiddenInput, statusEl){
  let stable=0;
  let captured=false;
  let canvas=document.createElement("canvas");

  async function loop(){
    if(captured){return;}
    if(videoEl.readyState<2){requestAnimationFrame(loop);return;}
    let vw=videoEl.videoWidth,vh=videoEl.videoHeight;
    canvas.width=vw;canvas.height=vh;
    let ctx=canvas.getContext("2d");
    ctx.drawImage(videoEl,0,0,vw,vh);

    let src=new cv.Mat(vh,vw,cv.CV_8UC4);
    cv.imshow(canvas,src); // just for dimensions
    src.delete();

    // Fake detection: you could integrate edge detection here
    stable++;
    if(stable>30){ // ~1 sec stable
      captured=true;
      let dataUrl=canvas.toDataURL("image/jpeg",0.9);
      thumbEl.src=dataUrl; thumbEl.style.display="block";
      hiddenInput.value=dataUrl;
      statusEl.innerText="Captured ✅";
      checkReady();
    }else{
      statusEl.innerText="Hold still... ("+stable+")";
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

document.addEventListener("DOMContentLoaded",async()=>{
  await cv['onRuntimeInitialized'];

  let vFront=document.getElementById("videoFront");
  let vBack=document.getElementById("videoBack");
  let vSelfie=document.getElementById("videoSelfie");

  let s1=await startCamera(vFront,"environment",true);
  autoCapture(vFront,document.getElementById("thumbFront"),document.getElementById("id_front"),document.getElementById("statusFront"));

  let s2=await startCamera(vBack,"environment",true);
  autoCapture(vBack,document.getElementById("thumbBack"),document.getElementById("id_back"),document.getElementById("statusBack"));

  let s3=await startCamera(vSelfie,"user",false);
  autoCapture(vSelfie,document.getElementById("thumbSelfie"),document.getElementById("selfie"),document.getElementById("statusSelfie"));
});
</script>
</body>
</html>
