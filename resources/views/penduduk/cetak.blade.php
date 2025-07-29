<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Penduduk - SIPADES</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
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
        }
        .header p {
            margin: 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        .no {
            text-align: center;
            width: 30px;
        }
        .nik {
            width: 120px;
        }
        .nama {
            width: 150px;
        }
        .ttl {
            width: 130px;
        }
        .jk {
            width: 50px;
            text-align: center;
        }
        .alamat {
            width: 180px;
        }
        .pekerjaan {
            width: 100px;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
        }
        @media print {
            body { margin: 10px; }
            .header { page-break-inside: avoid; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SIPADES</h1>
        <h2>DATA PENDUDUK</h2>
        <p>Sistem Informasi Pelayanan Administrasi Desa</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="no">No</th>
                <th class="nik">NIK</th>
                <th class="nama">Nama Lengkap</th>
                <th class="ttl">Tempat, Tanggal Lahir</th>
                <th class="jk">L/P</th>
                <th class="alamat">Alamat</th>
                <th class="pekerjaan">Pekerjaan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penduduk as $index => $item)
            <tr>
                <td class="no">{{ $index + 1 }}</td>
                <td class="nik">{{ $item->nik ?? 'N/A' }}</td>
                <td class="nama">{{ $item->nama_lengkap ?? 'N/A' }}</td>
                <td class="ttl">
                    {{ ($item->tempat_lahir ?? 'N/A') . ', ' . 
                       ($item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->format('d-m-Y') : 'N/A') }}
                </td>
                <td class="jk">{{ $item->jenis_kelamin == 'Laki-laki' ? 'L' : ($item->jenis_kelamin == 'Perempuan' ? 'P' : 'N/A') }}</td>
                <td class="alamat">{{ Str::limit($item->alamat ?? 'N/A', 50) }}</td>
                <td class="pekerjaan">{{ $item->pekerjaan ?? 'N/A' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px;">
                    Tidak ada data penduduk
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y, H:i:s') }}</p>
        <p>Total Data: {{ count($penduduk) }} orang</p>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
