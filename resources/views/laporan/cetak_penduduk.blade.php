<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Penduduk - KUINSEL</title>
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
            font-size: 10px;
        }
        td {
            padding: 4px;
            text-align: left;
            font-size: 10px;
        }
        .text-center {
            text-align: center;
        }
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
        <h2>LAPORAN DATA PENDUDUK</h2>
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="15%"><strong>Filter Jenis Kelamin</strong></td>
                <td width="2%">:</td>
                <td>{{ request('jenis_kelamin') ?: 'Semua' }}</td>
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
            </tr>
            <tr>
                <td><strong>Filter Agama</strong></td>
                <td>:</td>
                <td>{{ request('agama') ?: 'Semua Agama' }}</td>
            </tr>
            <tr>
                <td><strong>Total Data</strong></td>
                <td>:</td>
                <td>{{ $total_penduduk }} orang</td>
            </tr>
        </table>
    </div>

    <div class="statistik">
        <div class="stat-box">
            <div class="stat-number">{{ $total_penduduk }}</div>
            <div class="stat-label">Total Penduduk</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $total_laki }}</div>
            <div class="stat-label">Laki-laki</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $total_perempuan }}</div>
            <div class="stat-label">Perempuan</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="12%">NIK</th>
                <th width="15%">Nama</th>
                <th width="8%">JK</th>
                <th width="15%">Tempat, Tgl Lahir</th>
                <th width="20%">Alamat</th>
                <th width="6%">RT</th>
                <th width="6%">RW</th>
                <th width="8%">Agama</th>
                <th width="6%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penduduk as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->nik }}</td>
                <td>{{ $item->nama_lengkap }}</td>
                <td class="text-center">{{ $item->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                <td>{{ $item->tempat_lahir }}, {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}</td>
                <td>{{ $item->alamat }}</td>
                <td class="text-center">{{ $item->rt }}</td>
                <td class="text-center">{{ $item->rw }}</td>
                <td class="text-center">{{ $item->agama }}</td>
                <td class="text-center">{{ Str::limit($item->status_perkawinan, 8) }}</td>
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
