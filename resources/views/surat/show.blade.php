@extends('layouts.app')

@section('title', 'Detail Pengajuan Surat')
@section('page-title', 'Detail Pengajuan Surat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('surat.index') }}">Pengajuan Surat</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Pengajuan</h3>
                            <div class="card-tools">
                                <a href="{{ route('surat.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                @if($surat->status == 'Selesai')
                                <a href="{{ route('surat.print', $surat->id) }}" class="btn btn-success btn-sm" target="_blank">
                                    <i class="fas fa-print"></i> Cetak Surat
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">ID Pengajuan</th>
                                            <td>{{ $surat->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Surat</th>
                                            <td>{{ $surat->jenis_surat->nama_surat }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pemohon</th>
                                            <td>{{ $surat->penduduk->nama_lengkap }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIK</th>
                                            <td>{{ $surat->nik }}</td>
                                        </tr>
                                        <tr>
                                            <th>Keperluan</th>
                                            <td>{{ $surat->keperluan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Pengajuan</th>
                                            <td>{{ $surat->tanggal_pengajuan->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td><span class="badge {{ $surat->status_badge }}">{{ $surat->status }}</span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Alur Persetujuan</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="timeline">
                                                <!-- Pengajuan -->
                                                <div class="time-label">
                                                    <span class="bg-info">Pengajuan Dibuat</span>
                                                </div>
                                                <div>
                                                    <i class="fas fa-file-alt bg-blue"></i>
                                                    <div class="timeline-item">
                                                        <span class="time"><i class="fas fa-clock"></i> {{ $surat->tanggal_pengajuan->format('d/m/Y H:i') }}</span>
                                                        <h3 class="timeline-header">Surat diajukan oleh {{ $surat->user->name }}</h3>
                                                        <div class="timeline-body">
                                                            Status: Menunggu persetujuan petugas
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Approval Petugas -->
                                                @if($surat->tanggal_diproses_petugas)
                                                <div class="time-label">
                                                    <span class="bg-warning">Diproses Petugas</span>
                                                </div>
                                                <div>
                                                    <i class="fas fa-user-check bg-yellow"></i>
                                                    <div class="timeline-item">
                                                        <span class="time"><i class="fas fa-clock"></i> {{ $surat->tanggal_diproses_petugas->format('d/m/Y H:i') }}</span>
                                                        <h3 class="timeline-header">Diproses oleh {{ $surat->petugas->name ?? 'Petugas' }}</h3>
                                                        <div class="timeline-body">
                                                            {{ $surat->keterangan_petugas ?? 'Diproses oleh petugas' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                <!-- Approval Lurah -->
                                                @if($surat->tanggal_diproses_lurah)
                                                <div class="time-label">
                                                    <span class="bg-success">Disetujui Lurah</span>
                                                </div>
                                                <div>
                                                    <i class="fas fa-check bg-green"></i>
                                                    <div class="timeline-item">
                                                        <span class="time"><i class="fas fa-clock"></i> {{ $surat->tanggal_diproses_lurah->format('d/m/Y H:i') }}</span>
                                                        <h3 class="timeline-header">Disetujui oleh {{ $surat->lurah->name ?? 'Lurah' }}</h3>
                                                        <div class="timeline-body">
                                                            {{ $surat->keterangan_lurah ?? 'Surat telah disetujui' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                <!-- Status Ditolak -->
                                                @if($surat->status == 'Ditolak')
                                                <div class="time-label">
                                                    <span class="bg-danger">Ditolak</span>
                                                </div>
                                                <div>
                                                    <i class="fas fa-times bg-red"></i>
                                                    <div class="timeline-item">
                                                        <span class="time"><i class="fas fa-clock"></i> {{ $surat->tanggal_diproses->format('d/m/Y H:i') }}</span>
                                                        <h3 class="timeline-header">Ditolak oleh {{ $surat->diproses_user->name ?? 'Petugas' }}</h3>
                                                        <div class="timeline-body">
                                                            {{ $surat->keterangan_status }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                <!-- End timeline -->
                                                <div>
                                                    <i class="fas fa-clock bg-gray"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($surat->data_tambahan)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Data Tambahan</h4>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                @foreach($surat->data_tambahan as $key => $value)
                                                <tr>
                                                    <th width="30%">{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                                    <td>{{ $value }}</td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    @if(auth()->user()->isPetugas() && $surat->canBeProcessedByPetugas())
                                    <button class="btn btn-warning approve-petugas-btn" data-id="{{ $surat->id }}">
                                        <i class="fas fa-check"></i> Proses Surat
                                    </button>
                                    <button class="btn btn-danger reject-btn" data-id="{{ $surat->id }}">
                                        <i class="fas fa-times"></i> Tolak Surat
                                    </button>
                                    @endif

                                    @if(auth()->user()->isLurah() && $surat->canBeProcessedByLurah())
                                    <button class="btn btn-success approve-lurah-btn" data-id="{{ $surat->id }}">
                                        <i class="fas fa-check"></i> Setujui Surat
                                    </button>
                                    <button class="btn btn-danger reject-btn" data-id="{{ $surat->id }}">
                                        <i class="fas fa-times"></i> Tolak Surat
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Handle approve by petugas
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

    // Handle approve by lurah
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

    // Handle reject
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
