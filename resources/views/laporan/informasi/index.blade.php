@extends('layouts.app')

@section('title', 'Laporan Informasi')
@section('page-title', 'Laporan Informasi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Laporan Informasi</li>
@endsection

@section('content')
<div class="row">
    <!-- Statistik Cards -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_informasi'] }}</h3>
                <p>Total Informasi</p>
            </div>
            <div class="icon">
                <i class="fas fa-newspaper"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['published'] }}</h3>
                <p>Published</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['draft'] }}</h3>
                <p>Draft</p>
            </div>
            <div class="icon">
                <i class="fas fa-edit"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $stats['bulan_ini'] }}</h3>
                <p>Bulan Ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-filter"></i> Filter Laporan
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('laporan.informasi') }}" id="filterForm">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" 
                                       class="form-control" value="{{ request('tanggal_mulai') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tanggal_selesai">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" 
                                       class="form-control" value="{{ request('tanggal_selesai') }}">
                            </div>
                        </div>
                        <div class="col-md-6"></div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="{{ route('laporan.informasi') }}" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i> Data Informasi
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Tanggal</th>
                                <th width="70%">Judul</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($informasi as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($informasi->currentPage() - 1) * $informasi->perPage() }}</td>
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <strong>{{ Str::limit($item->judul, 80) }}</strong>
                                        @if($item->is_featured)
                                            <span class="badge badge-warning">Featured</span>
                                        @endif
                                        <br>
                                        <small class="text-muted">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</small>
                                        <br>
                                        <small class="text-info">
                                            <i class="fas fa-eye"></i> {{ $item->views ?? 0 }} views |
                                            <i class="fas fa-user"></i> {{ $item->pembuat->name ?? 'Unknown' }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($item->is_published)
                                            <span class="badge badge-success">Published</span>
                                        @else
                                            <span class="badge badge-secondary">Draft</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <i class="fas fa-inbox"></i> Tidak ada data informasi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $informasi->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto submit form ketika filter berubah
$(document).ready(function() {
    $('#tanggal_mulai, #tanggal_selesai').on('change', function() {
        // Auto submit setelah kedua tanggal diisi
        if ($('#tanggal_mulai').val() && $('#tanggal_selesai').val()) {
            $('#filterForm').submit();
        }
    });
});
</script>
@endpush
