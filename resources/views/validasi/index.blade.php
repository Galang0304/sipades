@extends('layouts.app')

@section('title', 'Validasi Surat')
@section('page-title', 'Validasi Surat')

@section('breadcrumb')
    <li class="breadcrumb-item active">Validasi Surat</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Surat Menunggu Validasi</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="validasi-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal Pengajuan</th>
                                <th>Nama Pemohon</th>
                                <th>NIK</th>
                                <th>Jenis Surat</th>
                                <th>Keperluan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Approve -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">Setujui Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="approveForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="approve_keterangan">Keterangan (Opsional)</label>
                        <textarea class="form-control" id="approve_keterangan" name="keterangan" rows="3" placeholder="Masukkan keterangan tambahan jika diperlukan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Setujui Surat</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Tolak Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="rejectForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reject_keterangan">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="reject_keterangan" name="keterangan" rows="4" required placeholder="Masukkan alasan penolakan surat"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Surat</button>
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
    if ($.fn.DataTable.isDataTable('#validasi-table')) {
        $('#validasi-table').DataTable().destroy();
    }
    
    var table = $('#validasi-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("validasi.data") }}',
        columns: [
            {data: 'tanggal_pengajuan', name: 'tanggal_pengajuan'},
            {data: 'user.name', name: 'user.name'},
            {data: 'nik', name: 'nik'},
            {data: 'jenis_surat.nama_surat', name: 'jenis_surat.nama_surat'},
            {data: 'keperluan', name: 'keperluan'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        order: [[0, 'asc']],
        language: {
            processing: "Memproses...",
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 hingga 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ total data)",
            loadingRecords: "Memuat data...",
            zeroRecords: "Tidak ada surat yang menunggu validasi",
            emptyTable: "Tidak ada surat yang menunggu validasi",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        }
    });

    var currentSuratId = null;

    // Handle approve button click
    $('#validasi-table').on('click', '.approve-btn', function() {
        currentSuratId = $(this).data('id');
        $('#approveModal').modal('show');
    });

    // Handle reject button click
    $('#validasi-table').on('click', '.reject-btn', function() {
        currentSuratId = $(this).data('id');
        $('#rejectModal').modal('show');
    });

    // Handle approve form submit
    $('#approveForm').on('submit', function(e) {
        e.preventDefault();
        
        var keterangan = $('#approve_keterangan').val();
        
        $.ajax({
            url: '/validasi/' + currentSuratId + '/approve',
            type: 'POST',
            data: {
                keterangan: keterangan
            },
            success: function(response) {
                if (response.success) {
                    $('#approveModal').modal('hide');
                    $('#approve_keterangan').val('');
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
    });

    // Handle reject form submit
    $('#rejectForm').on('submit', function(e) {
        e.preventDefault();
        
        var keterangan = $('#reject_keterangan').val();
        
        if (!keterangan.trim()) {
            Swal.fire('Error!', 'Alasan penolakan harus diisi.', 'error');
            return;
        }
        
        $.ajax({
            url: '/validasi/' + currentSuratId + '/reject',
            type: 'POST',
            data: {
                keterangan: keterangan
            },
            success: function(response) {
                if (response.success) {
                    $('#rejectModal').modal('hide');
                    $('#reject_keterangan').val('');
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
    });
});
</script>
@endpush
