@extends('layouts.app')

@section('title', 'Laporan Pengajuan Surat')
@section('page-title', 'Laporan Pengajuan Surat')
@section('breadcrumb')
    <li class="breadcrumb-item active">Laporan Surat</li>
@endsection

@section('content')
<div class="content-wrapper" style="margin-left: 0 !important;">
    <section class="content">
        <div class="container-fluid" style="padding-left: 5px; padding-right: 5px; max-width: 100%;">
            <!-- Filter -->
            <div class="card card-success shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter mr-2"></i>Filter Laporan
                    </h3>
                </div>
                <form method="GET" action="{{ route('laporan.surat') }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="tanggal_mulai"><i class="fas fa-calendar mr-1"></i>Tanggal Mulai</label>
                                    <input type="date" class="form-control form-control-sm" id="tanggal_mulai" name="tanggal_mulai" 
                                           value="{{ request('tanggal_mulai') }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="tanggal_selesai"><i class="fas fa-calendar mr-1"></i>Tanggal Selesai</label>
                                    <input type="date" class="form-control form-control-sm" id="tanggal_selesai" name="tanggal_selesai" 
                                           value="{{ request('tanggal_selesai') }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="status"><i class="fas fa-info-circle mr-1"></i>Status</label>
                                    <select class="form-control form-control-sm" id="status" name="status">
                                        <option value="">Semua Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="jenis_surat_id"><i class="fas fa-file-alt mr-1"></i>Jenis Surat</label>
                                    <select class="form-control form-control-sm" id="jenis_surat_id" name="jenis_surat_id">
                                        <option value="">Semua Jenis</option>
                                        @foreach($jenisSurat as $jenis)
                                            <option value="{{ $jenis->id }}" 
                                                    {{ request('jenis_surat_id') == $jenis->id ? 'selected' : '' }}>
                                                {{ $jenis->nama_surat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="btn-group" role="group">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <a href="{{ route('laporan.surat') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-undo"></i> Reset
                            </a>
                            <a href="{{ route('laporan.surat.cetak') . '?' . http_build_query(request()->all()) }}" 
                               class="btn btn-primary btn-sm" target="_blank">
                                <i class="fas fa-print"></i> Cetak Laporan
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Statistik -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-info shadow-sm border-radius-lg">
                        <div class="inner">
                            <h3 class="text-white font-weight-bold">{{ number_format($total_pengajuan) }}</h3>
                            <p class="text-white-50 mb-0">Total Pengajuan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="small-box-footer bg-info-dark">
                            <span class="text-white-50">
                                <i class="fas fa-chart-line mr-1"></i>Data Keseluruhan
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-warning shadow-sm border-radius-lg">
                        <div class="inner">
                            <h3 class="text-white font-weight-bold">{{ number_format($pengajuan_pending) }}</h3>
                            <p class="text-white-50 mb-0">Pending</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="small-box-footer bg-warning-dark">
                            <span class="text-white-50">
                                <i class="fas fa-percentage mr-1"></i>{{ $total_pengajuan > 0 ? number_format(($pengajuan_pending / $total_pengajuan) * 100, 1) : 0 }}%
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-success shadow-sm border-radius-lg">
                        <div class="inner">
                            <h3 class="text-white font-weight-bold">{{ number_format($pengajuan_disetujui) }}</h3>
                            <p class="text-white-50 mb-0">Disetujui</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="small-box-footer bg-success-dark">
                            <span class="text-white-50">
                                <i class="fas fa-percentage mr-1"></i>{{ $total_pengajuan > 0 ? number_format(($pengajuan_disetujui / $total_pengajuan) * 100, 1) : 0 }}%
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-danger shadow-sm border-radius-lg">
                        <div class="inner">
                            <h3 class="text-white font-weight-bold">{{ number_format($pengajuan_ditolak) }}</h3>
                            <p class="text-white-50 mb-0">Ditolak</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times"></i>
                        </div>
                        <div class="small-box-footer bg-danger-dark">
                            <span class="text-white-50">
                                <i class="fas fa-percentage mr-1"></i>{{ $total_pengajuan > 0 ? number_format(($pengajuan_ditolak / $total_pengajuan) * 100, 1) : 0 }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="card shadow-sm">
                <div class="card-header" style="background: linear-gradient(135deg, #28a745, #20c997); color: white;">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-table mr-2"></i>Data Pengajuan Surat
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-light">Total: {{ number_format($total_pengajuan) }} pengajuan</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover mb-0 w-100" id="laporanSuratTable">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Tanggal Pengajuan</th>
                                    <th class="text-center">NIK</th>
                                    <th>Nama Pemohon</th>
                                    <th class="text-center">Jenis Surat</th>
                                    <th>Keperluan</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Tanggal Diproses</th>
                                    <th>Diproses Oleh</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuan as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center font-monospace">
                                        {{ $item->user->nik ?? $item->nik ?? 'NIK tidak tersedia' }}
                                    </td>
                                    <td class="font-weight-medium">
                                        {{ $item->user->name ?? $item->nama ?? 'Nama tidak tersedia' }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-info">
                                            @if(isset($item->jenisSurat) && $item->jenisSurat)
                                                {{ $item->jenisSurat->nama_surat }}
                                            @elseif(isset($item->jenis_surat_id))
                                                @php
                                                    $jenisSuratData = \App\Models\JenisSurat::find($item->jenis_surat_id);
                                                @endphp
                                                {{ $jenisSuratData ? $jenisSuratData->nama_surat : 'ID: ' . $item->jenis_surat_id . ' tidak ditemukan' }}
                                            @else
                                                Tidak ada jenis surat
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $item->keperluan ?? 'Tidak ada keperluan yang disebutkan' }}">
                                            {{ $item->keperluan ?? 'Tidak disebutkan' }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($item->status == 'pending' || $item->status == 'menunggu' || $item->status == 'Menunggu')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock mr-1"></i>Menunggu
                                            </span>
                                        @elseif($item->status == 'diproses' || $item->status == 'Diproses')
                                            <span class="badge badge-info">
                                                <i class="fas fa-cog mr-1"></i>Diproses
                                            </span>
                                        @elseif($item->status == 'approved' || $item->status == 'disetujui' || $item->status == 'selesai' || $item->status == 'Selesai')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check mr-1"></i>Selesai
                                            </span>
                                        @elseif($item->status == 'rejected' || $item->status == 'ditolak' || $item->status == 'Ditolak')
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times mr-1"></i>Ditolak
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-question mr-1"></i>{{ ucfirst($item->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($item->tanggal_diproses_lurah)
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal_diproses_lurah)->format('d/m/Y H:i') }}</small>
                                        @elseif($item->tanggal_diproses_petugas)
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal_diproses_petugas)->format('d/m/Y H:i') }}</small>
                                        @elseif($item->tanggal_diproses)
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal_diproses)->format('d/m/Y H:i') }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->lurah)
                                            <small class="text-success">
                                                <i class="fas fa-user-tie mr-1"></i>
                                                {{ $item->lurah->name ?? 'Lurah' }}
                                            </small>
                                        @elseif($item->petugas)
                                            <small class="text-info">
                                                <i class="fas fa-user mr-1"></i>
                                                {{ $item->petugas->name ?? 'Petugas' }}
                                            </small>
                                        @elseif($item->diproses_user)
                                            <small class="text-primary">
                                                <i class="fas fa-user mr-1"></i>
                                                {{ $item->diproses_user->name ?? 'Admin' }}
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('surat.show', $item->id) }}" 
                                           class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <br>
                                        <strong>Tidak ada data pengajuan surat</strong>
                                        <br>
                                        <small>Silakan ajukan surat atau ubah filter pencarian</small>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('css')
