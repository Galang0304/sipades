@extends('layouts.app')

@section('title', 'User Approval')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-user-shield text-primary"></i> 
                    Persetujuan Akun Penduduk
                </h1>
                <p class="text-muted mb-0">Kelola persetujuan akun penduduk yang mendaftar</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Approval Akun</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-6">
                <div class="card bg-warning" style="border-radius: 15px;">
                    <div class="card-body text-center text-white">
                        <div style="font-size: 40px; margin-bottom: 15px; opacity: 0.9;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div style="font-size: 32px; font-weight: bold; margin-bottom: 8px;">
                            {{ count($pendingUsers) }}
                        </div>
                        <div>Menunggu Persetujuan</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card bg-success" style="border-radius: 15px;">
                    <div class="card-body text-center text-white">
                        <div style="font-size: 40px; margin-bottom: 15px;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div style="font-size: 32px; font-weight: bold; margin-bottom: 8px;">
                            {{ count($approvedUsers) }}
                        </div>
                        <div>Disetujui Hari Ini</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card bg-danger" style="border-radius: 15px;">
                    <div class="card-body text-center text-white">
                        <div style="font-size: 40px; margin-bottom: 15px;">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div style="font-size: 32px; font-weight: bold; margin-bottom: 8px;">
                            {{ count($rejectedUsers) }}
                        </div>
                        <div>Ditolak Hari Ini</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card bg-info" style="border-radius: 15px;">
                    <div class="card-body text-center text-white">
                        <div style="font-size: 40px; margin-bottom: 15px;">
                            <i class="fas fa-users"></i>
                        </div>
                        <div style="font-size: 32px; font-weight: bold; margin-bottom: 8px;">
                            {{ count($pendingUsers) + count($approvedUsers) + count($rejectedUsers) }}
                        </div>
                        <div>Total Hari Ini</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Users Cards -->
        @if (count($pendingUsers) > 0)
            <div class="card" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white" style="border-radius: 15px 15px 0 0;">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-clock"></i> 
                        Menunggu Persetujuan 
                        <span class="badge badge-light text-primary ml-2">{{ count($pendingUsers) }}</span>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($pendingUsers as $user)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card user-card h-100 position-relative" style="border: 2px solid transparent; border-radius: 12px; transition: all 0.3s ease;">
                                <div style="position: absolute; top: 15px; right: 15px; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase;" class="bg-warning text-dark">
                                    <i class="fas fa-clock"></i> Pending
                                </div>
                                
                                <div class="card-body text-center">
                                    <div style="width: 60px; height: 60px; background: linear-gradient(45deg, #007bff, #28a745); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; margin: 0 auto 15px;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    
                                    <h5 class="card-title mb-1 text-primary">{{ $user->name }}</h5>
                                    <p class="text-muted small mb-2">{{ $user->email }}</p>
                                    <p class="text-muted small">NIK: {{ $user->nik }}</p>

                                    @if ($user->nama_lengkap)
                                    <div style="text-align: left; margin: 15px 0;">
                                        <div style="display: flex; align-items: center; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                                            <i class="fas fa-venus-mars" style="width: 20px; text-align: center; margin-right: 10px; color: #6c757d;"></i>
                                            <span style="width: 80px; color: #6c757d; font-size: 12px; font-weight: 600;">Kelamin:</span>
                                            <span style="flex: 1; font-size: 13px; color: #495057;">{{ $user->jenis_kelamin }}</span>
                                        </div>
                                        <div style="display: flex; align-items: center; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                                            <i class="fas fa-birthday-cake" style="width: 20px; text-align: center; margin-right: 10px; color: #6c757d;"></i>
                                            <span style="width: 80px; color: #6c757d; font-size: 12px; font-weight: 600;">Lahir:</span>
                                            <span style="flex: 1; font-size: 13px; color: #495057;">
                                                {{ $user->tempat_lahir }}, 
                                                {{ date('d/m/Y', strtotime($user->tanggal_lahir)) }}
                                            </span>
                                        </div>
                                        <div style="display: flex; align-items: center; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                                            <i class="fas fa-map-marker-alt" style="width: 20px; text-align: center; margin-right: 10px; color: #6c757d;"></i>
                                            <span style="width: 80px; color: #6c757d; font-size: 12px; font-weight: 600;">Alamat:</span>
                                            <span style="flex: 1; font-size: 13px; color: #495057;">{{ substr($user->alamat, 0, 30) }}...</span>
                                        </div>
                                        <div style="display: flex; align-items: center; padding: 8px 0;">
                                            <i class="fas fa-briefcase" style="width: 20px; text-align: center; margin-right: 10px; color: #6c757d;"></i>
                                            <span style="width: 80px; color: #6c757d; font-size: 12px; font-weight: 600;">Kerja:</span>
                                            <span style="flex: 1; font-size: 13px; color: #495057;">{{ $user->pekerjaan }}</span>
                                        </div>
                                    </div>
                                    @endif

                                    <div style="margin-top: 20px; padding-top: 15px; border-top: 2px solid #dee2e6;">
                                        <div class="d-flex justify-content-between flex-wrap gap-2">
                                            <button type="button" class="btn btn-sm flex-fill mr-1 approve-btn" 
                                                    data-id="{{ $user->id }}"
                                                    style="background: linear-gradient(45deg, #28a745, #20c997); border: none; color: white; padding: 8px 16px; border-radius: 20px;"
                                                    title="Setujui Pendaftaran">
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                            <button type="button" class="btn btn-sm flex-fill reject-btn" 
                                                    data-id="{{ $user->id }}"
                                                    style="background: linear-gradient(45deg, #dc3545, #fd7e14); border: none; color: white; padding: 8px 16px; border-radius: 20px;"
                                                    title="Tolak Pendaftaran">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="card" style="border-radius: 15px;">
                <div class="card-body text-center" style="padding: 60px 20px;">
                    <i class="fas fa-user-check" style="font-size: 80px; color: #dee2e6; margin-bottom: 20px;"></i>
                    <h4 class="text-muted mb-3">Tidak Ada Pendaftaran Pending</h4>
                    <p class="text-muted">Semua pendaftaran telah diproses atau belum ada pendaftaran baru hari ini.</p>
                    <a href="{{ route('admin.user-approval.index') }}" class="btn btn-primary">
                        <i class="fas fa-sync-alt"></i> Refresh Halaman
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    console.log('User Approval script loaded');
    console.log('CSRF Token:', $('meta[name="csrf-token"]').attr('content'));
    
    // Handle approve button click
    $(document).on('click', '.approve-btn', function() {
        console.log('Approve button clicked');
        var userId = $(this).data('id');
        console.log('User ID:', userId);
        
        Swal.fire({
            title: 'Setujui Pendaftaran?',
            text: "Akun akan diaktifkan dan pengguna dapat login.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-check"></i> Ya, Setujui!',
            cancelButtonText: '<i class="fas fa-times"></i> Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('Sending approve request');
                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    html: 'Sedang menyetujui pendaftaran',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                // Submit AJAX request
                const url = '{{ route("admin.user-approval.approve", ":id") }}'.replace(':id', userId);
                console.log('Sending request to:', url);
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log('Approve response:', response);
                        if (response.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message || 'Terjadi kesalahan',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', xhr.responseText);
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menyetujui pendaftaran: ' + error,
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            }
        });
    });

    // Handle reject button click
    $(document).on('click', '.reject-btn', function() {
        console.log('Reject button clicked');
        var userId = $(this).data('id');
        console.log('User ID:', userId);
        
        Swal.fire({
            title: 'Tolak Pendaftaran',
            text: 'Berikan alasan penolakan (minimal 10 karakter)',
            input: 'textarea',
            inputPlaceholder: 'Alasan penolakan (wajib diisi, minimal 10 karakter)',
            inputAttributes: {
                rows: 4,
                style: 'resize: vertical;'
            },
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Tolak Pendaftaran',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value) {
                    return 'Alasan penolakan harus diisi!'
                }
                if (value.length < 10) {
                    return 'Alasan penolakan minimal 10 karakter!'
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('Sending reject request with reason:', result.value);
                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    html: 'Sedang menolak pendaftaran',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
                
                $.ajax({
                    url: '{{ route("admin.user-approval.reject", ":id") }}'.replace(':id', userId),
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        rejection_reason: result.value
                    },
                    success: function(response) {
                        console.log('Reject response:', response);
                        if (response.success) {
                            Swal.fire({
                                title: 'Berhasil!', 
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!', 
                                text: response.message || 'Terjadi kesalahan',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', xhr.responseText);
                        Swal.fire({
                            title: 'Gagal!', 
                            text: 'Terjadi kesalahan saat menolak pendaftaran: ' + error,
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            }
        });
    });
});
</script>
@endpush
