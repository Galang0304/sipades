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
        .statistik {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
            text-align: center;
        }
        .stat-box {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            min-width: 120px;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
        }
        .stat-label {
            font-size: 11px;
            color: #666;
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
        .footer {
            margin-top: 40px;
            text-align: right;
        }
        .footer p {
            margin: 5px 0;
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

    <div class="statistik">
        <div class="stat-box">
            <div class="stat-number">{{ $total_pengajuan }}</div>
            <div class="stat-label">Total Pengajuan</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $pengajuan_pending }}</div>
            <div class="stat-label">Pending</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $pengajuan_disetujui }}</div>
            <div class="stat-label">Disetujui</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $pengajuan_ditolak }}</div>
            <div class="stat-label">Ditolak</div>
        </div>
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
        <p><strong>{{ auth()->user()->name }}</strong></p>
        <p>{{ auth()->user()->getRoleNames()->first() ?? 'Petugas' }}</p>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
