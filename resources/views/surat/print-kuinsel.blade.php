<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $surat->jenis_surat->nama_surat }} - {{ $surat->penduduk->nama_lengkap ?? $surat->user->name }}</title>
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 10pt;
            line-height: 1.2;
            color: #000;
            margin: 0;
            padding: 0;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
        }
        
        .header h2 {
            font-size: 12pt;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
        }
        
        .header h3 {
            font-size: 11pt;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
        }
        
        .header h5 {
            font-size: 9pt;
            margin: 2px 0;
            font-weight: normal;
        }
        
        .header hr {
            border: none;
            border-top: 2px solid #000;
            margin: 8px 0;
        }
        
        .letter-title {
            text-align: center;
            margin: 10px 0;
        }
        
        .letter-title h4 {
            font-size: 11pt;
            font-weight: bold;
            margin: 5px 0;
            text-transform: uppercase;
        }
        
        .letter-title .underline {
            text-decoration: underline;
        }
        
        .content {
            margin: 15px 0;
            text-align: justify;
        }
        
        .content p {
            margin: 6px 0;
            font-size: 10pt;
        }
        
        .data-table {
            margin: 10px 0;
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table td {
            padding: 1px 0;
            vertical-align: top;
            border: none;
            font-size: 10pt;
        }
        
        .data-table .label {
            width: 180px;
        }
        
        .data-table .separator {
            width: 15px;
            text-align: center;
        }
        
        .signature {
            margin-top: 20px;
            text-align: right;
            page-break-inside: avoid;
        }
        
        .signature p {
            margin: 2px 0;
            font-size: 10pt;
        }
        
        .barcode-signature {
            text-align: right;
            margin: 10px 0;
            padding-right: 10px;
        }
        
        .barcode-signature img {
            width: 100px;
            height: auto;
        }
        
        @media print {
            body { 
                -webkit-print-color-adjust: exact;
                font-size: 10pt !important;
            }
            .no-print { display: none; }
            .signature { page-break-inside: avoid; }
            .content { page-break-inside: avoid; }
        }
        
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            z-index: 1000;
        }
        
        .print-btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <button class="print-btn no-print" onclick="window.print()">Cetak Surat</button>

    <!-- Header Resmi Kelurahan -->
    <div class="header">
        <h2>PEMERINTAH KOTA BANJARMASIN</h2>
        <h3>KECAMATAN BANJARMASIN BARAT<br>KELURAHAN KUIN SELATAN</h3>
        <h5>Alamat : JL. SIMPANG KUIN SELATAN RT.22 NO.01 KODE POS : 70128</h5>
        <hr>
    </div>
    
    <!-- Judul Surat -->
    <div class="letter-title">
        <h4 class="underline">{{ strtoupper($surat->jenis_surat->nama_surat) }}</h4>
        <h4>Nomor : KS / {{ $surat->jenis_surat->kode_surat }} / {{ str_pad($surat->id, 3, '0', STR_PAD_LEFT) }} / {{ date('Y') }}</h4>
    </div>

    <!-- Konten Surat -->
    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Lurah Kuin Selatan, Kecamatan Banjarmasin Barat, Kota Banjarmasin, dengan ini menerangkan bahwa:</p>

        <!-- Data Penduduk -->
        <table class="data-table">
            <tr>
                <td class="label">NIK</td>
                <td class="separator">:</td>
                <td>{{ $surat->nik }}</td>
            </tr>
            <tr>
                <td class="label">Nama</td>
                <td class="separator">:</td>
                <td>{{ $surat->penduduk->nama_lengkap ?? $surat->user->name }}</td>
            </tr>
            <tr>
                <td class="label">Tempat, Tanggal Lahir</td>
                <td class="separator">:</td>
                <td>
                    @if($surat->penduduk)
                        {{ $surat->penduduk->tempat_lahir }}, {{ \Carbon\Carbon::parse($surat->penduduk->tanggal_lahir)->format('d F Y') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td class="separator">:</td>
                <td>{{ $surat->penduduk->jenis_kelamin ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Agama</td>
                <td class="separator">:</td>
                <td>{{ $surat->penduduk->agama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Status Perkawinan</td>
                <td class="separator">:</td>
                <td>{{ $surat->penduduk->status_perkawinan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Pekerjaan</td>
                <td class="separator">:</td>
                <td>{{ $surat->penduduk->pekerjaan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td class="separator">:</td>
                <td>{{ $surat->penduduk->alamat ?? $surat->user->alamat ?? '-' }}</td>
            </tr>
        </table>

        <!-- Konten Khusus Berdasarkan Jenis Surat -->
        @php
            $kode = $surat->jenis_surat->kode_surat;
            $keperluan = $surat->keperluan;
            $data = $surat->data_tambahan;
        @endphp

        @if($kode == '145.1')
            <p>Benar-benar berdomisili di alamat tersebut di atas dan merupakan penduduk yang berdomisili di wilayah Kelurahan Kuin Selatan.</p>
            <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{ $keperluan }}</strong>.</p>
        @elseif($kode == '312.1')
            <p>Yang bersangkutan di atas benar-benar adalah warga yang kurang mampu/miskin di Kelurahan Kuin Selatan dan layak mendapat bantuan sosial.</p>
            <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{ $keperluan }}</strong>.</p>
        @elseif($kode == '470')
            <p>Orang tersebut di atas benar-benar berdomisili di alamat yang tertera dan merupakan penduduk Kelurahan Kuin Selatan.</p>
            <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{ $keperluan }}</strong>.</p>
        @elseif($kode == '470.1')
            <p>Yang bersangkutan sampai dengan dikeluarkannya surat keterangan ini <strong>BELUM PERNAH MENIKAH</strong> dan belum terikat dalam perkawinan dengan orang lain.</p>
            <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{ $keperluan }}</strong>.</p>
        @else
            <p>{{ $keperluan }}</p>
        @endif

        <p>Demikian surat keterangan ini kami buat dengan sebenar-benarnya agar dapat dipergunakan untuk keperluan yang dimaksud.</p>
    </div>

    <!-- Footer & Tanda Tangan -->
    <div class="signature">
        <p>Kuin Selatan, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
        <p>a/n Lurah Kuin Selatan</p>
        
        <!-- Barcode Tanda Tangan -->
        <div class="barcode-signature">
            @if(file_exists(public_path('assets/img/barcode-ttd/' . ($surat->lurah->barcode_filename ?? 'default-barcode.png'))))
                <img src="{{ asset('assets/img/barcode-ttd/' . ($surat->lurah->barcode_filename ?? 'default-barcode.png')) }}" alt="Tanda Tangan Digital">
            @else
                {{-- Fallback jika barcode tidak ada --}}
                <div class="signature-space"></div>
            @endif
        </div>
        
        <p><strong>({{ $surat->lurah->name ?? 'Mujiono S. Pd' }})</strong></p>
        @if($surat->lurah && $surat->lurah->nip)
            <p>NIP. {{ $surat->lurah->nip }}</p>
        @endif
    </div>

    <!-- Auto Print -->
    <script type="text/javascript">
        // Auto print ketika halaman dimuat
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
