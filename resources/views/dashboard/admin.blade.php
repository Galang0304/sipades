@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="alert alert-success">
            <h5><i class="icon fas fa-check"></i> Login Berhasil!</h5>
            Selamat datang di SIPADES, {{ auth()->user()->name }}!
        </div>
    </div>
</div>

<div class="row">
    <!-- Info boxes -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Penduduk</span>
                <span class="info-box-number">{{ $stats['total_penduduk'] ?? 0 }}</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-cog"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Users</span>
                <span class="info-box-number">{{ $stats['total_users'] }}</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-file-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Surat Proses</span>
                <span class="info-box-number">{{ $stats['surat_proses'] }}</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Surat Selesai</span>
                <span class="info-box-number">{{ $stats['surat_selesai'] }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <!-- Recent Surat -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pengajuan Surat Terbaru</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jenis Surat</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_surat as $surat)
                                <tr>
                                    <td>{{ $surat->user->name }}</td>
                                    <td>{{ $surat->jenis_surat->nama_surat }}</td>
                                    <td>
                                        <span class="badge {{ $surat->status_badge }}">{{ $surat->status }}</span>
                                    </td>
                                    <td>{{ $surat->formatted_tanggal_pengajuan }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data</td>
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
