<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi - Smart Nahwu</title>
    <style>
        body {
            background-color: #fbf8f1;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            color: #2b3a32;
        }
        .wrapper {
            background-color: #fbf8f1;
            width: 100%;
            padding: 40px 0;
        }
        .container {
            max-width: 580px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #e2d9c0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(27, 67, 50, 0.02);
        }
        .header {
            background-color: #1b4332;
            padding: 35px 30px;
            text-align: center;
            border-bottom: 4px solid #b45309;
        }
        .header-title {
            color: #fbf8f1;
            font-size: 24px;
            font-weight: 800;
            margin: 0;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 700;
            color: #1b4332;
            margin-top: 0;
            margin-bottom: 20px;
        }
        .text {
            font-size: 15px;
            line-height: 1.65;
            color: #2b3a32;
            margin-bottom: 24px;
        }
        .button-container {
            text-align: center;
            margin: 35px 0;
        }
        .button {
            display: inline-block;
            background-color: #1b4332;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 28px;
            font-size: 15px;
            font-weight: 700;
            border-radius: 8px;
            border: 1px solid #133225;
            box-shadow: 0 4px 6px rgba(27, 67, 50, 0.15);
        }
        .info-box {
            background-color: #f5efe6;
            border-left: 4px solid #dfb15b;
            padding: 15px 20px;
            border-radius: 4px;
            margin-bottom: 24px;
        }
        .info-title {
            font-weight: 700;
            color: #b45309;
            margin-top: 0;
            margin-bottom: 6px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-text {
            font-size: 13.5px;
            line-height: 1.5;
            color: #5c6f60;
            margin: 0;
        }
        .footer {
            background-color: #fbf8f1;
            padding: 24px 30px;
            text-align: center;
            border-top: 1px solid #e6dec9;
        }
        .footer-text {
            font-size: 12px;
            color: #5c6f60;
            margin: 4px 0;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <!-- Header -->
            <div class="header">
                <div class="header-title">Smart Nahwu</div>
            </div>
            
            <!-- Content -->
            <div class="content">
                <div class="greeting">Assalamu'alaikum / Halo, {{ $name }}</div>
                
                <div class="text">
                    Kami mengirimkan email ini karena kami menerima permintaan untuk mengatur ulang kata sandi akun Smart Nahwu Anda. Jika Anda memang mengajukan permintaan ini, silakan klik tombol di bawah ini untuk membuat kata sandi baru:
                </div>
                
                <div class="button-container">
                    <a href="{{ $url }}" class="button" target="_blank">Atur Ulang Kata Sandi</a>
                </div>
                
                <div class="info-box">
                    <div class="info-title">Pemberitahuan Penting</div>
                    <p class="info-text">
                        Tautan tombol di atas hanya berlaku selama <strong>60 menit</strong>. Demi menjaga keamanan akun Anda, mohon untuk tidak menyebarkan atau meneruskan email ini kepada pihak manapun.
                    </p>
                </div>
                
                <div class="text" style="margin-bottom: 0;">
                    Jika Anda merasa tidak melakukan permintaan ini, silakan abaikan email ini. Kata sandi Anda saat ini akan tetap aman dan tidak akan berubah.
                </div>
            </div>
            
            <!-- Footer -->
            <div class="footer">
                <div class="footer-text">
                    Selamat belajar & sukses selalu,
                </div>
                <div class="footer-text" style="font-weight: 700; color: #1b4332; margin-bottom: 12px;">
                    Tim Smart Nahwu
                </div>
                <div class="footer-text" style="font-size: 11px; color: #8e9e92; border-top: 1px solid #e6dec9; padding-top: 12px; margin-top: 12px;">
                    Email ini dikirim secara otomatis oleh sistem Smart Nahwu.<br>
                    &copy; {{ date('Y') }} Smart Nahwu. Media belajar tata bahasa kitab Jurumiyah.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
