<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Surat - SIPADES</title>
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
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #000;
        }
        
        .header h2 {
            font-size: 14pt;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
        }
        
        .header h3 {
            font-size: 12pt;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
        }
        
        .header h5 {
            font-size: 10pt;
            margin: 2px 0;
            font-weight: normal;
        }
        
        .title {
            text-align: center;
            margin: 15px 0;
        }
        
        .title h4 {
            font-size: 12pt;
            font-weight: bold;
            margin: 5px 0;
            text-transform: uppercase;
        }
        
        .filter-info {
            margin: 15px 0;
            padding: 10px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        
        .filter-info h5 {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .filter-info p {
            margin: 2px 0;
            font-size: 9pt;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .data-table th,
        .data-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
            font-size: 9pt;
        }
        
        .data-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }
        
        .data-table .text-center {
            text-align: center;
        }
        
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        
        .footer p {
            margin: 2px 0;
            font-size: 10pt;
        }
        
        @media print {
            body { 
                -webkit-print-color-adjust: exact;
                font-size: 9pt !important;
            }
            .no-print { display: none; }
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
    <button class="print-btn no-print" onclick="window.print()">Cetak Laporan</button>

    <!-- Header Resmi Kelurahan -->
    <div class="header">
        <h2>PEMERINTAH KOTA BANJARMASIN</h2>
        <h3>KECAMATAN BANJARMASIN BARAT<br>KELURAHAN KUIN SELATAN</h3>
        <h5>Alamat : JL. SIMPANG KUIN SELATAN RT.22 NO.01 KODE POS : 70128</h5>
    </div>
    
    <!-- Judul Laporan -->
    <div class="title">
        <h4>LAPORAN DATA PENGAJUAN SURAT</h4>
    </div>

    <!-- Info Filter -->
    <div class="filter-info">
        <h5>Kriteria Laporan:</h5>
        <p><strong>Jenis Surat:</strong> 
            @if(request('jenis_surat_id'))
                {{ $jenisSurat->find(request('jenis_surat_id'))->nama_surat }}
            @else
                Semua Jenis
            @endif
        </p>
        <p><strong>Status:</strong> 
            @if(request('status'))
                {{ ucfirst(request('status')) }}
            @else
                Semua Status
            @endif
        </p>
        <p><strong>Periode:</strong> 
            @if(request('tanggal_mulai') && request('tanggal_selesai'))
                {{ date('d/m/Y', strtotime(request('tanggal_mulai'))) }} - {{ date('d/m/Y', strtotime(request('tanggal_selesai'))) }}
            @elseif(request('bulan') && request('tahun'))
                {{ date('F Y', mktime(0, 0, 0, request('bulan'), 1, request('tahun'))) }}
            @elseif(request('tahun'))
                Tahun {{ request('tahun') }}
            @else
                Semua Periode
            @endif
        </p>
        <p><strong>Total Data:</strong> {{ count($surat) }} pengajuan</p>
        <p><strong>Tanggal Cetak:</strong> {{ date('d F Y, H:i:s') }}</p>
    </div>

    <!-- Tabel Data -->
    @if(count($surat) > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="12%">Tanggal</th>
                    <th width="18%">Nama Pemohon</th>
                    <th width="15%">NIK</th>
                    <th width="20%">Jenis Surat</th>
                    <th width="20%">Keperluan</th>
                    <th width="10%">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($surat as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>{{ $item->penduduk->nama_lengkap ?? $item->user->name }}</td>
                    <td class="text-center">{{ $item->nik }}</td>
                    <td>{{ $item->jenis_surat->nama_surat }}</td>
                    <td>{{ $item->keperluan }}</td>
                    <td class="text-center">{{ ucfirst($item->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary -->
        <div style="margin-top: 20px; padding: 10px; border: 1px solid #000;">
            <h5 style="margin-bottom: 10px; font-size: 11pt;">Ringkasan Data:</h5>
            @php
                $statusCounts = $surat->groupBy('status')->map->count();
            @endphp
            <div style="display: flex; justify-content: space-between;">
                <div>
                    <p><strong>Pending:</strong> {{ $statusCounts['pending'] ?? 0 }} surat</p>
                    <p><strong>Disetujui:</strong> {{ $statusCounts['disetujui'] ?? 0 }} surat</p>
                </div>
                <div>
                    <p><strong>Ditolak:</strong> {{ $statusCounts['ditolak'] ?? 0 }} surat</p>
                    <p><strong>Selesai:</strong> {{ $statusCounts['selesai'] ?? 0 }} surat</p>
                </div>
                <div>
                    <p><strong>Total Keseluruhan:</strong> {{ count($surat) }} surat</p>
                </div>
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 50px; border: 1px solid #ddd;">
            <h4>Tidak ada data untuk kriteria yang dipilih</h4>
        </div>
    @endif

    <!-- Footer & Tanda Tangan -->
    <div class="footer">
        <p>Kuin Selatan, {{ date('d F Y') }}</p>
        <p>Mengetahui,</p>
        <br><br><br>
        <p><strong>Lurah Kuin Selatan</strong></p>
        <p><strong>Mujiono S. Pd</strong></p>
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
