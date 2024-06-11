<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Verification</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <style>
      body, html {
        height: 100%;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f8f9fa; /* Light background color */
        font-family: Arial, sans-serif;
      }
      h2 {
        font-family: 'Anton', sans-serif;
      }
      .email-container {
        width: 100%;
        max-width: 600px;
        background-color: #ffffff; /* White background for email content */
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
      }
      .email-container img {
        max-width: 100px;
        max-height: 100px;
        margin-bottom: 20px;
      }
      .email-container a {
        display: inline-block;
        padding: 10px 20px;
        margin: 20px 0;
        color: #ffffff;
        background-color: #6c757d; /* Secondary button color */
        text-decoration: none;
        border-radius: 5px;
      }
    </style>
  </head>
  <body>
    <div class="email-container">
      <img src="https://aisya.cilacapkab.go.id/landing/images/topics/aisya_new.2.3.jpg" alt="...">
      <h2>Verifikasi alamat Email Anda!</h2>
      <p>Hi {{ $user->name }},</p>
      <p>Silakan klik tombol di bawah untuk memverifikasi alamat email Anda.</p>
      <p>
        <a href="{{ $verificationUrl }}">Verifikasi Email</a>
      </p>
      <p>Jika Anda tidak membuat akun, tidak perlu melakukan tindakan lebih lanjut.</p>
      <p class="text-start">Salam,<br> Aisya</p>
    </div>
  </body>
</html>