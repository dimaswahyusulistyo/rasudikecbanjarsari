<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #ffffff;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #003083;
            color: white;
            padding: 20px 0;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .header img {
            max-width: 100%;
            height: auto;
        }
        .content {
            margin: 20px 0;
            text-align: left;
            padding: 0 20px;
        }
        .content p {
            color: #555555;
            line-height: 1.6;
        }
        .credentials {
            margin-top: 20px;
        }
        .credentials p {
            margin-bottom: 10px;
            font-weight: bold;
            color: #333333;
        }
        .credentials span {
            color: #555555;
        }
        .success-card {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .success-card img {
            margin-right: 10px;
            width: 24px;
            height: 24px;
        }
        .success-card p {
            font-size: 24px;
            margin: 0;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 20px 0;
            color: #777777;
            border-radius: 0 0 8px 8px;
            text-align: center;
        }
        .footer p {
            margin: 0;
            line-height: 1.6;
        }
        .social-icons {
            margin-top: 10px;
        }
        .social-icons a {
            margin: 0 5px;
        }
        .social-icons img {
            width: 32px;
            height: 32px;
            vertical-align: middle;
        }
        .footer-links {
            margin-top: 10px;
            font-size: 14px;
        }
        .footer-links a {
            color: #777777;
            text-decoration: none;
            margin: 0 10px;
        }
        .footer-links a:hover {
            text-decoration: underline;
        }
        .footer-copyright {
            margin-top: 10px;
            font-size: 12px;
            color: #999999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://drive.google.com/thumbnail?id=14LCjhaVH29Wu7O37osiNxeb3xvyexyPN" alt="Header Image">
        </div>        
        <div class="content">
            <div class="success-card">
                <img src="https://img.icons8.com/color/48/000000/ok--v1.png" alt="Success">
                <p>Pendaftaran Berhasil</p>
            </div>
            <p style="font-size: 16px;">Hi {{ $email }},</p>
            <p style="font-size: 16px;">Anda telah terdaftar di situs web <b>Rasudi</b>. Berikut adalah kredensial Anda:</p>
            <div class="credentials">
                <p><strong>Username:</strong> <span>{{ $username }}</span></p>
                <p><strong>Password:</strong> <span>{{ $password }}</span></p>
            </div>
            <p style="font-size: 16px;">Harap simpan informasi ini dengan aman.</p>
        </div>
        <div class="footer">
            <p style="font-size: 14px;">Terima kasih atas dukungannya! <span style="font-size: 20px;" role="img" aria-label="heart">😍</span></p>
            <p style="font-size: 14px;">Aplikasi Surat Undangan dan Disposisi.</p>
            <div class="social-icons">
                <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook"></a>
                <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" alt="Twitter"></a>
                <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733558.png" alt="Instagram"></a>
            </div>
            <div class="footer-links">
                <a href="#">KEBIJAKAN PRIVASI</a> |
                <a href="#">SYARAT DAN KETENTUAN</a>
            </div>
            <p class="footer-copyright">Desain oleh TIM RASUDI</p>
        </div>
    </div>
</body>
</html>
