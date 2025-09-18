@extends('layouts.app')

@section('title', 'Statistik Surat')
@section('page-title', '📊 Statistik Surat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('laporan.surat') }}">Laporan</a></li>
    <li class="breadcrumb-item active">Statistik Surat</li>
@endsection

@section('content')
<div class="container-fluid">
            
            <!-- Filter Section -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-filter"></i> Filter Data</h3>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('statistik.surat') }}" id="filterForm">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tahun</label>
                                            <select name="tahun" class="form-control" id="tahunSelect">
                                                @foreach($tahunList as $year)
                                                    <option value="{{ $year }}" {{ $tahun == $year ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Bulan</label>
                                            <select name="bulan" class="form-control" id="bulanSelect">
                                                <option value="all" {{ $bulan == 'all' ? 'selected' : '' }}>Semua Bulan</option>
                                                <option value="1" {{ $bulan == '1' ? 'selected' : '' }}>Januari</option>
                                                <option value="2" {{ $bulan == '2' ? 'selected' : '' }}>Februari</option>
                                                <option value="3" {{ $bulan == '3' ? 'selected' : '' }}>Maret</option>
                                                <option value="4" {{ $bulan == '4' ? 'selected' : '' }}>April</option>
                                                <option value="5" {{ $bulan == '5' ? 'selected' : '' }}>Mei</option>
                                                <option value="6" {{ $bulan == '6' ? 'selected' : '' }}>Juni</option>
                                                <option value="7" {{ $bulan == '7' ? 'selected' : '' }}>Juli</option>
                                                <option value="8" {{ $bulan == '8' ? 'selected' : '' }}>Agustus</option>
                                                <option value="9" {{ $bulan == '9' ? 'selected' : '' }}>September</option>
                                                <option value="10" {{ $bulan == '10' ? 'selected' : '' }}>Oktober</option>
                                                <option value="11" {{ $bulan == '11' ? 'selected' : '' }}>November</option>
                                                <option value="12" {{ $bulan == '12' ? 'selected' : '' }}>Desember</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Jenis Surat</label>
                                            <select name="jenis_surat" class="form-control" id="jenisSuratSelect">
                                                <option value="all" {{ $jenis_surat == 'all' ? 'selected' : '' }}>Semua Jenis Surat</option>
                                                @foreach($jenisSuratList as $jenis)
                                                    <option value="{{ $jenis->id }}" {{ $jenis_surat == $jenis->id ? 'selected' : '' }}>
                                                        {{ $jenis->nama_surat }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <i class="fas fa-search"></i> Filter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $statistikJenisSurat->sum('total') }}</h3>
                            <p>Total Pengajuan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $statistikStatus->where('status', 'Selesai')->first()->total ?? 0 }}</h3>
                            <p>Surat Selesai</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $statistikStatus->whereIn('status', ['Menunggu', 'Diproses'])->sum('total') }}</h3>
                            <p>Dalam Proses</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $statistikStatus->where('status', 'Ditolak')->first()->total ?? 0 }}</h3>
                            <p>Surat Ditolak</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row">
                <!-- Chart Jenis Surat -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar"></i> 
                                Statistik Berdasarkan Jenis Surat
                                @if($bulan !== 'all')
                                    - {{ $bulan == '1' ? 'Januari' : ($bulan == '2' ? 'Februari' : ($bulan == '3' ? 'Maret' : ($bulan == '4' ? 'April' : ($bulan == '5' ? 'Mei' : ($bulan == '6' ? 'Juni' : ($bulan == '7' ? 'Juli' : ($bulan == '8' ? 'Agustus' : ($bulan == '9' ? 'September' : ($bulan == '10' ? 'Oktober' : ($bulan == '11' ? 'November' : 'Desember')))))))))) }} {{ $tahun }}
                                @else
                                    - Tahun {{ $tahun }}
                                @endif
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="position: relative; height: 400px;">
                                <canvas id="jenisSuratChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart Status -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie"></i> Status Surat
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="position: relative; height: 300px;">
                                <canvas id="statusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Chart -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line"></i> 
                                Tren Pengajuan Surat Bulanan - Tahun {{ $tahun }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="position: relative; height: 300px;">
                                <canvas id="monthlyChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-table"></i> Detail Data Statistik
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Surat</th>
                                            <th>Kode Surat</th>
                                            <th>Jumlah Pengajuan</th>
                                            <th>Persentase</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $totalAll = $statistikJenisSurat->sum('total'); @endphp
                                        @foreach($statistikJenisSurat as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item['nama_surat'] }}</td>
                                            <td><span class="badge badge-info">{{ $item['kode_surat'] }}</span></td>
                                            <td><strong>{{ $item['total'] }}</strong></td>
                                            <td>
                                                @php $percentage = $totalAll > 0 ? round(($item['total'] / $totalAll) * 100, 1) : 0; @endphp
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-primary" style="width: {{ $percentage }}%"></div>
                                                </div>
                                                {{ $percentage }}%
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

        </div>