<style>
/* Card styling */
.card {
    border-radius: 10px;
    border: none;
    margin-bottom: 10px;
}

.card-success .card-header {
    background: linear-gradient(135deg, #28a745, #20c997);
    border-color: #20c997;
    border-radius: 10px 10px 0 0;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

/* Force full width layout */
.main-header,
.main-sidebar,
.content-wrapper {
    margin-left: 0 !important;
    padding-left: 0 !important;
}

/* Hide sidebar space completely */
body.sidebar-mini.sidebar-collapse .content-wrapper {
    margin-left: 0 !important;
}

body.sidebar-mini .content-wrapper {
    margin-left: 0 !important;
}

/* Maximize page width */
.wrapper {
    overflow: hidden;
}

.content-wrapper {
    width: 100vw !important;
    margin-left: 0 !important;
}

/* Table enhancements */
.table-responsive {
    border-radius: 8px;
    overflow: hidden;
}

.table {
    margin-bottom: 0;
    font-size: 13px;
}

.table th {
    background-color: #f8f9fa;
    border-top: none;
    font-weight: 600;
    vertical-align: middle;
    white-space: nowrap;
}

.table td {
    vertical-align: middle;
    padding: 8px 12px;
}

.table tbody tr:hover {
    background-color: rgba(40, 167, 69, 0.05);
}

.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.badge {
    font-size: 11px;
    padding: 4px 8px;
}

/* DataTables customization */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: 4px;
    margin: 0 2px;
}

.dataTables_wrapper .dataTables_info {
    font-size: 12px;
    color: #6c757d;
}

.dataTables_wrapper .dataTables_length select {
    border-radius: 4px;
    border: 1px solid #ced4da;
}

.dataTables_wrapper .dataTables_filter input {
    border-radius: 4px;
    border: 1px solid #ced4da;
    padding: 4px 8px;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 11px;
    }
    
    .card-body {
        padding: 10px;
    }
    
    .btn-sm {
        font-size: 10px;
        padding: 2px 6px;
    }
}

