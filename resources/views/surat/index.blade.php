@extends('layouts.app')

@section('title', 'Data Surat')
@section('page-title', 'Data Surat')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Surat</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Pengajuan Surat</h3>
                <div class="card-tools">
                    <a href="{{ route('surat.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Ajukan Surat
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="surat-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal Pengajuan</th>
                                <th>Jenis Surat</th>
                                @role('admin|lurah|petugas')
                                <th>Nama Pemohon</th>
                                @endrole
                                <th>NIK</th>
                                <th>Keperluan</th>
                                <th>Status</th>
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
    var columns = [
        {data: 'tanggal_pengajuan', name: 'tanggal_pengajuan'},
        {data: 'jenis_surat.nama_surat', name: 'jenis_surat.nama_surat'},
        @role('admin|lurah|petugas')
        {data: 'user.name', name: 'user.name'},
        @endrole
        {data: 'nik', name: 'nik'},
        {data: 'keperluan', name: 'keperluan'},
        {data: 'status_badge', name: 'status', orderable: false, searchable: false},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ];

    // Destroy existing DataTable if it exists
    if ($.fn.DataTable.isDataTable('#surat-table')) {
        $('#surat-table').DataTable().destroy();
    }

    var table = $('#surat-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("surat.data") }}',
        columns: columns,
        order: [[0, 'desc']],
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
    $('#surat-table').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data surat akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/surat/' + id,
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

    // Handle approve by petugas
    $('#surat-table').on('click', '.approve-petugas-btn', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Proses Surat',
            text: 'Anda akan memproses surat ini ke tahap selanjutnya',
            input: 'textarea',
            inputPlaceholder: 'Keterangan (opsional)',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Proses',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/surat/' + id + '/approve-petugas',
                    type: 'POST',
                    data: {
                        keterangan: result.value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan saat memproses surat.', 'error');
                    }
                });
            }
        });
    });

    // Handle approve by lurah
    $('#surat-table').on('click', '.approve-lurah-btn', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Setujui Surat',
            text: 'Anda akan menyetujui dan menyelesaikan surat ini',
            input: 'textarea',
            inputPlaceholder: 'Keterangan (opsional)',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Setujui',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/surat/' + id + '/approve-lurah',
                    type: 'POST',
                    data: {
                        keterangan: result.value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menyetujui surat.', 'error');
                    }
                });
            }
        });
    });

    // Handle reject
    $('#surat-table').on('click', '.reject-btn', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Tolak Surat',
            text: 'Berikan alasan penolakan',
            input: 'textarea',
            inputPlaceholder: 'Alasan penolakan (wajib diisi)',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Tolak',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value) {
                    return 'Alasan penolakan harus diisi!'
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/surat/' + id + '/reject',
                    type: 'POST',
                    data: {
                        keterangan: result.value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menolak surat.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
