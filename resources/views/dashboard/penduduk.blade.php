@extends('layouts.app')

@section('title', 'Dashboard Penduduk')

@section('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
}
.bg-opacity-20 {
    background-color: rgba(255, 255, 255, 0.2) !important;
}
.text-white-50 {
    color: rgba(255, 255, 255, 0.7) !important;
}
.opacity-50 {
    opacity: 0.5;
}
.card {
    transition: all 0.3s ease;
    border-radius: 10px;
}
.card:hover {
    transform: translateY(-2px);
}
.badge {
    font-size: 0.75em;
}
.btn {
    border-radius: 8px;
    transition: all 0.3s ease;
}
.btn:hover {
    transform: translateY(-1px);
}
.custom-file-label::after {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
    color: white;
    border-radius: 0 8px 8px 0;
}
</style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-primary">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard Penduduk
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="container-fluid mb-3">
        <div class="alert alert-success alert-dismissible shadow-sm">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    </div>
@endif

<div class="content">
    <div class="container-fluid">
        <!-- Hero Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-primary shadow-lg border-0">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="text-white mb-2">
                                    <i class="fas fa-hand-peace mr-2"></i>
                                    Selamat Datang, {{ auth()->user()->name }}!
                                </h3>
                                <p class="text-white-50 mb-1 h5">KUINSEL - Kelurahan Kuin Selatan</p>
                                <p class="text-white-50 mb-0">Kelola pengajuan surat dan akses layanan kelurahan dengan mudah</p>
                            </div>
                            <div class="col-md-4 text-right">
                                <div class="d-flex flex-column align-items-end">
                                    @if(auth()->user()->foto_kk)
                                        <span class="badge badge-success mb-2 px-3 py-2">
                                            <i class="fas fa-check-circle mr-1"></i>Dokumen KK Lengkap
                                        </span>
                                        <a href="{{ auth()->user()->foto_kk_url }}" target="_blank" 
                                           class="btn btn-light btn-sm shadow">
                                            <i class="fas fa-eye mr-1"></i> Lihat Kartu Keluarga
                                        </a>
                                    @else
                                        <span class="badge badge-warning mb-2 px-3 py-2">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>KK Belum Diupload
                                        </span>
                                        <button class="btn btn-warning btn-sm shadow" data-toggle="modal" data-target="#uploadKkModal">
                                            <i class="fas fa-upload mr-1"></i> Upload Kartu Keluarga
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body bg-gradient-info text-white rounded">
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                                    <i class="fas fa-file-alt fa-2x text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h2 class="mb-0 font-weight-bold">{{ $stats['my_surat'] ?? 0 }}</h2>
                                <p class="mb-0 text-white-50">Total Surat Saya</p>
                                <small class="text-white-50">Semua pengajuan yang pernah dibuat</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-6 col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body bg-gradient-success text-white rounded">
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                                    <i class="fas fa-user-check fa-2x text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="mb-0 font-weight-bold">
                                    @if(auth()->user()->is_active)
                                        <span class="badge badge-light text-success">AKTIF</span>
                                    @else
                                        <span class="badge badge-light text-warning">PENDING</span>
                                    @endif
                                </h4>
                                <p class="mb-0 text-white-50">Status Verifikasi</p>
                                <small class="text-white-50">
                                    {{ auth()->user()->is_active ? 'Akun telah diverifikasi' : 'Menunggu verifikasi admin' }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-bolt text-primary mr-2"></i>
                            Menu Cepat
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12 mb-3">
                                <a href="{{ route('surat.create') }}" class="btn btn-primary btn-lg btn-block shadow-sm">
                                    <i class="fas fa-plus-circle mr-2"></i>
                                    Buat Pengajuan Surat Baru
                                </a>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 mb-3">
                                <a href="{{ route('surat.index') }}" class="btn btn-info btn-lg btn-block shadow-sm">
                                    <i class="fas fa-list-alt mr-2"></i>
                                    Lihat Riwayat Surat Saya
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Recent Surat Section -->
        @if(isset($my_surat) && $my_surat->count() > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-history text-primary mr-2"></i>
                                Surat Terbaru Saya
                            </h4>
                            <a href="{{ route('surat.index') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-list mr-1"></i>Lihat Semua
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0">Jenis Surat</th>
                                        <th class="border-0">Tanggal Pengajuan</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($my_surat->take(5) as $surat)
                                    <tr>
                                        <td class="font-weight-medium">
                                            <i class="fas fa-file-alt text-muted mr-2"></i>
                                            {{ $surat->jenis_surat->nama_surat ?? 'Tidak Diketahui' }}
                                        </td>
                                        <td class="text-muted">
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ \Carbon\Carbon::parse($surat->tanggal_pengajuan)->format('d/m/Y H:i') }}
                                        </td>
                                        <td>
                                            @if($surat->status == 'Menunggu')
                                                <span class="badge badge-warning px-3">
                                                    <i class="fas fa-clock mr-1"></i>Menunggu
                                                </span>
                                            @elseif($surat->status == 'Diproses')
                                                <span class="badge badge-info px-3">
                                                    <i class="fas fa-cog mr-1"></i>Diproses
                                                </span>
                                            @elseif($surat->status == 'Selesai')
                                                <span class="badge badge-success px-3">
                                                    <i class="fas fa-check mr-1"></i>Selesai
                                                </span>
                                            @elseif($surat->status == 'Ditolak')
                                                <span class="badge badge-danger px-3">
                                                    <i class="fas fa-times mr-1"></i>Ditolak
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('surat.show', $surat->id) }}" 
                                                   class="btn btn-outline-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($surat->status == 'Selesai')
                                                    <a href="{{ route('surat.print', $surat->id) }}" 
                                                       class="btn btn-outline-success btn-sm" target="_blank">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Empty State -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-file-alt fa-4x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted">Belum Ada Pengajuan Surat</h5>
                        <p class="text-muted mb-4">Anda belum pernah mengajukan surat. Mulai buat pengajuan surat pertama Anda!</p>
                        <a href="{{ route('surat.create') }}" class="btn btn-primary shadow">
                            <i class="fas fa-plus-circle mr-2"></i>Buat Surat Pertama
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Informasi Kelurahan -->
        @if(isset($informasi) && $informasi->count() > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-bullhorn text-warning mr-2"></i>
                            Informasi & Pengumuman Terbaru
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($informasi->take(3) as $info)
                            <div class="col-lg-4 col-md-6 col-12 mb-3">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary font-weight-bold">{{ $info->judul }}</h6>
                                        <p class="card-text text-muted small">{{ Str::limit($info->konten, 120) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar mr-1"></i>
                                                {{ \Carbon\Carbon::parse($info->created_at)->format('d/m/Y') }}
                                            </small>
                                            <span class="badge badge-primary badge-pill">Info</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Enhanced Modal Upload Kartu Keluarga -->
<div class="modal fade" id="uploadKkModal" tabindex="-1" role="dialog" aria-labelledby="uploadKkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('profile.upload-kk') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-gradient-warning text-white border-0">
                    <h5 class="modal-title" id="uploadKkModalLabel">
                        <i class="fas fa-cloud-upload-alt mr-2"></i>Upload Foto Kartu Keluarga
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group">
                        <label for="foto_kk" class="font-weight-bold">Pilih File Foto Kartu Keluarga</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="foto_kk" name="foto_kk" 
                                   accept="image/*,.pdf" required>
                            <label class="custom-file-label" for="foto_kk">Pilih file...</label>
                        </div>
                        <div class="mt-3 p-3 bg-light rounded">
                            <small class="text-muted">
                                <i class="fas fa-info-circle text-info mr-1"></i>
                                <strong>Ketentuan Upload:</strong>
                            </small>
                            <ul class="list-unstyled mt-2 mb-0 small text-muted">
                                <li><i class="fas fa-check text-success mr-1"></i> Format: JPG, JPEG, PNG, atau PDF</li>
                                <li><i class="fas fa-check text-success mr-1"></i> Ukuran maksimal: 2MB</li>
                                <li><i class="fas fa-check text-success mr-1"></i> Pastikan foto/scan jelas dan dapat dibaca</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-upload mr-1"></i>Upload Dokumen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Enhanced custom file input
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass("selected").html(fileName);
    });

    // Add some animations
    $('.card').hover(
        function() { $(this).addClass('shadow-lg').css('transform', 'translateY(-2px)'); },
        function() { $(this).removeClass('shadow-lg').css('transform', 'translateY(0px)'); }
    );

    // Dashboard initialization
    console.log('Dashboard Penduduk loaded with enhanced UI');
    
    // Show welcome message for new users
    @if(!auth()->user()->foto_kk)
        setTimeout(function() {
            if(confirm('Selamat datang! Untuk melengkapi profil Anda, silakan upload foto Kartu Keluarga terlebih dahulu.')) {
                $('#uploadKkModal').modal('show');
            }
        }, 2000);
    @endif
});
</script>
@endsection