</div>
@endsection

@push('styles')
<style>
    /* Statistics page specific styling */
    
    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
    }
    
    .chart-container {
        position: relative;
        margin: auto;
        height: 400px;
        width: 100%;
        padding: 10px;
    }
    
    .small-box .icon {
        font-size: 70px;
    }
    
    .progress {
        height: 20px;
    }
    
    /* Chart specific styling */
    #jenisSuratChart {
        max-height: 400px;
    }
    
    #statusChart {
        max-height: 300px;
    }
    
    #monthlyChart {
        max-height: 300px;
    }
    
    /* Card styling improvements */
    .card {
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        margin-bottom: 0.75rem;
    }
    
    .card-header {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border-bottom: none;
        padding: 0.75rem 1.25rem;
    }
    
    .card-header h3 {
        margin: 0;
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    /* Filter section styling */
    .card-body {
        padding: 1rem;
    }
    
    /* Statistics cards improvements */
    .small-box {
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.3s ease;
        margin-bottom: 0.75rem;
    }
    
    .small-box:hover {
        transform: translateY(-5px);
    }
    
    /* Table improvements */
    .table {
        margin-bottom: 0;
    }
    
    .table th {
        border-top: none;
        background-color: #f8f9fa;
        font-weight: 600;
    }
    
    /* Row spacing adjustments */
    .row {
        margin-left: -7.5px;
        margin-right: -7.5px;
    }
    
    .row > .col,
    .row > [class*="col-"] {
        padding-left: 7.5px;
        padding-right: 7.5px;
    }
    
    /* Remove extra margins */
    .mb-3 {
        margin-bottom: 0.75rem !important;
    }
    
    .mb-4 {
        margin-bottom: 1rem !important;
    }
    
    .mt-4 {
        margin-top: 1rem !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .chart-container {
            height: 300px;
            padding: 5px;
        }
        
        .small-box .icon {
            font-size: 50px;
        }
        
        .content-header {
            padding: 0.5rem 1rem;
        }
        
        .content {
            padding: 0.5rem;
        }
        
        .card-body {
            padding: 0.75rem;
        }
    }
</style>
@endpush

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {
    // Auto submit form when filter changes
    $('#tahunSelect, #bulanSelect, #jenisSuratSelect').change(function() {
        $('#filterForm').submit();
    });

    // Chart colors
    const colors = [
        '#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1', 
        '#fd7e14', '#20c997', '#6c757d', '#e83e8c', '#17a2b8'
    ];

    // Data for charts
    const jenisSuratData = @json($statistikJenisSurat);
    const statusData = @json($statistikStatus);
    const monthlyData = @json($statistikBulanan);

    // Jenis Surat Bar Chart
    const jenisSuratCtx = document.getElementById('jenisSuratChart').getContext('2d');
    new Chart(jenisSuratCtx, {
        type: 'bar',
        data: {
            labels: jenisSuratData.map(item => item.kode_surat), // Use shorter code instead of full name
            datasets: [{
                label: 'Jumlah Pengajuan',
                data: jenisSuratData.map(item => item.total),
                backgroundColor: colors.slice(0, jenisSuratData.length),
                borderColor: colors.slice(0, jenisSuratData.length),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Jumlah Pengajuan Surat per Jenis',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                },
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            const index = context[0].dataIndex;
                            return jenisSuratData[index].nama_surat;
                        },
                        label: function(context) {
                            return 'Jumlah: ' + context.parsed.y + ' pengajuan';
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 0,
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                }
            },
            layout: {
                padding: {
                    top: 20,
                    bottom: 20,
                    left: 10,
                    right: 10
                }
            }
        }
    });

    // Status Pie Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: statusData.map(item => item.status),
            datasets: [{
                data: statusData.map(item => item.total),
                backgroundColor: ['#ffc107', '#007bff', '#28a745', '#dc3545'],
                borderWidth: 3,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        },
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = statusData.reduce((sum, item) => sum + item.total, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            },
            layout: {
                padding: {
                    top: 10,
                    bottom: 10
                }
            }
        }
    });

    // Monthly Line Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthlyData.map(item => item.nama_bulan.substring(0, 3)), // Shorten month names
            datasets: [{
                label: 'Jumlah Pengajuan',
                data: monthlyData.map(item => item.total),
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#28a745',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Tren Pengajuan Surat per Bulan',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                },
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 12
                        },
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            const index = context[0].dataIndex;
                            return monthlyData[index].nama_bulan;
                        },
                        label: function(context) {
                            return 'Jumlah Pengajuan: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                }
            },
            layout: {
                padding: {
                    top: 20,
                    bottom: 10,
                    left: 10,
                    right: 10
                }
            }
        }
    });
});
</script>
@endpush
