@extends('layouts.app')

@section('title', 'Detail User')
@section('page-title', 'Detail User')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Manajemen Users</a></li>
    <li class="breadcrumb-item active">Detail User</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail User: {{ $user->name }}</h3>
                <div class="card-tools">
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>ID:</strong>
                        <p class="text-muted">{{ $user->id }}</p>

                        <strong>Nama Lengkap:</strong>
                        <p class="text-muted">{{ $user->name }}</p>

                        <strong>Email:</strong>
                        <p class="text-muted">{{ $user->email }}</p>

                        <strong>NIK:</strong>
                        <p class="text-muted">{{ $user->nik ?? '-' }}</p>

                        <strong>Role:</strong>
                        <p class="text-muted">
                            @foreach($user->roles as $role)
                                <span class="badge badge-primary">{{ ucfirst($role->name) }}</span>
                            @endforeach
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p class="text-muted">
                            @if($user->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Tidak Aktif</span>
                            @endif
                        </p>

                        <strong>Email Verified:</strong>
                        <p class="text-muted">
                            @if($user->email_verified_at)
                                <span class="badge badge-success">Terverifikasi</span>
                                <br><small>{{ $user->email_verified_at->format('d/m/Y H:i:s') }}</small>
                            @else
                                <span class="badge badge-warning">Belum Terverifikasi</span>
                            @endif
                        </p>

                        <strong>Tanggal Dibuat:</strong>
                        <p class="text-muted">{{ $user->created_at->format('d/m/Y H:i:s') }}</p>

                        <strong>Terakhir Diupdate:</strong>
                        <p class="text-muted">{{ $user->updated_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>

                @if($user->penduduk)
                <hr>
                <h5>Data Penduduk Terkait</h5>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Nama Lengkap:</strong>
                        <p class="text-muted">{{ $user->penduduk->nama_lengkap }}</p>

                        <strong>Tempat, Tanggal Lahir:</strong>
                        <p class="text-muted">
                            {{ $user->penduduk->tempat_lahir ?? '-' }}, 
                            {{ $user->penduduk->tanggal_lahir ? \Carbon\Carbon::parse($user->penduduk->tanggal_lahir)->format('d/m/Y') : '-' }}
                        </p>

                        <strong>Jenis Kelamin:</strong>
                        <p class="text-muted">{{ $user->penduduk->jenis_kelamin ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Alamat:</strong>
                        <p class="text-muted">{{ $user->penduduk->alamat ?? '-' }}</p>

                        <strong>Pekerjaan:</strong>
                        <p class="text-muted">{{ $user->penduduk->pekerjaan ?? '-' }}</p>

                        <strong>Status Penduduk:</strong>
                        <p class="text-muted">{{ $user->penduduk->status_penduduk ?? '-' }}</p>
                    </div>
                </div>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
