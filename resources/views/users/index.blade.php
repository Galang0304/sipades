@extends('layouts.app')

@section('title', 'Manajemen Users')
@section('page-title', 'Manajemen Users')

@section('breadcrumb')
    <li class="breadcrumb-item active">Manajemen Users</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Users KUINSEL</h3>
                <div class="card-tools">
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah User
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="users-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>NIK</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus user ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Destroy existing DataTable if it exists
    if ($.fn.DataTable.isDataTable('#users-table')) {
        $('#users-table').DataTable().destroy();
    }
    
    // Initialize DataTable
    var table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("users.data") }}',
            error: function(xhr, error, thrown) {
                console.log('DataTable Error:', error);
                console.log('XHR:', xhr);
                console.log('Thrown:', thrown);
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'nik', name: 'nik' },
            { data: 'role', name: 'role' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
        },
        responsive: true,
        order: [[0, 'desc']]
    });

    // Handle delete button click
    $(document).on('click', '.btn-delete', function() {
        var userId = $(this).data('id');
        var deleteUrl = '{{ route("users.destroy", ":id") }}';
        deleteUrl = deleteUrl.replace(':id', userId);
        
        $('#deleteForm').attr('action', deleteUrl);
        $('#deleteModal').modal('show');
    });
});
</script>
@endpush