/* Small box enhancements */
.small-box {
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s ease;
    position: relative;
    display: block;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}

.small-box:hover {
    transform: translateY(-2px);
}

.small-box .icon {
    transition: all .3s linear;
    position: absolute;
    top: -10px;
    right: 10px;
    z-index: 0;
    font-size: 90px;
    color: rgba(0,0,0,0.15);
}

.small-box .inner {
    position: relative;
    z-index: 1;
    padding: 10px;
}

.border-radius-lg {
    border-radius: 10px !important;
}

.small-box .small-box-footer {
    padding: 8px 15px;
    font-size: 12px;
}

.bg-info-dark {
    background-color: #138496 !important;
}

.bg-warning-dark {
    background-color: #e0a800 !important;
}

.bg-success-dark {
    background-color: #1e7e34 !important;
}

.bg-danger-dark {
    background-color: #bd2130 !important;
}

/* Table styling */
.table-responsive {
    overflow-x: auto;
    width: 100%;
    border-radius: 0 0 10px 10px;
    margin: 0;
}

#laporanSuratTable {
    width: 100% !important;
    font-size: 14px;
    margin: 0;
}

.table {
    margin-bottom: 0;
    width: 100%;
}

.table thead th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    color: #495057;
    vertical-align: middle;
    white-space: nowrap;
    padding: 8px 6px;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

.table td {
    vertical-align: middle;
    padding: 8px 6px;
}

.font-monospace {
    font-family: 'Courier New', monospace;
    font-size: 12px;
}

.font-weight-medium {
    font-weight: 500;
}

/* DataTables styling */
.dataTables_wrapper {
    padding: 10px 5px;
    width: 100%;
    margin: 0;
}

.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate {
    margin-bottom: 8px;
}

.dataTables_wrapper .dataTables_length select {
    border-radius: 4px;
    border: 1px solid #ced4da;
    padding: 2px 6px;
}

.dataTables_wrapper .dataTables_filter input {
    border-radius: 4px;
    border: 1px solid #ced4da;
    padding: 4px 8px;
}

.dataTables_info {
    padding-top: 8px !important;
}

.dataTables_paginate {
    padding-top: 8px !important;
}

/* Form styling */
.form-control-sm {
    border-radius: 4px;
    border: 1px solid #ced4da;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control-sm:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.form-group label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 5px;
}

.card-footer.bg-light {
    background-color: #f8f9fa !important;
    border-top: 1px solid #dee2e6;
}

/* Badge enhancements */
.badge {
    font-size: 11px;
    padding: 4px 8px;
    border-radius: 4px;
}

