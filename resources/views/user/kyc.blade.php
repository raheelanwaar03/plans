<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>KYC Verification</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f4f6f9; }
    .container { max-width:600px; margin:40px auto; background:#fff; padding:30px; border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,0.1); }
    h2 { text-align:center; margin-bottom:20px; }
    .btn { display:block; margin:15px auto; padding:12px 20px; background:#4CAF50; color:#fff; border:none; border-radius:6px; cursor:pointer; font-size:16px; }
    .btn:hover { background:#45a049; }
    #onfido-mount { margin-top:20px; }
  </style>
  <!-- Onfido Web SDK -->
  <link href="https://assets.onfido.com/web-sdk-releases/8.16.0/style.css" rel="stylesheet" />
  <script src="https://assets.onfido.com/web-sdk-releases/8.16.0/onfido.min.js"></script>
</head>
<body>
  <div class="container">
    <h2>KYC Verification</h2>
    <form>
      <input type="text" name="name" placeholder="Full Name" required><br><br>

      <!-- Start Scan Button -->
      <button type="button" class="btn" id="startKyc">Start Scan</button>

      <!-- SDK UI will mount here -->
      <div id="onfido-mount"></div>

      <br>
      <button type="submit" class="btn">Submit KYC</button>
    </form>
  </div>

  <script>
    document.getElementById('startKyc').addEventListener('click', function() {
      // ⚠️ In real Laravel app, fetch token from backend API route
      const onfidoToken = "YOUR_ONFIDO_SDK_TOKEN";

      Onfido.init({
        token: onfidoToken,
        containerId: 'onfido-mount',
        onComplete: function(data) {
          console.log("KYC completed:", data);
          alert("KYC process finished successfully!");
        },
        steps: [
          {
            type: 'document',
            options: {
              documentTypes: { nationalIdentityCard: true }
            }
          },
          'face'
        ]
      });
    });
  </script>
</body>
</html>
