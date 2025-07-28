@extends('layouts.app')

@section('title', 'Laporan Penduduk')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-users text-primary"></i> 
                    Laporan Data Penduduk
                </h1>
                <p class="text-muted mb-0">Kelola dan cetak laporan data penduduk</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Laporan Penduduk</li>
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
                <form method="GET" action="{{ route('admin.laporan.penduduk.index') }}" id="filterForm">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                    <option value="">Semua</option>
                                    <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="agama">Agama</label>
                                <select name="agama" id="agama" class="form-control">
                                    <option value="">Semua</option>
                                    <option value="Islam" {{ request('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ request('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ request('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ request('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ request('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ request('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status_perkawinan">Status Perkawinan</label>
                                <select name="status_perkawinan" id="status_perkawinan" class="form-control">
                                    <option value="">Semua</option>
                                    <option value="Belum Kawin" {{ request('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                    <option value="Kawin" {{ request('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                    <option value="Cerai Hidup" {{ request('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                    <option value="Cerai Mati" {{ request('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status_penduduk">Status Penduduk</label>
                                <select name="status_penduduk" id="status_penduduk" class="form-control">
                                    <option value="">Semua</option>
                                    <option value="Tetap" {{ request('status_penduduk') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                                    <option value="Sementara" {{ request('status_penduduk') == 'Sementara' ? 'selected' : '' }}>Sementara</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="umur_min">Umur Min</label>
                                <input type="number" name="umur_min" id="umur_min" class="form-control" value="{{ request('umur_min') }}" placeholder="0">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="umur_max">Umur Max</label>
                                <input type="number" name="umur_max" id="umur_max" class="form-control" value="{{ request('umur_max') }}" placeholder="100">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tanggal_mulai">Tgl Daftar Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tanggal_selesai">Tgl Daftar Selesai</label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="search">Cari Nama/NIK</label>
                                <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Nama atau NIK...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary mr-2">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                    <a href="{{ route('admin.laporan.penduduk.index') }}" class="btn btn-secondary mr-2">
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
                    <i class="fas fa-table"></i> Data Laporan Penduduk
                    <span class="badge badge-light text-info ml-2">{{ count($penduduk) }} data</span>
                </h3>
            </div>
            <div class="card-body">
                @if(count($penduduk) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="laporanTable">
                            <thead class="bg-light">
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="12%">NIK</th>
                                    <th width="15%">Nama Lengkap</th>
                                    <th width="12%">Tempat Lahir</th>
                                    <th width="8%">Tgl Lahir</th>
                                    <th width="5%">JK</th>
                                    <th width="8%">Agama</th>
                                    <th width="10%">Status Kawin</th>
                                    <th width="12%">Pekerjaan</th>
                                    <th width="8%">Status</th>
                                    <th width="7%">Umur</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($penduduk as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->nama_lengkap }}</td>
                                    <td>{{ $item->tempat_lahir }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}</td>
                                    <td>{{ $item->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                                    <td>{{ $item->agama }}</td>
                                    <td>{{ $item->status_perkawinan }}</td>
                                    <td>{{ Str::limit($item->pekerjaan, 15) }}</td>
                                    <td>{{ $item->status_penduduk }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} th</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada data</h5>
                        <p class="text-muted">Belum ada data penduduk dengan filter yang dipilih</p>
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
    const url = '{{ route("admin.laporan.penduduk.cetak") }}?' + formData.toString();
    
    // Open in new window for printing
    window.open(url, '_blank');
}
</script>
@endpush
