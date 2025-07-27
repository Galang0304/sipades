@extends('layouts.app')

@section('title', 'Tambah Penduduk')
@section('page-title', 'Tambah Penduduk')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('penduduk.index') }}">Data Penduduk</a></li>
    <li class="breadcrumb-item active">Tambah Penduduk</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Tambah Penduduk</h3>
            </div>
            <form action="{{ route('penduduk.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nik">NIK <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                                       id="nik" name="nik" value="{{ old('nik') }}" 
                                       placeholder="Masukkan NIK" maxlength="16">
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                       id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" 
                                       placeholder="Masukkan nama lengkap">
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                       id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" 
                                       placeholder="Masukkan tempat lahir">
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                       id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-control @error('jenis_kelamin') is-invalid @enderror" 
                                        id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="">Pilih jenis kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status_kawin">Status Kawin</label>
                                <select class="form-control @error('status_kawin') is-invalid @enderror" 
                                        id="status_kawin" name="status_kawin">
                                    <option value="">Pilih status kawin</option>
                                    <option value="Belum Kawin" {{ old('status_kawin') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                    <option value="Kawin" {{ old('status_kawin') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                    <option value="Cerai Hidup" {{ old('status_kawin') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                    <option value="Cerai Mati" {{ old('status_kawin') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                </select>
                                @error('status_kawin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="agama">Agama</label>
                                <select class="form-control @error('agama') is-invalid @enderror" 
                                        id="agama" name="agama">
                                    <option value="">Pilih agama</option>
                                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                                @error('agama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pekerjaan">Pekerjaan</label>
                                <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" 
                                       id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" 
                                       placeholder="Masukkan pekerjaan">
                                @error('pekerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="3" 
                                  placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rt">RT</label>
                                <input type="text" class="form-control @error('rt') is-invalid @enderror" 
                                       id="rt" name="rt" value="{{ old('rt') }}" 
                                       placeholder="Masukkan RT">
                                @error('rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rw">RW</label>
                                <input type="text" class="form-control @error('rw') is-invalid @enderror" 
                                       id="rw" name="rw" value="{{ old('rw') }}" 
                                       placeholder="Masukkan RW">
                                @error('rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('penduduk.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
