@extends('layouts.app')

@section('title', 'Detail Penduduk')
@section('page-title', 'Detail Penduduk')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('penduduk.index') }}">Data Penduduk</a></li>
    <li class="breadcrumb-item active">Detail Penduduk</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Data Penduduk</h3>
                <div class="card-tools">
                    @can('manage-penduduk')
                    <a href="{{ route('penduduk.edit', $penduduk->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    @endcan
                    <a href="{{ route('penduduk.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>NIK</strong></td>
                                <td>: {{ $penduduk->nik }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Lengkap</strong></td>
                                <td>: {{ $penduduk->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tempat Lahir</strong></td>
                                <td>: {{ $penduduk->tempat_lahir }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Lahir</strong></td>
                                <td>: {{ \Carbon\Carbon::parse($penduduk->tanggal_lahir)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Umur</strong></td>
                                <td>: {{ $penduduk->umur }} tahun</td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Kelamin</strong></td>
                                <td>: {{ $penduduk->jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status Perkawinan</strong></td>
                                <td>: {{ $penduduk->status_perkawinan ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Agama</strong></td>
                                <td>: {{ $penduduk->agama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pekerjaan</strong></td>
                                <td>: {{ $penduduk->pekerjaan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Alamat</strong></td>
                                <td>: {{ $penduduk->alamat }}</td>
                            </tr>
                            <tr>
                                <td><strong>RT</strong></td>
                                <td>: {{ $penduduk->rt ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>RW</strong></td>
                                <td>: {{ $penduduk->rw ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Dibuat Pada</strong></td>
                                <td>: {{ $penduduk->created_at->format('d F Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Diupdate Pada</strong></td>
                                <td>: {{ $penduduk->updated_at->format('d F Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($penduduk->user)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Akun Pengguna</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Nama</strong></td>
                                <td>: {{ $penduduk->user->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>: {{ $penduduk->user->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Role</strong></td>
                                <td>: {{ $penduduk->user->role_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>: 
                                    @if($penduduk->user->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
