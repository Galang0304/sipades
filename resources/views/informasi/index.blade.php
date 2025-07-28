@extends('layouts.app')

@section('title', 'Kelola Informasi')
@section('page-title', 'Kelola Informasi')

@section('breadcrumb')
    <li class="breadcrumb-item active">Kelola Informasi</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Kelola Informasi Kelurahan</h3>
                <div class="card-tools">
                    <a href="{{ route('informasi.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Informasi
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="informasiTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Dibuat Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($informasi as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ Str::limit($item->judul, 50) }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $item->kategori ?? 'Umum' }}</span>
                                </td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if($item->is_published ?? true)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-warning">Draft</span>
                                    @endif
                                </td>
                                <td>{{ $item->dibuat_oleh ?? auth()->user()->name }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('informasi.show', $item->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('informasi.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="deleteInformasi({{ $item->id }})" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
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
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Destroy existing DataTable if it exists
    if ($.fn.DataTable.isDataTable('#informasiTable')) {
        $('#informasiTable').DataTable().destroy();
    }
    
    // Initialize DataTable
    $('#informasiTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
        },
        "order": [[3, 'desc']] // Sort by date descending
    });
});
</script>
@endpush
