@extends('layouts.app')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Manajemen Users</a></li>
    <li class="breadcrumb-item active">Tambah User</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah User Baru</h3>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" 
                               placeholder="Masukkan nama lengkap">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" 
                               placeholder="Masukkan email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nik">NIK <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                               id="nik" name="nik" value="{{ old('nik') }}" 
                               placeholder="Masukkan NIK 16 digit" maxlength="16">
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" 
                               placeholder="Masukkan password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                               id="password_confirmation" name="password_confirmation" 
                               placeholder="Konfirmasi password">
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role">Role <span class="text-danger">*</span></label>
                        <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                            <option value="">Pilih Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
