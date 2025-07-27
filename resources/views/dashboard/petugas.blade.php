@extends('layouts.app')

@section('title', 'Dashboard Petugas')
@section('page-title', 'Dashboard Petugas')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_penduduk'] }}</h3>
                <p>Total Penduduk</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('penduduk.index') }}" class="small-box-footer">Kelola Data <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['surat_pending'] }}</h3>
                <p>Surat Menunggu</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <a href="{{ route('surat.index') }}" class="small-box-footer">Proses Surat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['surat_diproses'] }}</h3>
                <p>Surat Diproses</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <a href="{{ route('surat.index') }}" class="small-box-footer">Lihat Status <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $stats['user_pending'] ?? 0 }}</h3>
                <p>User Pending</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-clock"></i>
            </div>
            <a href="{{ route('user-approval.index') }}" class="small-box-footer">Kelola Approval <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Surat Menunggu Persetujuan</h3>
                <div class="card-tools">
                    <a href="{{ route('surat.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-list"></i> Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Pemohon</th>
                                <th>Jenis Surat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($surat_pending as $key => $surat)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $surat->tanggal_pengajuan->format('d/m/Y') }}</td>
                                    <td>{{ $surat->penduduk->nama_lengkap ?? 'N/A' }}</td>
                                    <td>{{ $surat->jenis_surat->nama_surat ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge {{ $surat->status_badge }}">{{ $surat->status }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('surat.show', $surat->id) }}" class="btn btn-info btn-xs">Detail</a>
                                            @if($surat->canBeProcessedByPetugas())
                                            <button class="btn btn-warning btn-xs approve-petugas-btn" data-id="{{ $surat->id }}">Proses</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <p class="text-muted">Tidak ada surat yang menunggu persetujuan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User Menunggu Approval</h3>
                <div class="card-tools">
                    <a href="{{ route('user-approval.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-users"></i> Kelola User Approval
                    </a>
                </div>
            </div>
            <div class="card-body">
                @php
                    $pending_users = \App\Models\User::where('is_pending', true)
                                                   ->where('is_active', false)
                                                   ->with('roles')
                                                   ->latest('created_at')
                                                   ->limit(5)
                                                   ->get();
                @endphp
                
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>NIK</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pending_users as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->nik ?? '-' }}</td>
                                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('user-approval.show', $user->id) }}" class="btn btn-info btn-xs">Detail</a>
                                            <button class="btn btn-success btn-xs approve-user-btn" data-id="{{ $user->id }}">Approve</button>
                                            <button class="btn btn-danger btn-xs reject-user-btn" data-id="{{ $user->id }}">Reject</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <p class="text-muted">Tidak ada user yang menunggu approval.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
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
    // Handle approve by petugas from dashboard
    $('.approve-petugas-btn').on('click', function() {
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
                            Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                location.reload();
                            });
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

    // Handle approve user from dashboard
    $('.approve-user-btn').on('click', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Approve User',
            text: 'Anda akan menyetujui registrasi user ini',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Approve',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/user-approval/' + id + '/approve',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan saat approve user.', 'error');
                    }
                });
            }
        });
    });

    // Handle reject user from dashboard
    $('.reject-user-btn').on('click', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Reject User',
            text: 'Anda akan menolak registrasi user ini',
            input: 'textarea',
            inputPlaceholder: 'Alasan penolakan (opsional)',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Reject',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/user-approval/' + id + '/reject',
                    type: 'POST',
                    data: {
                        rejection_reason: result.value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan saat reject user.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
