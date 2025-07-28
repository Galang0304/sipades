@extends('layouts.app')

@section('title', 'Data Penduduk')
@section('page-title', 'Data Penduduk')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Penduduk</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Penduduk Kelurahan Kuin Selatan</h3>
                <div class="card-tools">
                    <a href="{{ route('penduduk.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Penduduk
                    </a>
                    <button onclick="printPenduduk()" class="btn btn-success btn-sm ml-2">
                        <i class="fas fa-print"></i> Cetak Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="penduduk-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th>Tempat, Tanggal Lahir</th>
                                <th>Umur</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>Pekerjaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Destroy existing DataTable if it exists
    if ($.fn.DataTable.isDataTable('#penduduk-table')) {
        $('#penduduk-table').DataTable().destroy();
    }
    
    var table = $('#penduduk-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("penduduk.data") }}',
        columns: [
            {data: 'nik', name: 'nik'},
            {data: 'nama_lengkap', name: 'nama_lengkap'},
            {
                data: 'tempat_lahir', 
                name: 'tempat_lahir',
                render: function(data, type, row) {
                    return data + ', ' + row.tanggal_lahir;
                }
            },
            {data: 'umur', name: 'umur', orderable: false, searchable: false},
            {data: 'jenis_kelamin', name: 'jenis_kelamin'},
            {data: 'alamat', name: 'alamat'},
            {data: 'pekerjaan', name: 'pekerjaan'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        language: {
            processing: "Memproses...",
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 hingga 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ total data)",
            loadingRecords: "Memuat data...",
            zeroRecords: "Tidak ada data yang ditemukan",
            emptyTable: "Tidak ada data tersedia",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        }
    });

    // Handle delete button click
    $('#penduduk-table').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data penduduk akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/penduduk/' + id,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data.', 'error');
                    }
                });
            }
        });
    });
    
    // Fungsi cetak data penduduk
    window.printPenduduk = function() {
        const printWindow = window.open('', '_blank');
        const table = $('#penduduk-table').DataTable();
        const data = table.rows().data();
        
        let html = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Data Penduduk - KUINSEL</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    .header { text-align: center; margin-bottom: 30px; }
                    .header h1 { margin: 0; font-size: 18px; }
                    .header h2 { margin: 5px 0; font-size: 16px; }
                    .header p { margin: 5px 0; font-size: 12px; }
                    table { width: 100%; border-collapse: collapse; font-size: 11px; }
                    th, td { border: 1px solid #000; padding: 5px; text-align: left; }
                    th { background-color: #f0f0f0; font-weight: bold; }
                    .no { text-align: center; width: 30px; }
                    .print-date { text-align: right; margin-top: 20px; font-size: 10px; }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1>KELURAHAN KUIN SELATAN</h1>
                    <h2>DATA PENDUDUK</h2>
                    <p>JL. SIMPANG KUIN SELATAN RT.22 NO.01, BANJARMASIN BARAT</p>
                    <p>KOTA BANJARMASIN, KALIMANTAN SELATAN 70128</p>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th class="no">No</th>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>TTL</th>
                            <th>Umur</th>
                            <th>JK</th>
                            <th>Alamat</th>
                            <th>Pekerjaan</th>
                        </tr>
                    </thead>
                    <tbody>`;
        
        data.each(function(row, index) {
            html += `
                <tr>
                    <td class="no">${index + 1}</td>
                    <td>${row[0]}</td>
                    <td>${row[1]}</td>
                    <td>${row[2]}</td>
                    <td>${row[3]}</td>
                    <td>${row[4]}</td>
                    <td>${row[5]}</td>
                    <td>${row[6]}</td>
                </tr>`;
        });
        
        html += `
                    </tbody>
                </table>
                <div class="print-date">
                    Dicetak pada: ${new Date().toLocaleDateString('id-ID')} ${new Date().toLocaleTimeString('id-ID')}
                </div>
            </body>
            </html>`;
        
        printWindow.document.write(html);
        printWindow.document.close();
        printWindow.print();
    };
});
</script>
@endpush
