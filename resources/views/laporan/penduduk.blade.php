
@extends('layouts.app')

@section('title', 'Laporan Data Penduduk')
@section('page-title', 'Laporan Data Penduduk')
@section('breadcrumb')
    <li class="breadcrumb-item active">Laporan Penduduk</li>
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
                <form method="GET" action="{{ route('laporan.penduduk') }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="jenis_kelamin"><i class="fas fa-venus-mars mr-1"></i>Jenis Kelamin</label>
                                    <select class="form-control form-control-sm" id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="">Semua</option>
                                        <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="rt"><i class="fas fa-map-marker-alt mr-1"></i>RT</label>
                                    <select class="form-control form-control-sm" id="rt" name="rt">
                                        <option value="">Semua RT</option>
                                        @foreach($rt_list as $rt)
                                            <option value="{{ $rt }}" {{ request('rt') == $rt ? 'selected' : '' }}>
                                                RT {{ $rt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="rw"><i class="fas fa-map-marker-alt mr-1"></i>RW</label>
                                    <select class="form-control form-control-sm" id="rw" name="rw">
                                        <option value="">Semua RW</option>
                                        @foreach($rw_list as $rw)
                                            <option value="{{ $rw }}" {{ request('rw') == $rw ? 'selected' : '' }}>
                                                RW {{ $rw }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="agama"><i class="fas fa-pray mr-1"></i>Agama</label>
                                    <select class="form-control form-control-sm" id="agama" name="agama">
                                        <option value="">Semua Agama</option>
                                        @foreach($agama_list as $agama)
                                            <option value="{{ $agama }}" {{ request('agama') == $agama ? 'selected' : '' }}>
                                                {{ $agama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="umur_min"><i class="fas fa-birthday-cake mr-1"></i>Umur Min</label>
                                    <input type="number" class="form-control form-control-sm" id="umur_min" name="umur_min" 
                                           value="{{ request('umur_min') }}" placeholder="0" min="0" max="150">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="umur_max"><i class="fas fa-birthday-cake mr-1"></i>Umur Max</label>
                                    <input type="number" class="form-control form-control-sm" id="umur_max" name="umur_max" 
                                           value="{{ request('umur_max') }}" placeholder="100" min="0" max="150">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="btn-group" role="group">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <a href="{{ route('laporan.penduduk') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-undo"></i> Reset
                            </a>
                            <a href="{{ route('laporan.penduduk.cetak') . '?' . http_build_query(request()->all()) }}" 
                               class="btn btn-primary btn-sm" target="_blank">
                                <i class="fas fa-print"></i> Cetak Laporan
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Statistik -->
            <div class="row mb-4">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="small-box bg-info shadow-sm border-radius-lg">
                        <div class="inner">
                            <h3 class="text-white font-weight-bold">{{ number_format($total_penduduk) }}</h3>
                            <p class="text-white-50 mb-0">Total Penduduk</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="small-box-footer bg-info-dark">
                            <span class="text-white-50">
                                <i class="fas fa-chart-line mr-1"></i>Data Keseluruhan
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="small-box bg-primary shadow-sm border-radius-lg">
                        <div class="inner">
                            <h3 class="text-white font-weight-bold">{{ number_format($total_laki) }}</h3>
                            <p class="text-white-50 mb-0">Laki-laki</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-male"></i>
                        </div>
                        <div class="small-box-footer bg-primary-dark">
                            <span class="text-white-50">
                                <i class="fas fa-percentage mr-1"></i>{{ $total_penduduk > 0 ? number_format(($total_laki / $total_penduduk) * 100, 1) : 0 }}%
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="small-box bg-pink shadow-sm border-radius-lg">
                        <div class="inner">
                            <h3 class="text-white font-weight-bold">{{ number_format($total_perempuan) }}</h3>
                            <p class="text-white-50 mb-0">Perempuan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-female"></i>
                        </div>
                        <div class="small-box-footer bg-pink-dark">
                            <span class="text-white-50">
                                <i class="fas fa-percentage mr-1"></i>{{ $total_penduduk > 0 ? number_format(($total_perempuan / $total_penduduk) * 100, 1) : 0 }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="card shadow-sm">
                <div class="card-header" style="background: linear-gradient(135deg, #28a745, #20c997); color: white;">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-table mr-2"></i>Data Penduduk
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-light">Total: {{ number_format($total_penduduk) }} orang</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover mb-0 w-100" id="laporanPendudukTable">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">NIK</th>
                                    <th>Nama</th>
                                    <th class="text-center">Jenis Kelamin</th>
                                    <th>Tempat, Tanggal Lahir</th>
                                    <th>Alamat</th>
                                    <th class="text-center">RT/RW</th>
                                    <th class="text-center">Agama</th>
                                    <th class="text-center">Status Perkawinan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($penduduk as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center font-monospace">{{ $item->nik }}</td>
                                    <td class="font-weight-medium">{{ $item->nama_lengkap }}</td>
                                    <td class="text-center">
                                        @if($item->jenis_kelamin == 'Laki-laki')
                                            <span class="badge badge-primary">
                                                <i class="fas fa-male mr-1"></i>{{ $item->jenis_kelamin }}
                                            </span>
                                        @else
                                            <span class="badge badge-pink">
                                                <i class="fas fa-female mr-1"></i>{{ $item->jenis_kelamin }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $item->tempat_lahir }}, {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}</td>
                                    <td class="text-truncate" style="max-width: 200px;">{{ $item->alamat }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-secondary">{{ $item->rt ?? '-' }}/{{ $item->rw ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">{{ $item->agama }}</td>
                                    <td class="text-center">
                                        <small class="text-muted">{{ $item->status_perkawinan }}</small>
                                    </td>
                                </tr>
                                @endforeach
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

/* Button styling */
.btn-success {
    background: linear-gradient(135deg, #28a745, #20c997);
    border-color: #28a745;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.btn-success:hover {
    background: linear-gradient(135deg, #218838, #1e7e34);
    border-color: #1e7e34;
    transform: translateY(-1px);
}

.btn-group .btn {
    margin-right: 5px;
}

.btn-group .btn:last-child {
    margin-right: 0;
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

.bg-primary-dark {
    background-color: #0056b3 !important;
}

.bg-pink-dark {
    background-color: #c5356b !important;
}

.small-box.bg-pink {
    background-color: #e83e8c !important;
}

.badge-pink {
    background-color: #e83e8c;
    color: white;
}

/* Table styling */
.table-responsive {
    overflow-x: auto;
    width: 100%;
    border-radius: 0 0 10px 10px;
    margin: 0;
}

#laporanPendudukTable {
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

/* DataTables wrapper full width */
.dataTables_wrapper {
    padding: 10px 5px;
    width: 100%;
    margin: 0;
}

.font-monospace {
    font-family: 'Courier New', monospace;
    font-size: 12px;
}

.font-weight-medium {
    font-weight: 500;
}

.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
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

.col-lg-2, .col-lg-4, .col-md-4, .col-md-6, .col-sm-6, .col-sm-12 {
    position: relative;
    width: 100%;
    padding-right: 5px;
    padding-left: 5px;
}

/* Small box positioning fixes */
.small-box {
    position: relative;
    display: block;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
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
    if ($.fn.DataTable.isDataTable('#laporanPendudukTable')) {
        $('#laporanPendudukTable').DataTable().destroy();
    }
    
    // Initialize DataTable with enhanced features
    $('#laporanPendudukTable').DataTable({
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
        "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
               '<"row"<"col-sm-12"tr>>' +
               '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            },
            "emptyTable": "Tidak ada data yang tersedia",
            "zeroRecords": "Tidak ditemukan data yang sesuai"
        },
        "columnDefs": [
            { "width": "5%", "targets": 0, "className": "text-center" },
            { "width": "12%", "targets": 1, "className": "text-center" },
            { "width": "15%", "targets": 2 },
            { "width": "10%", "targets": 3, "className": "text-center" },
            { "width": "15%", "targets": 4 },
            { "width": "20%", "targets": 5 },
            { "width": "8%", "targets": 6, "className": "text-center" },
            { "width": "8%", "targets": 7, "className": "text-center" },
            { "width": "12%", "targets": 8, "className": "text-center" }
        ],
        "order": [[ 1, "asc" ]],
        "initComplete": function() {
            // Add custom styling after table initialization
            $('.dataTables_filter input').addClass('form-control form-control-sm').attr('placeholder', 'Cari data penduduk...');
            $('.dataTables_length select').addClass('form-control form-control-sm');
        }
    });

    // Enhanced search functionality
    $('#laporanPendudukTable_filter input').on('keyup', function() {
        if (this.value.length >= 3 || this.value.length === 0) {
            $('#laporanPendudukTable').DataTable().search(this.value).draw();
        }
    });

    // Tooltip for truncated text
    $('[data-toggle="tooltip"]').tooltip();
    
    // Add hover effect for table rows
    $('#laporanPendudukTable tbody').on('mouseenter', 'tr', function() {
        $(this).addClass('table-hover-effect');
    }).on('mouseleave', 'tr', function() {
        $(this).removeClass('table-hover-effect');
    });
});
</script>
@endsection
