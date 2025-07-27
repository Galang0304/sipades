<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 3px solid #007bff;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 28px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 15px 0;
        }
        .status-approved {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .status-processed {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
        .surat-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
            align-items: flex-start;
        }
        .info-label {
            font-weight: bold;
            width: 140px;
            color: #495057;
        }
        .info-value {
            flex: 1;
            color: #212529;
        }
        .message-box {
            background-color: #e7f3ff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #0056b3;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            margin-top: 30px;
            color: #6c757d;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 15px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🏛️ KUINSEL</h1>
            <p>Kelurahan Kuin Selatan</p>
        </div>

        <h2>{{ $title }}</h2>
        
        <p>Yth. <strong>{{ $recipient->name }}</strong>,</p>

        @if($status == 'approved_petugas')
            <p>Pengajuan surat Anda telah <strong>diproses oleh petugas</strong> dan sedang menunggu persetujuan dari Lurah.</p>
            <div class="status-badge status-processed">📋 Diproses Petugas</div>
        @elseif($status == 'approved_lurah')
            <p>Selamat! Pengajuan surat Anda telah <strong>disetujui oleh Lurah</strong> dan sudah siap untuk dicetak/diambil.</p>
            <div class="status-badge status-approved">✅ Disetujui Lurah</div>
        @elseif($status == 'rejected')
            <p>Mohon maaf, pengajuan surat Anda <strong>ditolak</strong> dengan alasan berikut:</p>
            <div class="status-badge status-rejected">❌ Ditolak</div>
        @elseif($status == 'new_for_lurah')
            <p>Ada pengajuan surat baru yang telah diproses petugas dan <strong>menunggu persetujuan Anda</strong>.</p>
            <div class="status-badge status-processed">📋 Menunggu Persetujuan</div>
        @endif

        <div class="surat-info">
            <h3>📄 Detail Pengajuan Surat</h3>
            <div class="info-row">
                <span class="info-label">Jenis Surat:</span>
                <span class="info-value">{{ $surat->jenis_surat->nama }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Pemohon:</span>
                <span class="info-value">{{ $surat->penduduk->nama_lengkap ?? $surat->user->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">NIK:</span>
                <span class="info-value">{{ $surat->nik }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Keperluan:</span>
                <span class="info-value">{{ $surat->keperluan }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Pengajuan:</span>
                <span class="info-value">{{ $surat->tanggal_pengajuan->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value"><strong>{{ $surat->status }}</strong></span>
            </div>
            
            @if($surat->tanggal_diproses_petugas)
            <div class="info-row">
                <span class="info-label">Diproses Petugas:</span>
                <span class="info-value">{{ $surat->tanggal_diproses_petugas->format('d/m/Y H:i') }}</span>
            </div>
            @endif
            
            @if($surat->tanggal_diproses_lurah)
            <div class="info-row">
                <span class="info-label">Disetujui Lurah:</span>
                <span class="info-value">{{ $surat->tanggal_diproses_lurah->format('d/m/Y H:i') }}</span>
            </div>
            @endif
        </div>

        @if($keterangan)
        <div class="message-box">
            <h4>💬 Keterangan:</h4>
            <p>{{ $keterangan }}</p>
        </div>
        @endif

        @if($status == 'approved_lurah')
        <div style="text-align: center; margin: 30px 0;">
            <p><strong>Surat Anda sudah dapat dicetak atau diambil di kantor desa.</strong></p>
            <a href="{{ route('surat.show', $surat->id) }}" class="btn">📄 Lihat Detail Surat</a>
        </div>
        @elseif($status == 'new_for_lurah')
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('surat.show', $surat->id) }}" class="btn">👀 Review Pengajuan</a>
        </div>
        @endif

        <div class="footer">
            <p>
                <strong>SIPADES - Sistem Informasi Pelayanan Administrasi Desa</strong><br>
                Email ini dikirim secara otomatis, mohon tidak membalas email ini.<br>
                Untuk pertanyaan lebih lanjut, silakan hubungi kantor desa.
            </p>
            <p style="font-size: 12px; color: #999;">
                © {{ date('Y') }} SIPADES. Semua hak dilindungi.
            </p>
        </div>
    </div>
</body>
</html>
