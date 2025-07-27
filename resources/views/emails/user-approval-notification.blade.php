<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #ddd;
            margin-bottom: 20px;
        }
        .content {
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            font-size: 12px;
            color: #666;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0d6efd;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .status-approved {
            color: #28a745;
        }
        .status-rejected {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>KUINSEL</h1>
            <p>Kelurahan Kuin Selatan</p>
        </div>
        
        <div class="content">
            <p>Yth. {{ $user->name }},</p>

            @if($status === 'approved')
                <h2 class="status-approved">✓ Pendaftaran Disetujui</h2>
                <p>Selamat! Pendaftaran akun KUINSEL Anda telah disetujui. Anda sekarang dapat login ke sistem menggunakan email dan password yang telah didaftarkan.</p>
                
                <p>Detail akun Anda:</p>
                <ul>
                    <li>Nama: {{ $user->name }}</li>
                    <li>Email: {{ $user->email }}</li>
                    <li>NIK: {{ $user->nik }}</li>
                </ul>

                <center>
                    <a href="{{ url('/login') }}" class="button">Login ke KUINSEL</a>
                </center>
            @else
                <h2 class="status-rejected">✗ Pendaftaran Ditolak</h2>
                <p>Mohon maaf, pendaftaran akun SIPADES Anda tidak dapat disetujui karena alasan berikut:</p>
                
                <div style="background: #f8d7da; border: 1px solid #dc3545; padding: 15px; border-radius: 5px; margin: 20px 0;">
                    <p style="margin: 0; color: #721c24;">{{ $reason }}</p>
                </div>

                <p>Anda dapat mendaftar kembali dengan memperbaiki data sesuai dengan alasan penolakan di atas.</p>
                
                <center>
                    <a href="{{ url('/register') }}" class="button">Daftar Ulang</a>
                </center>
            @endif
        </div>

        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh sistem SIPADES.</p>
            <p>© {{ date('Y') }} SIPADES - Sistem Informasi Pelayanan Administrasi Desa</p>
        </div>
    </div>
</body>
</html>
