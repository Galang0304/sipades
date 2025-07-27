@extends('layouts.app')

@section('title', 'Dashboard Lurah')
@section('page-title', 'Dashboard Lurah')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['surat_menunggu_lurah'] }}</h3>
                <p>Menunggu Persetujuan</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="{{ route('surat.index') }}" class="small-box-footer">Setujui Surat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['surat_approved'] }}</h3>
                <p>Surat Disetujui</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $stats['surat_rejected'] }}</h3>
                <p>Surat Ditolak</p>
            </div>
            <div class="icon">
                <i class="fas fa-times-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_penduduk'] }}</h3>
                <p>Total Penduduk</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Surat Menunggu Persetujuan Lurah</h3>
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
                                <th>Tanggal Diproses</th>
                                <th>Pemohon</th>
                                <th>Jenis Surat</th>
                                <th>Diproses Oleh</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($surat_menunggu_lurah as $key => $surat)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $surat->tanggal_diproses_petugas ? $surat->tanggal_diproses_petugas->format('d/m/Y H:i') : '-' }}</td>
                                    <td>{{ $surat->penduduk->nama_lengkap ?? 'N/A' }}</td>
                                    <td>{{ $surat->jenis_surat->nama_surat ?? 'N/A' }}</td>
                                    <td>{{ $surat->petugas->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge {{ $surat->status_badge }}">{{ $surat->status }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('surat.show', $surat->id) }}" class="btn btn-info btn-xs">Detail</a>
                                            @if($surat->canBeProcessedByLurah())
                                            <button class="btn btn-success btn-xs approve-lurah-btn" data-id="{{ $surat->id }}">Setujui</button>
                                            <button class="btn btn-danger btn-xs reject-btn" data-id="{{ $surat->id }}">Tolak</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <p class="text-muted">Tidak ada surat yang menunggu persetujuan lurah.</p>
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
    // Handle approve by lurah from dashboard
    $('.approve-lurah-btn').on('click', function() {
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
                            Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                location.reload();
                            });
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

    // Handle reject from dashboard
    $('.reject-btn').on('click', function() {
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
                            Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                location.reload();
                            });
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
