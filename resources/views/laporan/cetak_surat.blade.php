<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengajuan Surat - KUINSEL</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #28a745;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            color: #333;
        }
        .header p {
            margin: 0;
            font-size: 12px;
        }
        .info {
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 3px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th {
            background-color: #f8f9fa;
            padding: 8px;
            text-align: center;
            font-weight: bold;
        }
        td {
            padding: 6px;
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            color: white;
        }
        .badge-warning { background-color: #ffc107; color: #000; }
        .badge-success { background-color: #28a745; }
        .badge-danger { background-color: #dc3545; }
        .barcode-signature {
            text-align: center;
            margin: 15px 0;
        }
        .barcode-signature img {
            width: 80px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .signature-space {
            height: 60px;
            border: 1px dashed #ccc;
            width: 80px;
            margin: 15px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            color: #999;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            width: 250px;
            margin-left: auto;
        }
        .footer p {
            margin: 3px 0;
            font-size: 11px;
        }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SISTEM KUINSEL</h1>
        <h2>LAPORAN PENGAJUAN SURAT</h2>
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="15%"><strong>Periode</strong></td>
                <td width="2%">:</td>
                <td>
                    @if(request('tanggal_mulai') && request('tanggal_selesai'))
                        {{ \Carbon\Carbon::parse(request('tanggal_mulai'))->format('d/m/Y') }} - 
                        {{ \Carbon\Carbon::parse(request('tanggal_selesai'))->format('d/m/Y') }}
                    @else
                        Semua Data
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Status Filter</strong></td>
                <td>:</td>
                <td>{{ request('status') ? ucfirst(request('status')) : 'Semua Status' }}</td>
            </tr>
            <tr>
                <td><strong>Total Data</strong></td>
                <td>:</td>
                <td>{{ $total_pengajuan }} pengajuan</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="10%">Tanggal</th>
                <th width="12%">NIK</th>
                <th width="18%">Nama</th>
                <th width="15%">Jenis Surat</th>
                <th width="20%">Keperluan</th>
                <th width="10%">Status</th>
                <th width="11%">Diproses Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengajuan as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $item->user->nik ?? $item->nik ?? 'NIK tidak tersedia' }}</td>
                <td>{{ $item->user->name ?? $item->nama ?? 'Nama tidak tersedia' }}</td>
                <td>{{ $item->jenisSurat->nama_surat ?? 'Jenis tidak diketahui' }}</td>
                <td>{{ \Illuminate\Support\Str::limit($item->keperluan ?? 'Tidak disebutkan', 50) }}</td>
                <td class="text-center">
                    @if($item->status == 'pending' || $item->status == 'menunggu' || $item->status == 'Menunggu')
                        <span class="badge badge-warning">Menunggu</span>
                    @elseif($item->status == 'diproses' || $item->status == 'Diproses')
                        <span class="badge" style="background-color: #17a2b8;">Diproses</span>
                    @elseif($item->status == 'approved' || $item->status == 'disetujui' || $item->status == 'selesai' || $item->status == 'Selesai')
                        <span class="badge badge-success">Selesai</span>
                    @elseif($item->status == 'rejected' || $item->status == 'ditolak' || $item->status == 'Ditolak')
                        <span class="badge badge-danger">Ditolak</span>
                    @else
                        <span class="badge" style="background-color: #6c757d;">{{ ucfirst($item->status) }}</span>
                    @endif
                </td>
                <td>
                    @if($item->lurah)
                        {{ $item->lurah->name }} (Lurah)
                    @elseif($item->petugas)
                        {{ $item->petugas->name }} (Petugas)
                    @elseif($item->diproses_user)
                        {{ $item->diproses_user->name }} (Admin)
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Kuin Selatan, {{ now()->format('d F Y') }}</p>
        <p><strong>a/n LURAH KUIN SELATAN</strong></p>
        
        <!-- Barcode Tanda Tangan -->
        <div class="barcode-signature">
            @if(file_exists(public_path('assets/img/barcode-ttd/default-barcode.png')))
                <img src="{{ asset('assets/img/barcode-ttd/default-barcode.png') }}" alt="Tanda Tangan Digital">
            @else
                {{-- Fallback jika barcode tidak ada --}}
                <div class="signature-space">Tanda Tangan & Stempel</div>
            @endif
        </div>
        
        <p><strong>({{ auth()->user()->name ?? 'Mujiono S. Pd' }})</strong></p>
        <p>{{ auth()->user()->getRoleNames()->first() ?? 'Lurah' }}</p>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
