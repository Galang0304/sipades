@extends('layouts.app')

@section('title', 'Detail Validasi Surat')
@section('page-title', 'Detail Validasi Surat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('validasi.index') }}">Validasi Surat</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Pengajuan Surat</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <strong>Jenis Surat:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $surat->jenis_surat->nama }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <strong>Nama Pemohon:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $surat->user->name }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <strong>NIK:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $surat->nik }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <strong>Keperluan:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $surat->keperluan }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <strong>Tanggal Pengajuan:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $surat->tanggal_pengajuan->format('d/m/Y H:i') }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <strong>Status:</strong>
                    </div>
                    <div class="col-sm-9">
                        @if($surat->status == 'Menunggu')
                            <span class="badge badge-warning">{{ $surat->status }}</span>
                        @elseif($surat->status == 'Diproses')
                            <span class="badge badge-info">{{ $surat->status }}</span>
                        @elseif($surat->status == 'Selesai')
                            <span class="badge badge-success">{{ $surat->status }}</span>
                        @else
                            <span class="badge badge-danger">{{ $surat->status }}</span>
                        @endif
                    </div>
                </div>

                @if($surat->tanggal_diproses_petugas)
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <strong>Diproses Petugas:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $surat->tanggal_diproses_petugas->format('d/m/Y H:i') }}
                        @if($surat->petugas)
                            oleh {{ $surat->petugas->name }}
                        @endif
                    </div>
                </div>
                @if($surat->keterangan_petugas)
                <div class="row">
                    <div class="col-sm-3">
                        <strong>Keterangan Petugas:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $surat->keterangan_petugas }}
                    </div>
                </div>
                @endif
                @endif

                @if($surat->data_tambahan)
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <strong>Data Tambahan:</strong>
                    </div>
                    <div class="col-sm-9">
                        <pre>{{ json_encode($surat->data_tambahan, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Aksi Validasi</h3>
            </div>
            <div class="card-body">
                @if($surat->status == 'Diproses')
                <div class="mb-3">
                    <button type="button" class="btn btn-success btn-block" onclick="approveSurat({{ $surat->id }})">
                        <i class="fas fa-check"></i> Setujui Surat
                    </button>
                </div>
                <div class="mb-3">
                    <button type="button" class="btn btn-danger btn-block" onclick="rejectSurat({{ $surat->id }})">
                        <i class="fas fa-times"></i> Tolak Surat
                    </button>
                </div>
                @else
                <div class="alert alert-info">
                    Surat ini tidak dapat divalidasi pada status saat ini.
                </div>
                @endif

                <div class="mt-3">
                    <a href="{{ route('validasi.index') }}" class="btn btn-secondary btn-block">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>

        @if($surat->penduduk)
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Data Penduduk</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <strong>Nama:</strong>
                    </div>
                    <div class="col-sm-7">
                        {{ $surat->penduduk->nama }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-5">
                        <strong>Alamat:</strong>
                    </div>
                    <div class="col-sm-7">
                        {{ $surat->penduduk->alamat }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-5">
                        <strong>RT/RW:</strong>
                    </div>
                    <div class="col-sm-7">
                        {{ $surat->penduduk->rt }}/{{ $surat->penduduk->rw }}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function approveSurat(id) {
    Swal.fire({
        title: 'Konfirmasi Persetujuan',
        text: 'Apakah Anda yakin ingin menyetujui surat ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Setujui',
        cancelButtonText: 'Batal',
        input: 'textarea',
        inputPlaceholder: 'Keterangan (opsional)',
        inputAttributes: {
            'aria-label': 'Keterangan persetujuan'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("validasi.approve", ":id") }}'.replace(':id', id),
                type: 'POST',
                data: {
                    keterangan: result.value || ''
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Surat berhasil disetujui',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '{{ route("validasi.index") }}';
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menyetujui surat'
                    });
                }
            });
        }
    });
}

function rejectSurat(id) {
    Swal.fire({
        title: 'Konfirmasi Penolakan',
        text: 'Apakah Anda yakin ingin menolak surat ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Tolak',
        cancelButtonText: 'Batal',
        input: 'textarea',
        inputPlaceholder: 'Alasan penolakan (wajib)',
        inputAttributes: {
            'aria-label': 'Alasan penolakan'
        },
        inputValidator: (value) => {
            if (!value) {
                return 'Alasan penolakan harus diisi!'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("validasi.reject", ":id") }}'.replace(':id', id),
                type: 'POST',
                data: {
                    keterangan: result.value
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Surat berhasil ditolak',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '{{ route("validasi.index") }}';
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menolak surat'
                    });
                }
            });
        }
    });
}
</script>
@endpush
