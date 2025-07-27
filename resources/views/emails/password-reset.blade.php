<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - KUINSEL</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
            border: 1px solid #dee2e6;
        }
        .button {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background: #218838;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏛️ KUINSEL</h1>
        <p>Kelurahan Kuin Selatan</p>
    </div>
    
    <div class="content">
        <h2>Reset Password</h2>
        
        <p>Halo <strong>{{ $name }}</strong>,</p>
        
        <p>Kami menerima permintaan untuk mereset password akun SIPADES Anda. Klik tombol di bawah ini untuk mereset password:</p>
        
        <div style="text-align: center;">
            <a href="{{ $resetUrl }}" class="button">Reset Password</a>
        </div>
        
        <div class="warning">
            <strong>⚠️ Perhatian:</strong>
            <ul>
                <li>Link reset password ini akan kadaluarsa dalam <strong>{{ $expireTime }}</strong></li>
                <li>Jika Anda tidak meminta reset password, abaikan email ini</li>
                <li>Jangan berikan link ini kepada orang lain</li>
            </ul>
        </div>
        
        <p>Jika tombol di atas tidak berfungsi, Anda dapat menyalin dan menempel URL berikut ke browser:</p>
        <p style="word-break: break-all; background: #e9ecef; padding: 10px; border-radius: 5px; font-size: 12px;">
            {{ $resetUrl }}
        </p>
        
        <p>Terima kasih,<br>
        <strong>Tim SIPADES</strong></p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        <p>&copy; {{ date('Y') }} SIPADES - Sistem Informasi Pelayanan Administrasi Desa</p>
    </div>
</body>
</html>
