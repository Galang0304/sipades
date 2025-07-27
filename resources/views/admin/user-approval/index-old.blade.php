@extends('layouts.app')

@section('title', 'Approval Akun Penduduk')

@section('styles')
<style>
    .user-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    .user-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-color: #007bff;
    }
    .user-avatar {
        width: 60px;
        height: 60px;
        background: linear-gradient(45deg, #007bff, #28a745);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: bold;
    }
    .status-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 600;
    }
    .info-item {
        display: flex;
        margin: 8px 0;
    }
    .info-label {
        width: 100px;
        color: #6c757d;
        font-size: 12px;
        font-weight: 600;
    }
    .info-value {
        flex: 1;
        font-size: 13px;
    }
    .action-buttons {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #dee2e6;
    }
    .btn-approve {
        background: linear-gradient(45deg, #28a745, #20c997);
        border: none;
        color: white;
    }
    .btn-reject {
        background: linear-gradient(45deg, #dc3545, #fd7e14);
        border: none;
        color: white;
    }
    .statistics-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
    }
    .statistics-card .card-body {
        text-align: center;
        padding: 30px;
    }
    .statistics-icon {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.8;
    }
    .statistics-number {
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .recent-activity {
        max-height: 400px;
        overflow-y: auto;
    }
    .activity-item {
        padding: 12px;
        border-left: 4px solid #007bff;
        margin-bottom: 10px;
        background: #f8f9fa;
        border-radius: 0 8px 8px 0;
    }
    .activity-item.approved {
        border-left-color: #28a745;
    }
    .activity-item.rejected {
        border-left-color: #dc3545;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-user-shield text-primary"></i> 
                        Persetujuan Akun Penduduk
                    </h1>
                    <p class="text-muted">Kelola persetujuan akun penduduk yang mendaftar</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Approval Akun</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="card statistics-card">
                        <div class="card-body">
                            <div class="statistics-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="statistics-number">{{ $pendingUsers->count() }}</div>
                            <div>Menunggu Persetujuan</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="card bg-success">
                        <div class="card-body text-center text-white">
                            <div class="statistics-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="statistics-number">{{ $approvedUsers->count() }}</div>
                            <div>Disetujui Hari Ini</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="card bg-danger">
                        <div class="card-body text-center text-white">
                            <div class="statistics-icon">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="statistics-number">{{ $rejectedUsers->count() }}</div>
                            <div>Ditolak Hari Ini</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="card bg-info">
                        <div class="card-body text-center text-white">
                            <div class="statistics-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="statistics-number">{{ $pendingUsers->count() + $approvedUsers->count() + $rejectedUsers->count() }}</div>
                            <div>Total Hari Ini</div>
                        </div>
                    </div>
                </div>
            </div>
                                            <small>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#detailModal{{ $user->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-success" onclick="approveUser({{ $user->id }})">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#rejectModal{{ $user->id }}">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Detail Modal -->
                                    <div class="modal fade" id="detailModal{{ $user->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Detail Penduduk</h4>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    @include('admin.user-approval.detail', ['user' => $user])
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $user->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="POST" action="{{ route('admin.user-approval.reject', $user) }}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Tolak Pendaftaran</h4>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Anda yakin ingin menolak pendaftaran <strong>{{ $user->name }}</strong>?</p>
                                                        <div class="form-group">
                                                            <label>Alasan Penolakan:</label>
                                                            <textarea name="rejection_reason" class="form-control" rows="3" required
                                                                placeholder="Jelaskan alasan penolakan..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-times"></i> Tolak
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-user-check fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada pendaftaran yang menunggu persetujuan.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Approved & Rejected Users (Summary) -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-check-circle"></i> Terbaru Disetujui
                            </h3>
                        </div>
                        <div class="card-body">
                            @forelse($approvedUsers as $user)
                                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        <br><small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                    <div class="text-right">
                                        <small class="text-success">
                                            {{ $user->approved_at ? $user->approved_at->format('d/m/Y') : 'Disetujui' }}
                                        </small>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center">Belum ada yang disetujui.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-times-circle"></i> Terbaru Ditolak
                            </h3>
                        </div>
                        <div class="card-body">
                            @forelse($rejectedUsers as $user)
                                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        <br><small class="text-muted">{{ Str::limit($user->rejection_reason, 40) }}</small>
                                    </div>
                                    <div class="text-right">
                                        <small class="text-danger">
                                            Ditolak
                                        </small>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center">Belum ada yang ditolak.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function approveUser(userId) {
    if (confirm('Anda yakin ingin menyetujui pendaftaran ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/user-approval/${userId}/approve`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
