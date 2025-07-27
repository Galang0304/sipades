<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $surat->jenis_surat->nama_surat }} - {{ $surat->penduduk->nama_lengkap ?? $surat->user->name }}</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
            margin: 0;
            padding: 0;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 20px;
        }
        
        .header h1, .header h2 {
            font-weight: bold;
            margin: 5px 0;
            text-transform: uppercase;
        }
        
        .header h1 { font-size: 18pt; }
        .header h2 { font-size: 16pt; }
        .header p { font-size: 11pt; margin: 2px 0; }
        
        .letter-number {
            text-align: center;
            margin: 20px 0;
            text-decoration: underline;
            font-weight: bold;
            font-size: 14pt;
        }
        
        .content {
            margin: 30px 0;
            text-align: justify;
        }
        
        .content p { margin: 15px 0; }
        
        .data-table {
            margin: 20px 0;
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table td {
            padding: 5px 0;
            vertical-align: top;
            border: none;
        }
        
        .data-table .label {
            width: 200px;
            font-weight: bold;
        }
        
        .data-table .separator {
            width: 20px;
            text-align: center;
        }
        
        .signature {
            margin-top: 50px;
            width: 100%;
        }
        
        .signature-right {
            float: right;
            width: 300px;
            text-align: center;
        }
        
        .signature-space {
            height: 80px;
            margin: 20px 0;
        }
        
        .footer {
            margin-top: 100px;
            font-size: 10pt;
            text-align: center;
            font-style: italic;
            clear: both;
        }
        
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
            .signature-right { page-break-inside: avoid; }
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

    <div class="header">
        <h1>PEMERINTAH KABUPATEN GALAN</h1>
        <h2>KECAMATAN GALAN</h2>
        <h2>DESA GALAN</h2>
        <p>Alamat: Jl. Raya Desa Galan No. 123, Kec. Galan, Kab. Galan</p>
        <p>Telepon: (021) 12345678 | Email: desagalan@gmail.com | Kode Pos: 12345</p>
    </div>

    <div class="letter-number">
        {{ $surat->jenis_surat->nama_surat }}
        <br>
        Nomor: {{ $surat->jenis_surat->kode_surat }}/{{ str_pad($surat->id, 3, '0', STR_PAD_LEFT) }}/{{ date('Y') }}
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Lurah Desa Galan, Kecamatan Galan, Kabupaten Galan, dengan ini menerangkan bahwa:</p>

        <table class="data-table">
            <tr>
                <td class="label">Nama</td>
                <td class="separator">:</td>
                <td>{{ $surat->penduduk->nama_lengkap ?? $surat->user->name }}</td>
            </tr>
            <tr>
                <td class="label">NIK</td>
                <td class="separator">:</td>
                <td>{{ $surat->nik }}</td>
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

        @php
            $kode = $surat->jenis_surat->kode_surat;
            $keperluan = $surat->keperluan;
            $data = $surat->data_tambahan;
        @endphp

        @if($kode == '145.1')
            {{-- Surat Keterangan Domisili --}}
            <p>Benar-benar berdomisili di alamat tersebut di atas dan merupakan penduduk yang berdomisili di wilayah Desa Galan.</p>
            <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{ $keperluan }}</strong>.</p>

        @elseif($kode == '312.1')
            {{-- Surat Keterangan Tidak Mampu --}}
            <p>Yang bersangkutan di atas benar-benar adalah warga yang kurang mampu/miskin di Desa Galan dan layak mendapat bantuan sosial.</p>
            <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{ $keperluan }}</strong>.</p>

        @elseif($kode == '470')
            {{-- Surat Domisili --}}
            <p>Orang tersebut di atas benar-benar berdomisili di alamat yang tertera dan merupakan penduduk Desa Galan.</p>
            <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{ $keperluan }}</strong>.</p>

        @elseif($kode == '470.1')
            {{-- Surat Keterangan Belum Menikah --}}
            <p>Yang bersangkutan sampai dengan dikeluarkannya surat keterangan ini <strong>BELUM PERNAH MENIKAH</strong> dan belum terikat dalam perkawinan dengan orang lain.</p>
            <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{ $keperluan }}</strong>.</p>

        @elseif($kode == '474')
            {{-- Surat Pindah --}}
            <p>Yang bersangkutan akan pindah alamat dari alamat sekarang ke alamat baru sebagai berikut:</p>
            @if($data && isset($data['alamat_baru']))
                <table class="data-table">
                    <tr>
                        <td class="label">Alamat Baru</td>
                        <td class="separator">:</td>
                        <td>{{ $data['alamat_baru'] }}</td>
                    </tr>
                    @if(isset($data['jumlah_keluarga']))
                    <tr>
                        <td class="label">Jumlah Keluarga yang Pindah</td>
                        <td class="separator">:</td>
                        <td>{{ $data['jumlah_keluarga'] }} orang</td>
                    </tr>
                    @endif
                </table>
            @endif
            <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{ $keperluan }}</strong>.</p>

        @elseif($kode == '474.3')
            {{-- Surat Kematian --}}
            <p>Yang bersangkutan telah meninggal dunia pada:</p>
            @if($data)
                <table class="data-table">
                    @if(isset($data['hari_meninggal']))
                    <tr>
                        <td class="label">Hari</td>
                        <td class="separator">:</td>
                        <td>{{ $data['hari_meninggal'] }}</td>
                    </tr>
                    @endif
                    @if(isset($data['tanggal_meninggal']))
                    <tr>
                        <td class="label">Tanggal</td>
                        <td class="separator">:</td>
                        <td>{{ \Carbon\Carbon::parse($data['tanggal_meninggal'])->format('d F Y') }}</td>
                    </tr>
                    @endif
                    @if(isset($data['sebab_kematian']))
                    <tr>
                        <td class="label">Sebab Kematian</td>
                        <td class="separator">:</td>
                        <td>{{ $data['sebab_kematian'] }}</td>
                    </tr>
                    @endif
                    @if(isset($data['alamat_meninggal']))
                    <tr>
                        <td class="label">Tempat Meninggal</td>
                        <td class="separator">:</td>
                        <td>{{ $data['alamat_meninggal'] }}</td>
                    </tr>
                    @endif
                </table>
            @endif
            <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{ $keperluan }}</strong>.</p>

        @elseif($kode == '503')
            {{-- Surat Izin Usaha --}}
            <p>Yang bersangkutan akan melakukan kegiatan usaha dengan keterangan sebagai berikut:</p>
            @if($data)
                <table class="data-table">
                    @if(isset($data['nama_usaha']))
                    <tr>
                        <td class="label">Nama Usaha</td>
                        <td class="separator">:</td>
                        <td>{{ $data['nama_usaha'] }}</td>
                    </tr>
                    @endif
                    @if(isset($data['jenis_usaha']))
                    <tr>
                        <td class="label">Jenis Usaha</td>
                        <td class="separator">:</td>
                        <td>{{ $data['jenis_usaha'] }}</td>
                    </tr>
                    @endif
                    @if(isset($data['alamat_usaha']))
                    <tr>
                        <td class="label">Alamat Usaha</td>
                        <td class="separator">:</td>
                        <td>{{ $data['alamat_usaha'] }}</td>
                    </tr>
                    @endif
                    @if(isset($data['keterangan_usaha']))
                    <tr>
                        <td class="label">Keterangan</td>
                        <td class="separator">:</td>
                        <td>{{ $data['keterangan_usaha'] }}</td>
                    </tr>
                    @endif
                </table>
            @endif
            <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{ $keperluan }}</strong>.</p>

        @else
            {{-- Surat Keterangan Umum --}}
            <p>{{ $keperluan }}</p>
        @endif

        <p style="margin-top: 30px;">Demikian surat keterangan ini kami buat dengan sebenar-benarnya agar dapat dipergunakan untuk keperluan yang dimaksud.</p>
    </div>

    <div class="signature">
        <div class="signature-right">
            <p>Galan, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            <p><strong>Lurah Desa Galan</strong></p>
            <div class="signature-space"></div>
            <p><strong><u>{{ $surat->lurah->name ?? 'NAMA LURAH' }}</u></strong></p>
            <p>NIP. {{ $surat->lurah->nip ?? '123456789012345678' }}</p>
        </div>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i:s') }}</p>
        <p>Surat ini berlaku dan sah dengan tanda tangan dan stempel resmi</p>
    </div>

    <script>
        // Optional: Auto print when page loads
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
