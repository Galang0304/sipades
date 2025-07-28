@extends('layouts.app')

@section('title', 'Laporan Surat')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-file-alt text-primary"></i> 
                    Laporan Surat
                </h1>
                <p class="text-muted mb-0">Kelola dan cetak laporan pengajuan surat</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Laporan Surat</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Filter Card -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-filter"></i> Filter Laporan
                </h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.laporan.surat.index') }}" id="filterForm">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jenis_surat_id">Jenis Surat</label>
                                <select name="jenis_surat_id" id="jenis_surat_id" class="form-control">
                                    <option value="">Semua Jenis</option>
                                    @foreach($jenisSurat as $jenis)
                                        <option value="{{ $jenis->id }}" {{ request('jenis_surat_id') == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->nama_surat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tanggal_selesai">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="bulan">Bulan</label>
                                <select name="bulan" id="bulan" class="form-control">
                                    <option value="">Semua Bulan</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <select name="tahun" id="tahun" class="form-control">
                                    <option value="">Semua Tahun</option>
                                    @for($i = date('Y'); $i >= 2020; $i--)
                                        <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary mr-2">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                    <a href="{{ route('admin.laporan.surat.index') }}" class="btn btn-secondary mr-2">
                                        <i class="fas fa-undo"></i> Reset
                                    </a>
                                    <button type="button" class="btn btn-success" onclick="cetakLaporan()">
                                        <i class="fas fa-print"></i> Cetak Laporan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card">
            <div class="card-header bg-info text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-table"></i> Data Laporan Surat
                    <span class="badge badge-light text-info ml-2">{{ count($surat) }} data</span>
                </h3>
            </div>
            <div class="card-body">
                @if(count($surat) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="laporanTable">
                            <thead class="bg-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="20%">Nama Pemohon</th>
                                    <th width="15%">NIK</th>
                                    <th width="20%">Jenis Surat</th>
                                    <th width="15%">Keperluan</th>
                                    <th width="10%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($surat as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $item->penduduk->nama_lengkap ?? $item->user->name }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->jenis_surat->nama_surat }}</td>
                                    <td>{{ Str::limit($item->keperluan, 30) }}</td>
                                    <td>
                                        @if($item->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($item->status == 'disetujui')
                                            <span class="badge badge-info">Disetujui</span>
                                        @elseif($item->status == 'ditolak')
                                            <span class="badge badge-danger">Ditolak</span>
                                        @elseif($item->status == 'selesai')
                                            <span class="badge badge-success">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada data</h5>
                        <p class="text-muted">Belum ada data surat dengan filter yang dipilih</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    // DataTable
    $('#laporanTable').DataTable({
        "responsive": true,
        "autoWidth": false,
        "ordering": true,
        "info": true,
        "paging": true,
        "searching": true,
        "pageLength": 25
    });
});

function cetakLaporan() {
    // Get current filter parameters
    const formData = new URLSearchParams(new FormData(document.getElementById('filterForm')));
    const url = '{{ route("admin.laporan.surat.cetak") }}?' + formData.toString();
    
    // Open in new window for printing
    window.open(url, '_blank');
}
</script>
@endpush
