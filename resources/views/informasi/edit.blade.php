@extends('layouts.app')

@section('title', 'Edit Informasi')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Informasi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('informasi.index') }}">Kelola Informasi</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Informasi</h3>
                </div>
                
                <form action="{{ route('informasi.update', $informasi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" 
                                   class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" 
                                   name="judul" 
                                   value="{{ old('judul', $informasi->judul) }}" 
                                   required>
                            @error('judul')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select class="form-control @error('kategori') is-invalid @enderror" 
                                    id="kategori" 
                                    name="kategori" 
                                    required>
                                <option value="">Pilih Kategori</option>
                                <option value="pengumuman" {{ old('kategori', $informasi->kategori) == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                <option value="berita" {{ old('kategori', $informasi->kategori) == 'berita' ? 'selected' : '' }}>Berita</option>
                                <option value="layanan" {{ old('kategori', $informasi->kategori) == 'layanan' ? 'selected' : '' }}>Layanan</option>
                                <option value="profil" {{ old('kategori', $informasi->kategori) == 'profil' ? 'selected' : '' }}>Profil Desa</option>
                            </select>
                            @error('kategori')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="konten">Konten</label>
                            <textarea class="form-control @error('konten') is-invalid @enderror" 
                                      id="konten" 
                                      name="konten" 
                                      rows="10" 
                                      required>{{ old('konten', $informasi->konten) }}</textarea>
                            @error('konten')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" 
                                       class="custom-control-input" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', $informasi->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Publikasikan</label>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Informasi
                        </button>
                        <a href="{{ route('informasi.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
.card-primary .card-header {
    background-color: #28a745;
    border-color: #20c997;
}
.btn-primary {
    background-color: #28a745;
    border-color: #28a745;
}
.btn-primary:hover {
    background-color: #218838;
    border-color: #1e7e34;
}
</style>
@endsection
