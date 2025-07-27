@extends('layouts.app')

@section('title', 'Data Pengaduan')
@section('page-title', 'Data Pengaduan')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Pengaduan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Pengaduan Masyarakat</h3>
                @role('admin|member')
                <div class="card-tools">
                    <a href="{{ route('pengaduan.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Buat Pengaduan
                    </a>
                </div>
                @endrole
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="pengaduan-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Pelapor</th>
                                <th>NIK</th>
                                <th>Isi Laporan</th>
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

<!-- Modal Tanggapan -->
<div class="modal fade" id="respondModal" tabindex="-1" aria-labelledby="respondModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="respondModalLabel">Tanggapi Pengaduan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="respondForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tanggapan">Tanggapan</label>
                        <textarea class="form-control" id="tanggapan" name="tanggapan" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Tanggapan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Destroy existing DataTable if it exists
    if ($.fn.DataTable.isDataTable('#pengaduan-table')) {
        $('#pengaduan-table').DataTable().destroy();
    }
    
    var table = $('#pengaduan-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("pengaduan.data") }}',
        columns: [
            {data: 'tanggal_pengaduan', name: 'tanggal_pengaduan'},
            {data: 'user.name', name: 'user.name'},
            {data: 'nik', name: 'nik'},
            {data: 'isi_laporan', name: 'isi_laporan'},
            {data: 'status_badge', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
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

    var currentPengaduanId = null;

    // Handle respond button click
    $('#pengaduan-table').on('click', '.respond-btn', function() {
        currentPengaduanId = $(this).data('id');
        $('#respondModal').modal('show');
    });

    // Handle respond form submit
    $('#respondForm').on('submit', function(e) {
        e.preventDefault();
        
        var tanggapan = $('#tanggapan').val();
        
        $.ajax({
            url: '/pengaduan/' + currentPengaduanId + '/respond',
            type: 'POST',
            data: {
                tanggapan: tanggapan
            },
            success: function(response) {
                if (response.success) {
                    $('#respondModal').modal('hide');
                    $('#tanggapan').val('');
                    Swal.fire('Berhasil!', response.message, 'success');
                    table.ajax.reload();
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error!', 'Terjadi kesalahan saat mengirim tanggapan.', 'error');
            }
        });
    });

    // Handle finish button click
    $('#pengaduan-table').on('click', '.finish-btn', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Selesaikan Pengaduan?',
            text: "Pengaduan akan ditandai sebagai selesai.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Selesaikan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/pengaduan/' + id + '/finish',
                    type: 'POST',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menyelesaikan pengaduan.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
