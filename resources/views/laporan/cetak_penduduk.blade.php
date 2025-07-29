<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Penduduk - SIPADES</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 15px;
            font-size: 10px;
            line-height: 1.2;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #28a745;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 16px;
            color: #28a745;
            font-weight: bold;
        }
        .header h2 {
            margin: 3px 0;
            font-size: 14px;
            color: #333;
            font-weight: bold;
        }
        .header p {
            margin: 1px 0;
            font-size: 9px;
            color: #666;
        }
        .meta-info {
            background: #f8f9fa;
            padding: 8px;
            border-radius: 3px;
            margin-bottom: 10px;
            border-left: 3px solid #28a745;
        }
        .meta-info table {
            width: 100%;
            border: none;
        }
        .meta-info td {
            padding: 2px 0;
            border: none;
            font-size: 9px;
        }
        .meta-info strong {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th {
            background: #28a745;
            color: white;
            padding: 4px 2px;
            text-align: center;
            font-weight: bold;
            font-size: 8px;
        }
        td {
            padding: 3px 2px;
            text-align: left;
            font-size: 8px;
        }
        .text-center {
            text-align: center;
        }
        .status-detail {
            font-size: 7px;
            color: #666;
        }
        .signature-area {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            align-items: flex-start;
        }
        .signature-section {
            text-align: center;
            width: 250px;
        }
        .barcode-signature {
            text-align: center;
            margin: 10px 0;
        }
        .barcode-signature img {
            width: 100px;
            height: auto;
        }
        .signature-space {
            height: 60px;
            border: 1px dashed #ccc;
            width: 120px;
            margin: 10px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 7px;
            color: #999;
        }
        .footer-info {
            margin-top: 15px;
            font-size: 7px;
            text-align: center;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        @media print {
            body { 
                margin: 0; 
                padding: 10px; 
                font-size: 9px;
            }
            .no-print { display: none; }
            @page {
                size: A4;
                margin: 1cm;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SIPADES - Sistem Informasi Pelayanan Administrasi Desa</h1>
        <h2>LAPORAN DATA PENDUDUK</h2>
        <p>Pemerintah Desa/Kelurahan</p>
        <p>Dicetak pada: {{ now()->format('d F Y, H:i:s') }} WIB</p>
    </div>

    <div class="meta-info">
        <table>
            <tr>
                <td width="20%"><strong>Periode Laporan</strong></td>
                <td width="2%">:</td>
                <td>{{ now()->format('F Y') }}</td>
                <td width="20%"><strong>Total Data</strong></td>
                <td width="2%">:</td>
                <td><strong>{{ $total_penduduk }} orang</strong></td>
            </tr>
            <tr>
                <td><strong>Filter Jenis Kelamin</strong></td>
                <td>:</td>
                <td>{{ request('jenis_kelamin') ?: 'Semua Jenis Kelamin' }}</td>
                <td><strong>Status Laporan</strong></td>
                <td>:</td>
                <td><strong style="color: #28a745;">Aktif & Terverifikasi</strong></td>
            </tr>
            <tr>
                <td><strong>Filter RT/RW</strong></td>
                <td>:</td>
                <td>
                    @if(request('rt') || request('rw'))
                        RT {{ request('rt') ?: 'Semua' }} / RW {{ request('rw') ?: 'Semua' }}
                    @else
                        Semua RT/RW
                    @endif
                </td>
                <td><strong>Operator</strong></td>
                <td>:</td>
                <td>{{ auth()->user()->name ?? 'System Administrator' }}</td>
            </tr>
            <tr>
                <td><strong>Filter Agama</strong></td>
                <td>:</td>
                <td>{{ request('agama') ?: 'Semua Agama' }}</td>
                <td><strong>Validasi Data</strong></td>
                <td>:</td>
                <td style="color: #28a745;"><strong>✓ Data Valid & Update</strong></td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="12%">NIK</th>
                <th width="18%">Nama Lengkap</th>
                <th width="6%">JK</th>
                <th width="14%">Tempat, Tgl Lahir</th>
                <th width="18%">Alamat</th>
                <th width="5%">RT</th>
                <th width="5%">RW</th>
                <th width="8%">Agama</th>
                <th width="10%">Status & Pekerjaan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penduduk as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->nik ?? 'Belum ada NIK' }}</td>
                <td>{{ $item->nama_lengkap ?? 'Nama tidak tersedia' }}</td>
                <td class="text-center">{{ $item->jenis_kelamin == 'Laki-laki' ? 'L' : ($item->jenis_kelamin == 'Perempuan' ? 'P' : '-') }}</td>
                <td>{{ ($item->tempat_lahir ?? 'N/A') }}, {{ $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') : 'N/A' }}</td>
                <td>{{ Str::limit($item->alamat ?? 'Alamat belum lengkap', 40) }}</td>
                <td class="text-center">{{ $item->rt ?? '-' }}</td>
                <td class="text-center">{{ $item->rw ?? '-' }}</td>
                <td class="text-center">{{ $item->agama ?? 'N/A' }}</td>
                <td>
                    <div><strong>{{ Str::limit($item->status_perkawinan ?? 'N/A', 12) }}</strong></div>
                    <div class="status-detail">{{ Str::limit($item->pekerjaan ?? 'Belum terdata', 15) }}</div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align: center; padding: 30px; color: #999;">
                    <strong>Tidak ada data penduduk yang sesuai dengan filter</strong>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature-area">
        <div class="signature-section">
            <p style="margin-bottom: 8px; font-size: 9px;">Kuin Selatan, {{ now()->format('d F Y') }}</p>
            <p style="font-size: 9px;"><strong>a/n LURAH KUIN SELATAN</strong></p>
            
            <!-- Barcode Tanda Tangan -->
            <div class="barcode-signature">
                @if(file_exists(public_path('assets/img/barcode-ttd/default-barcode.png')))
                    <img src="{{ asset('assets/img/barcode-ttd/default-barcode.png') }}" alt="Tanda Tangan Digital">
                @else
                    {{-- Fallback jika barcode tidak ada --}}
                    <div class="signature-space">Tanda Tangan & Stempel</div>
                @endif
            </div>
            
            <p style="margin-top: 5px;">
                <strong style="font-size: 8px;">({{ $lurah_name ?? 'Mujiono S. Pd' }})</strong><br>
                @if(isset($lurah_nip) && $lurah_nip)
                    <span style="font-size: 7px;">NIP. {{ $lurah_nip }}</span>
                @endif
            </p>
        </div>
    </div>

    <div class="footer-info">
        <p style="font-size: 7px;"><strong>SIPADES - Sistem Informasi Pelayanan Administrasi Desa</strong></p>
        <p style="font-size: 6px;">Digenerate: {{ now()->format('d/m/Y, H:i') }} WIB | Untuk verifikasi hubungi kantor desa/kelurahan</p>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
