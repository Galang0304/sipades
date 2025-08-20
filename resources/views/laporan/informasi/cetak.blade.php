<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Informasi</title>
    <style>
    body { font-family: Arial, sans-serif; margin: 15px; font-size: 12px; }
        h3 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background: #f0f0f0; text-align: center; font-weight: bold; }
        .center { text-align: center; }
        .signature-section {
            margin-top: 30px;
            text-align: right;
        }
        .signature-content {
            display: inline-block;
            text-align: center;
            min-width: 200px;
        }
        .barcode-img {
            max-width: 150px;
            height: auto;
            margin: 10px 0;
        }
        .signature-line {
            margin-top: 60px;
            border-bottom: 1px solid #000;
            width: 200px;
            margin-left: auto;
        }
        @media print {
            @page { size: A4; margin: 1cm; }
            body { margin: 0; font-size: 11px; }
        }
    </style>
</head>
<body>
    <h3>Laporan Informasi Kelurahan</h3>
    
    <table>
        <tr>
            <th width="10%">No</th>
            <th width="25%">Tanggal</th>
            <th width="50%">Judul</th>
            <th width="15%">Status</th>
        </tr>
        @forelse($informasi as $key => $item)
        <tr>
            <td class="center">{{ $key + 1 }}</td>
            <td>{{ $item->created_at->format('d/m/Y') }}</td>
            <td>{{ $item->judul }}</td>
            <td class="center">{{ $item->is_published ? 'Published' : 'Draft' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="center">Tidak ada data</td>
        </tr>
        @endforelse
    </table>
    
    <div class="signature-section">
        <div class="signature-content">
            <p>Banjarmasin, {{ date('d F Y') }}</p>
            <p>Lurah Kuin Selatan</p>
            
            @if(file_exists(public_path('assets/img/barcode-lurah.png')))
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/barcode-lurah.png'))) }}" alt="Tanda Tangan Digital" class="barcode-img">
                <p style="font-size: 10px;">Tanda Tangan Digital</p>
            @else
                <div style="height: 80px;"></div>
            @endif
            
            <div class="signature-line"></div>
            <p style="margin-top: 5px; font-weight: bold;">{{ auth()->user()->name }}</p>
            <p style="font-size: 10px; font-style: italic;">Lurah Kuin Selatan</p>
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>
