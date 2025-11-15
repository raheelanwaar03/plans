<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>KYC — Verify your identity</title>
    <style>
        :root {
            --bg: #0f1724;
            --card: #0b1220;
            --muted: #9aa4b2;
            --accent: #6ee7b7;
            --glass: rgba(255, 255, 255, 0.04);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(180deg, #071021 0%, #0a1724 60%);
            color: #e6eef6;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px
        }

        .container {
            width: 100%;
            max-width: 1100px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.01));
            border-radius: 14px;
            padding: 26px;
            box-shadow: 0 8px 30px rgba(2, 6, 23, 0.7);
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 22px
        }

        .left {
            padding: 10px
        }

        h1 {
            margin: 0 0 8px;
            font-size: 20px
        }

        p.lead {
            color: var(--muted);
            margin-top: 0;
            margin-bottom: 18px
        }

        form .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px
        }

        label {
            display: block;
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 6px
        }

        input[type=text],
        input[type=date],
        input[type=email],
        input[type=tel],
        select,
        textarea {
            width: 100%;
            padding: 11px 12px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.04);
            background: var(--glass);
            color: inherit;
            font-size: 14px;
            outline: none
        }

        textarea {
            min-height: 84px;
            resize: vertical
        }

        .full {
            grid-column: 1/-1
        }

        .card {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.01));
            padding: 14px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.03)
        }

        /* right column: camera, previews */
        .right {
            padding: 10px
        }

        .preview-wrap {
            display: flex;
            gap: 12px;
            flex-direction: column
        }

        .camera,
        .photo-preview {
            height: 240px;
            border-radius: 12px;
            overflow: hidden;
            background: #061021;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        .controls {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 12px
        }

        button.btn {
            background: linear-gradient(90deg, var(--accent), #34d399);
            border: none;
            padding: 10px 12px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            color: #06201a
        }

        button.ghost {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.04);
            color: var(--muted)
        }

        .small {
            font-size: 13px;
            padding: 8px 10px;
            border-radius: 8px
        }

        .meta {
            font-size: 12px;
            color: var(--muted);
            margin-top: 8px
        }

        /* hidden file input styles suppressed */
        input[type=file] {
            display: none
        }

        .row-actions {
            display: flex;
            gap: 8px;
            align-items: center
        }

        .img-thumb {
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        .help {
            font-size: 13px;
            color: var(--muted)
        }

        footer {
            grid-column: 1/-1;
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        @media(max-width:980px) {
            .container {
                grid-template-columns: 1fr;
            }

            .right {
                order: -1
            }
        }
    </style>
</head>

<body>
    <div class="container" role="main">
        <div class="left">
            <h1>KYC — Identity verification</h1>
            <p class="lead">Fill in your details and scan your identity document. We only store the images needed to
                verify your identity.</p>

            <form id="kycForm" action="{{ route('User.KYC.Data') }}" method="POST" enctype="multipart/form-data"
                class="card" autocomplete="off">
                <div class="grid">
                    <div>
                        <label for="fullname">Full name</label>
                        <input id="fullname" name="name" type="text" placeholder="John Doe" required />
                    </div>

                    <div>
                        <label for="phone">Phone</label>
                        <input id="phone" name="number" type="tel" placeholder="+1 555 000 1111" maxlength="11"
                            pattern="\d{11}" title="Enter 11 digits" inputmode="numeric" />
                    </div>

                    <div class="full">
                        <label for="cnic">CNIC</label>
                        <input id="cnic" name="cnic" type="tel" placeholder="3370512345670" maxlength="13"
                            pattern="\d{13}" title="Enter 13 digits" inputmode="numeric" required />
                    </div>

                    <div>
                        <label for="trc">Transcation number</label>
                        <input name="trx_id" type="text" placeholder="12345123451" maxlength="11" pattern="\d{11}"
                            title="Enter 11 digits" inputmode="numeric" required />
                    </div>

                    <div class="full">
                        <label>Document scan (Front)</label>
                        <div class="card"
                            style="display:flex;gap:12px;align-items:center;flex-direction:column;padding:12px">
                            <div id="docFrontPreview" class="photo-preview">
                                <span class="help">No document captured yet</span>
                            </div>

                            <div class="row-actions">
                                <button type="button" id="openCameraBtn" class="btn small">Scan document
                                    (camera)</button>
                                <input id="fileInput" name="idFront" accept="image/*" capture="environment"
                                    type="file" />
                                <button type="button" id="retakeDocFront" class="ghost small">Retake</button>
                            </div>
                            <div class="meta">Tip: For best results, hold the document flat in good light.</div>
                        </div>
                    </div>

                    <div class="full">
                        <label>Document scan (Back)</label>
                        <div class="card"
                            style="display:flex;gap:12px;align-items:center;flex-direction:column;padding:12px">
                            <div id="docBackPreview" class="photo-preview">
                                <span class="help">No back image captured yet</span>
                            </div>

                            <div class="row-actions">
                                <button type="button" id="openCameraBackBtn" class="btn small">Scan back
                                    (camera)</button>
                                <input id="fileInputBack" name="idBack" accept="image/*" capture="environment"
                                    type="file" />
                                <button type="button" id="retakeDocBack" class="ghost small">Retake</button>
                            </div>
                            <div class="meta">Scan the back side of your ID document.</div>
                        </div>
                    </div>

                    <div class="full">
                        <label>Selfie</label>
                        <div class="card" style="padding:12px">
                            <div id="selfiePreview" class="photo-preview"><span class="help">No selfie</span></div>
                            <div class="controls">
                                <button type="button" id="openSelfieBtn" class="btn small">Open camera</button>
                                <input id="selfieFile" name="selfie" accept="image/*" capture="user" type="file" />
                                <button type="button" id="retakeSelfie" class="ghost small">Retake</button>
                            </div>
                        </div>
                    </div>

                    <div class="full">
                        <label>Payment ScreenShot</label>
                        <div class="card" style="padding:12px">
                            <div id="selfiePreview" class="photo-preview"><span class="help">No payment
                                    screenshot</span></div>
                            <div class="controls">
                                <button type="button" id="paymentScreenshot" class="btn small">Open camera</button>
                                <input id="paymentScreenshot" name="paymentScreenshot" accept="image/*"
                                    capture="user" type="file" />
                                <button type="button" id="retakeSelfie" class="ghost small">Retake</button>
                            </div>
                        </div>
                    </div>

                </div>

                <footer>
                    <div class="meta">Your images are encrypted in transit.</div>
                    <div>
                        <button type="submit" class="btn">Submit KYC</button>
                    </div>
                </footer>
            </form>

        </div>

        <div class="right">
            <div class="preview-wrap card">
                <div class="camera" id="cameraArea">
                    <video id="video" autoplay playsinline></video>
                    <div id="cameraOverlay"
                        style="position:absolute;inset:0;pointer-events:none;display:flex;align-items:flex-end;justify-content:center;padding:12px">
                        <div
                            style="backdrop-filter:blur(6px);background:rgba(2,6,23,0.35);padding:6px 10px;border-radius:10px;font-size:13px;color:var(--muted)">
                            Camera preview</div>
                    </div>
                </div>

                <div style="display:flex;justify-content:space-between;align-items:center;margin-top:12px">
                    <div class="help">Use the camera to scan document or selfie. Click capture to take photo.</div>
                    <div>
                        <button id="captureBtn" class="btn small">Capture</button>
                        <button id="closeCamBtn" class="ghost small">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        (() => {
            const openCameraBtn = document.getElementById('openCameraBtn');
            const openSelfieBtn = document.getElementById('openSelfieBtn');
            const closeCamBtn = document.getElementById('closeCamBtn');
            const captureBtn = document.getElementById('captureBtn');
            const video = document.getElementById('video');
            const cameraArea = document.getElementById('cameraArea');
            const docPreview = document.getElementById('docPreview');
            const selfiePreview = document.getElementById('selfiePreview');
            const fileInput = document.getElementById('fileInput');
            const selfieFile = document.getElementById('selfieFile');
            const retakeDoc = document.getElementById('retakeDoc');
            const retakeSelfie = document.getElementById('retakeSelfie');
            const kycForm = document.getElementById('kycForm');

            let stream = null;
            let captureTarget = null; // 'doc' or 'selfie'

            function openCamera(forTarget) {
                captureTarget = forTarget;
                const constraints = {
                    video: {
                        facingMode: forTarget === 'doc' ? {
                            exact: "environment"
                        } : 'user'
                    }
                };
                // Try to get camera - fallback to default if facingMode exact fails
                navigator.mediaDevices.getUserMedia(constraints).catch(() => navigator.mediaDevices.getUserMedia({
                        video: true
                    }))
                    .then(s => {
                        stream = s;
                        video.srcObject = s;
                        cameraArea.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        // Show camera area visually
                        cameraArea.style.boxShadow = '0 12px 40px rgba(2,8,23,0.6)';
                    }).catch(err => {
                        alert('Unable to access camera: ' + (err && err.message ? err.message : err));
                    });
            }

            function closeCamera() {
                if (stream) {
                    stream.getTracks().forEach(t => t.stop());
                    stream = null;
                    video.srcObject = null;
                }
                captureTarget = null;
            }

            function dataUrlFromVideo() {
                const w = video.videoWidth || 1280;
                const h = video.videoHeight || 720;
                const canvas = document.createElement('canvas');
                canvas.width = w;
                canvas.height = h;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(video, 0, 0, w, h);
                return canvas.toDataURL('image/jpeg', 0.92);
            }

            function setPreview(elem, dataUrl) {
                elem.innerHTML = '';
                const img = document.createElement('img');
                img.className = 'img-thumb';
                img.alt = 'preview';
                img.src = dataUrl;
                elem.appendChild(img);
            }

            openCameraBtn.addEventListener('click', () => openCamera('doc'));
            openSelfieBtn.addEventListener('click', () => openCamera('selfie'));
            closeCamBtn.addEventListener('click', closeCamera);

            captureBtn.addEventListener('click', () => {
                if (!stream) {
                    alert('Camera is not open');
                    return;
                }
                const dataUrl = dataUrlFromVideo();
                if (captureTarget === 'doc') {
                    setPreview(docPreview, dataUrl);
                    docPreview.dataset.image = dataUrl;
                } else if (captureTarget === 'selfie') {
                    setPreview(selfiePreview, dataUrl);
                    selfiePreview.dataset.image = dataUrl;
                }
                // optionally auto-close camera
                closeCamera();
            });

            fileInput.addEventListener('change', (e) => {
                const file = e.target.files && e.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = () => {
                    setPreview(docPreview, reader.result);
                    docPreview.dataset.image = reader.result;
                };
                reader.readAsDataURL(file);
            });

            selfieFile.addEventListener('change', (e) => {
                const file = e.target.files && e.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = () => {
                    setPreview(selfiePreview, reader.result);
                    selfiePreview.dataset.image = reader.result;
                };
                reader.readAsDataURL(file);
            });

            retakeDoc.addEventListener('click', () => {
                docPreview.innerHTML = '<span class="help">No document captured yet</span>';
                delete docPreview.dataset.image;
            });
            retakeSelfie.addEventListener('click', () => {
                selfiePreview.innerHTML = '<span class="help">No selfie</span>';
                delete selfiePreview.dataset.image;
            });

            kycForm.addEventListener('submit', (e) => {
                e.preventDefault();
                // simple validation: require doc image
                if (!docPreview.dataset.image) {
                    alert('Please capture or upload your document before submitting.');
                    return;
                }

                const payload = {
                    documentBackImage: docBackPreview.dataset.image || null,
                    fullname: kycForm.fullname.value,
                    dob: kycForm.dob.value,
                    email: kycForm.email.value,
                    phone: kycForm.phone.value,
                    address: kycForm.address.value,
                    docType: kycForm.docType.value,
                    idNumber: kycForm.idNumber.value,
                    documentFrontImage: docPreview.dataset.image, // data URL
                    selfieImage: selfiePreview.dataset.image || null,
                    submittedAt: new Date().toISOString()
                };

                // show a friendly uploading state
                const submitBtn = kycForm.querySelector('button[type=submit]');
                const prevText = submitBtn.textContent;
                submitBtn.textContent = 'Uploading...';
                submitBtn.disabled = true;

                // Example POST: change URL to your backend.
                fetch('/upload-kyc', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                }).then(r => {
                    if (!r.ok) throw new Error('Server error ' + r.status);
                    return r.json();
                }).then(data => {
                    alert('KYC submitted successfully');
                    // reset or redirect as needed
                    kycForm.reset();
                    docPreview.innerHTML = '<span class="help">No document captured yet</span>';
                    selfiePreview.innerHTML = '<span class="help">No selfie</span>';
                }).catch(err => {
                    console.error(err);
                    alert('Submission failed: ' + (err.message || err));
                }).finally(() => {
                    submitBtn.textContent = prevText;
                    submitBtn.disabled = false;
                });
            });

            // Accessibility: allow pressing 'c' to capture when camera open
            document.addEventListener('keydown', e => {
                if (e.key.toLowerCase() === 'c' && stream) captureBtn.click();
            });

        })();
    </script>
</body>

</html>

{{-- <form id="form" action="{{ route('User.KYC.Data') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="display:flex;gap:12px;flex-wrap:wrap">
        <div style="flex:1;min-width:220px">
            <label for="fullName">Full name</label>
            <input id="fullName" name="name" type="text" placeholder="e.g. Ali Khan"
                autocomplete="name" required />
        </div>

        <div style="width:220px">
            <label for="cnic">Phone Num:</label>
            <input id="cnic" name="number" type="text" placeholder="12345123451"
                class="form-control" maxlength="11" pattern="\d{11}" title="Enter 11 digits"
                inputmode="numeric" required />
            <div class="muted">Max 11 digits — enforced in input.</div>
        </div>

        <div style="width:220px">
            <label for="cnic">Cnic:</label>
            <input id="cnic" name="cnic" type="number" placeholder="3370512345670" maxlength="13"
                pattern="\d{13}" title="Enter 13 digits" inputmode="numeric" required />
            <div class="muted">Max 13 digits — enforced in input.</div>
        </div>

        <div style="width:220px">
            <label for="cnic">Transaction ID (Trx ID)</label>
            <input id="cnic" name="trx_id" type="text" placeholder="12345123451" maxlength="11"
                pattern="\d{11}" title="Enter 11 digits" inputmode="numeric" required />
            <div class="muted">Max 11 digits — enforced in input.</div>
        </div>
    </div>

    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:13px;">
        <div style="flex:1;min-width:220px">
            <label for="Selfie">Selfie</label>
            <input id="selfie" name="selfie" type="file" required />
        </div>

        <div style="width:220px">
            <label for="cnic">Payment Screen Shot:</label>
            <input id="cnic" name="paymentScreenshot" type="file" placeholder="12345123451"
                maxlength="11" pattern="\d{11}" title="Enter 11 digits" inputmode="numeric" required />
        </div>
    </div>

    <hr style="margin:18px 0;border:none;border-top:1px solid rgba(255,255,255,0.03)" />

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
        <!-- Front -->
        <div>
            <label>Identity Card — Front</label>
            <div class="scanner-preview" id="frontPreview">
                <div style="text-align:center;padding:12px;color:var(--muted)">
                    <div style="font-weight:600">No front image</div>
                    <div class="muted"><span style="font-weight:700;color:#9be7ef">Upload Front
                            Side</span>
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:8px;margin-top:10px">
                <button type="button" class="btn" onclick="openScanner('front')">
                    Scan</button>
                <input id="frontUpload" type="file" onchange="handleUpload(event,'front')"
                    name="idFront" style="display: none" />
                <div style="flex:1"></div>
            </div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
        <!-- Front -->
        <div>
            <label>Identity Card — Back</label>
            <div class="scanner-preview" id="backPreview">
                <div style="text-align:center;padding:12px;color:var(--muted)">
                    <div style="font-weight:600">No back image</div>
                    <div class="muted"><span style="font-weight:700;color:#9be7ef">Upload Back
                            Side</span>
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:8px;margin-top:10px">
                <button type="button" class="btn" onclick="openScanner('back')">
                    Scan</button>
                <input id="backUpload" type="file" onchange="handleUpload(event,'back')"
                    name="idBack" style="display: none" />
                <div style="flex:1"></div>
            </div>
        </div>
    </div>

    <div style="margin-top:16px;display:flex;gap:10px;align-items:center">
        <button type="submit" class="btn">Submit</button>
    </div>
</form> --}}