/* Fix for missing elements and layout issues */
.content-wrapper {
    min-height: calc(100vh - 120px);
    margin-left: 0 !important;
    padding-left: 0 !important;
}

.container-fluid {
    padding-left: 5px !important;
    padding-right: 5px !important;
    max-width: 100% !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
}

/* Override AdminLTE sidebar spacing */
.content-wrapper, .right-side {
    margin-left: 0 !important;
}

body.sidebar-collapse .content-wrapper, 
body.sidebar-collapse .right-side {
    margin-left: 0 !important;
}

/* Maximize content width */
.content {
    padding: 10px 5px !important;
}

/* Ensure all Bootstrap classes work properly */
.row {
    margin-right: -5px;
    margin-left: -5px;
}

.col-lg-3, .col-lg-4, .col-md-6, .col-sm-6, .col-sm-12 {
    position: relative;
    width: 100%;
    padding-right: 5px;
    padding-left: 5px;
}

.card-body.p-0 {
    padding: 0 !important;
}

/* Ensure proper spacing */
.mb-4 {
    margin-bottom: 1.5rem !important;
}

/* Fix any potential layout breaks */
.table-hover-effect {
    background-color: #f8f9fa !important;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .small-box .inner h3 {
        font-size: 24px;
    }
    
    .btn-group {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }
    
    .btn-group .btn {
        margin-right: 0;
        flex: 1;
        min-width: 100px;
    }
    
    .table td {
        padding: 8px 4px;
        font-size: 12px;
    }
}

@media (max-width: 576px) {
    .card-body {
        padding: 15px;
    }
    
    .small-box .inner h3 {
        font-size: 20px;
    }
    
    .small-box .inner p {
        font-size: 12px;
    }
}
</style>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Destroy existing DataTable if it exists
    if ($.fn.DataTable.isDataTable('#laporanSuratTable')) {
        $('#laporanSuratTable').DataTable().destroy();
    }
    
    // Initialize DataTable with enhanced features
    $('#laporanSuratTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "scrollX": true,
        "pageLength": 25,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
        "processing": true,
        "deferRender": true,
        "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
               '<"row"<"col-sm-12"tr>>' +
               '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "processing": "Memproses data...",
            "loadingRecords": "Memuat data...",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            },
            "emptyTable": "Tidak ada data pengajuan surat yang tersedia",
            "zeroRecords": "Tidak ditemukan data yang sesuai dengan pencarian Anda"
        },
        "columnDefs": [
            { "width": "4%", "targets": 0, "className": "text-center" },  // No
            { "width": "12%", "targets": 1, "className": "text-center" }, // Tanggal Pengajuan
            { "width": "10%", "targets": 2, "className": "text-center" }, // NIK
            { "width": "15%", "targets": 3 },                            // Nama Pemohon
            { "width": "12%", "targets": 4, "className": "text-center" }, // Jenis Surat
            { "width": "20%", "targets": 5 },                            // Keperluan
            { "width": "10%", "targets": 6, "className": "text-center" }, // Status
            { "width": "10%", "targets": 7, "className": "text-center" }, // Tanggal Diproses
            { "width": "12%", "targets": 8 },                            // Diproses Oleh
            { "width": "7%", "targets": 9, "className": "text-center" }   // Aksi
        ],
        "order": [[ 1, "desc" ]],
        "initComplete": function() {
            // Add custom styling after table initialization
            $('.dataTables_filter input').addClass('form-control form-control-sm').attr('placeholder', 'Cari data surat...');
            $('.dataTables_length select').addClass('form-control form-control-sm');
        }
    });

    // Enhanced search functionality
    $('#laporanSuratTable_filter input').on('keyup', function() {
        if (this.value.length >= 3 || this.value.length === 0) {
            $('#laporanSuratTable').DataTable().search(this.value).draw();
        }
    });

    // Tooltip for truncated text
    $('[data-toggle="tooltip"]').tooltip();
    
    // Add hover effect for table rows
    $('#laporanSuratTable tbody').on('mouseenter', 'tr', function() {
        $(this).addClass('table-hover-effect');
    }).on('mouseleave', 'tr', function() {
        $(this).removeClass('table-hover-effect');
    });
});
</script>
@endsection
