@extends('layouts.app')

@section('title', 'User Detail - ' . $user->name)

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-primary">
                    <i class="fas fa-user mr-2"></i>Detail User - {{ $user->name }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user-approval.index') }}">User Approval</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i>
                        Informasi User
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Nama:</strong></td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>NIK:</strong></td>
                            <td>{{ $user->nik ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>No. KK:</strong></td>
                            <td>{{ $user->no_kk ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>No. Telepon:</strong></td>
                            <td>{{ $user->no_tlp ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Alamat:</strong></td>
                            <td>{{ $user->alamat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Daftar:</strong></td>
                            <td>{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @if($user->is_pending)
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($user->is_active)
                                    <span class="badge badge-success">Approved</span>
                                @else
                                    <span class="badge badge-danger">Rejected</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-image"></i>
                        Foto Kartu Keluarga
                    </h3>
                </div>
                <div class="card-body text-center">
                    @if($user->foto_kk)
                        <img src="{{ $user->foto_kk_url }}" 
                             alt="Foto KK" 
                             class="img-fluid" 
                             style="max-height: 400px; border: 1px solid #ddd; border-radius: 8px;">
                        <div class="mt-3">
                            <a href="{{ $user->foto_kk_url }}" 
                               target="_blank" 
                               class="btn btn-primary">
                                <i class="fas fa-external-link-alt"></i> Buka di Tab Baru
                            </a>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-image fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Foto KK tidak tersedia</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($user->is_pending)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cogs"></i>
                        Aksi Approval
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('user-approval.approve', $user->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menyetujui user ini?')">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg btn-block">
                                    <i class="fas fa-check"></i> Setujui User
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <button type="button" 
                                    class="btn btn-danger btn-lg btn-block" 
                                    data-toggle="modal" 
                                    data-target="#rejectModal">
                                <i class="fas fa-times"></i> Tolak User
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row mt-3">
        <div class="col-12">
            <a href="{{ route('user-approval.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('user-approval.reject', $user->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Konfirmasi Penolakan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menolak registrasi user <strong>{{ $user->name }}</strong>?</p>
                    <div class="form-group">
                        <label for="rejection_reason">Alasan Penolakan (Opsional):</label>
                        <textarea class="form-control" 
                                  id="rejection_reason" 
                                  name="rejection_reason" 
                                  rows="3" 
                                  placeholder="Masukkan alasan penolakan..."></textarea>
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
@endsection

@section('styles')
<style>
.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
}

.table-borderless td {
    border: none;
    padding: 0.5rem 0;
}

.badge {
    font-size: 0.875em;
}

.img-fluid {
    transition: transform 0.2s;
}

.img-fluid:hover {
    transform: scale(1.05);
}

.btn-lg {
    padding: 0.75rem 1.25rem;
    font-size: 1.125rem;
}
</style>
@endsection
