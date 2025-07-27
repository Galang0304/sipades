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
});
</script>
@endpush
