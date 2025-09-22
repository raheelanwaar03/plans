<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KYC Verification</title>

  <script async src="https://docs.opencv.org/4.x/opencv.js"></script>

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg,#2563eb,#9333ea);
      margin: 0; padding: 0;
      display: flex; justify-content: center; align-items: center;
      min-height: 100vh;
    }
    .form-box {
      background: #fff;
      border-radius: 1.5rem;
      box-shadow: 0 10px 30px rgba(0,0,0,0.25);
      padding: 2rem;
      max-width: 500px;
      width: 100%;
    }
    h2 { text-align:center; color:#2563eb; margin-bottom:1rem; }
    label { display:block; margin-top:1rem; font-weight:600; color:#333; }
    input[type="text"] {
      width:100%; padding:0.7rem; margin-top:0.3rem;
      border:1px solid #ccc; border-radius:0.6rem;
      font-size:1rem;
    }
    .scanner-card {
      margin-top:1rem; text-align:center;
      background:#f9fafb; border-radius:1rem; padding:1rem;
      border:2px dashed #ccc;
    }
    video, img {
      width:100%; border-radius:1rem; margin-top:0.5rem;
      background:#000;
    }
    .status { margin-top:0.5rem; font-size:0.9rem; color:#9333ea; font-weight:600; }
    button {
      margin-top:1.5rem; width:100%;
      padding:0.9rem; border:none; border-radius:0.8rem;
      background:#2563eb; color:#fff;
      font-size:1rem; font-weight:600;
      cursor:pointer; transition:0.3s;
    }
    button:hover { background:#1d4ed8; }
  </style>
</head>
<body>
<div class="form-box">
  <h2>KYC Verification</h2>

  <form id="kycForm" method="POST" action="#">
    @csrf

    <label>Full Name</label>
    <input type="text" name="full_name" required placeholder="Enter your name">

    <!-- FRONT -->
    <div class="scanner-card">
      <h4>Front of ID</h4>
      <video id="videoFront" playsinline></video>
      <canvas id="canvasFront" style="display:none;"></canvas>
      <img id="thumbFront">
      <div class="status" id="statusFront">Waiting...</div>
      <input type="hidden" name="id_front" id="id_front">
    </div>

    <!-- BACK -->
    <div class="scanner-card">
      <h4>Back of ID</h4>
      <video id="videoBack" playsinline></video>
      <canvas id="canvasBack" style="display:none;"></canvas>
      <img id="thumbBack">
      <div class="status" id="statusBack">Waiting...</div>
      <input type="hidden" name="id_back" id="id_back">
    </div>

    <!-- SELFIE -->
    <div class="scanner-card">
      <h4>Selfie</h4>
      <video id="videoSelfie" playsinline></video>
      <canvas id="canvasSelfie" style="display:none;"></canvas>
      <img id="thumbSelfie">
      <div class="status" id="statusSelfie">Waiting...</div>
      <input type="hidden" name="selfie" id="selfie">
    </div>

    <button type="submit" id="submitBtn" disabled>Submit Verification</button>
  </form>
</div>

<script>
function getConstraints(faceMode="environment"){
  return { video:{facingMode:faceMode,width:{ideal:1280},height:{ideal:720}}, audio:false };
}

class AutoScanner{
  constructor(video,canvas,thumb,status,hidden,faceMode="environment"){
    this.video=video;this.canvas=canvas;this.thumb=thumb;this.status=status;this.hidden=hidden;
    this.faceMode=faceMode;this.stream=null;this.captured=false;this.stable=0;
  }
  async start(){
    await new Promise(res=>{
      let chk=setInterval(()=>{if(typeof cv!=="undefined"&&cv.Mat){clearInterval(chk);res();}},50);
    });
    this.stream=await navigator.mediaDevices.getUserMedia(getConstraints(this.faceMode));
    this.video.srcObject=this.stream;await this.video.play();
    this.loop();
  }
  loop(){
    if(this.captured) return;
    let vw=this.video.videoWidth,vh=this.video.videoHeight;
    if(!vw){requestAnimationFrame(()=>this.loop());return;}
    let tmp=document.createElement("canvas");tmp.width=vw;tmp.height=vh;
    tmp.getContext("2d").drawImage(this.video,0,0,vw,vh);
    let src=cv.imread(tmp),gray=new cv.Mat();
    cv.cvtColor(src,gray,cv.COLOR_RGBA2GRAY,0);
    let edges=new cv.Mat();cv.Canny(gray,edges,50,150);
    let contours=new cv.MatVector(),hierarchy=new cv.Mat();
    cv.findContours(edges,contours,hierarchy,cv.RETR_LIST,cv.CHAIN_APPROX_SIMPLE);
    let found=false;
    for(let i=0;i<contours.size();i++){
      let c=contours.get(i);let peri=cv.arcLength(c,true);
      let approx=new cv.Mat();cv.approxPolyDP(c,approx,0.02*peri,true);
      if(approx.rows===4){
        let rect=cv.boundingRect(approx);
        if(rect.width*rect.height>vw*vh*0.25){found=true;}
      }
      approx.delete();c.delete();if(found)break;
    }
    if(found){this.stable++;this.status.innerText="Detecting...("+this.stable+")";
      if(this.stable>=3)this.capture();
    }else{this.stable=0;this.status.innerText="Waiting...";}
    src.delete();gray.delete();edges.delete();contours.delete();hierarchy.delete();
    requestAnimationFrame(()=>this.loop());
  }
  capture(){
    this.captured=true;
    this.canvas.width=this.video.videoWidth;this.canvas.height=this.video.videoHeight;
    this.canvas.getContext("2d").drawImage(this.video,0,0,this.canvas.width,this.canvas.height);
    let dataUrl=this.canvas.toDataURL("image/jpeg",0.9);
    this.thumb.src=dataUrl;this.thumb.style.display="block";
    this.hidden.value=dataUrl;this.status.innerText="Captured ✅";
    this.stream.getTracks().forEach(t=>t.stop());
    checkSubmitReady();
  }
}

function checkSubmitReady(){
  let allFilled=document.getElementById("id_front").value &&
                 document.getElementById("id_back").value &&
                 document.getElementById("selfie").value;
  if(allFilled) document.getElementById("submitBtn").disabled=false;
}

document.addEventListener("DOMContentLoaded",async()=>{
  let front=new AutoScanner(
    document.getElementById("videoFront"),
    document.getElementById("canvasFront"),
    document.getElementById("thumbFront"),
    document.getElementById("statusFront"),
    document.getElementById("id_front")
  );
  let back=new AutoScanner(
    document.getElementById("videoBack"),
    document.getElementById("canvasBack"),
    document.getElementById("thumbBack"),
    document.getElementById("statusBack"),
    document.getElementById("id_back")
  );
  let selfie=new AutoScanner(
    document.getElementById("videoSelfie"),
    document.getElementById("canvasSelfie"),
    document.getElementById("thumbSelfie"),
    document.getElementById("statusSelfie"),
    document.getElementById("selfie"),
    "user" // front camera
  );
  await front.start();await back.start();await selfie.start();
});
</script>
</body>
</html>
