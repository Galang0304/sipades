@extends('layouts.app')

@section('title', 'User Approval')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-primary">
                    <i class="fas fa-user-shield mr-2"></i>User Approval
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">User Approval</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Pending Users -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-clock"></i>
                Pending User Registrations
            </h3>
        </div>
        <div class="card-body">
            @if($pendingUsers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>NIK</th>
                                <th>No. KK</th>
                                <th>Foto KK</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingUsers as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->nik ?? '-' }}</td>
                                    <td>{{ $user->no_kk ?? '-' }}</td>
                                    <td>
                                        @if($user->foto_kk)
                                            <a href="{{ $user->foto_kk_url }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" 
                                                    class="btn btn-success btn-sm" 
                                                    onclick="approveUser({{ $user->id }})">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm" 
                                                    onclick="rejectUser({{ $user->id }})">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                            <a href="{{ route('user-approval.show', $user->id) }}" 
                                               class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h4>Tidak ada user yang menunggu approval</h4>
                    <p class="text-muted">Semua registrasi user telah diproses.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Approved Users -->
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-check-circle text-success"></i>
                Approved Users
            </h3>
        </div>
        <div class="card-body">
            @if($approvedUsers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>NIK</th>
                                <th>No. KK</th>
                                <th>Tanggal Disetujui</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approvedUsers as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->nik ?? '-' }}</td>
                                    <td>{{ $user->no_kk ?? '-' }}</td>
                                    <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-2">
                    <p class="text-muted">Belum ada user yang disetujui.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Rejected Users -->
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-times-circle text-danger"></i>
                Rejected Users
            </h3>
        </div>
        <div class="card-body">
            @if($rejectedUsers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>NIK</th>
                                <th>No. KK</th>
                                <th>Tanggal Ditolak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rejectedUsers as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->nik ?? '-' }}</td>
                                    <td>{{ $user->no_kk ?? '-' }}</td>
                                    <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-2">
                    <p class="text-muted">Belum ada user yang ditolak.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="approveForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Konfirmasi Approval</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menyetujui registrasi user ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Setujui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Konfirmasi Penolakan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menolak registrasi user ini?</p>
                    <div class="form-group">
                        <label for="rejection_reason">Alasan Penolakan (Opsional):</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
function approveUser(userId) {
    $('#approveForm').attr('action', '{{ url("admin/user-approval") }}/' + userId + '/approve');
    $('#approveModal').modal('show');
}

function rejectUser(userId) {
    $('#rejectForm').attr('action', '{{ url("admin/user-approval") }}/' + userId + '/reject');
    $('#rejectModal').modal('show');
}

$(document).ready(function() {
    // DataTable initialization
    $('table').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[6, 'desc']] // Sort by date column
    });
    </div>
</div>
@endsection

@section('scripts')
<script>
function approveUser(userId) {
    $('#approveForm').attr('action', '{{ url("user-approval") }}/' + userId + '/approve');
    $('#approveModal').modal('show');
}

function rejectUser(userId) {
    $('#rejectForm').attr('action', '{{ url("user-approval") }}/' + userId + '/reject');
    $('#rejectModal').modal('show');
}

$(document).ready(function() {
    // DataTable initialization
    $('table').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[6, 'desc']] // Sort by date column
    });
});
</script>
@endsection

@section('styles')
<style>
.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
}

.table th {
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

.btn-group .btn {
    margin-right: 2px;
}

.text-muted {
    color: #6c757d !important;
}

.alert {
    border: none;
    border-radius: 6px;
}
</style>
@endsection
