@extends('layouts.app')

@section('title', 'Tambah Informasi')
@section('page-title', 'Tambah Informasi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('informasi.index') }}">Kelola Informasi</a></li>
    <li class="breadcrumb-item active">Tambah Informasi</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Informasi Baru</h3>
                <div class="card-tools">
                    <a href="{{ route('informasi.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <form action="{{ route('informasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="judul">Judul Informasi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                       id="judul" name="judul" value="{{ old('judul') }}" required>
                                @error('judul')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="deskripsi">Konten Informasi <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                          id="deskripsi" name="deskripsi" rows="8" required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="gambar">Gambar (Opsional)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('gambar') is-invalid @enderror" 
                                           id="gambar" name="gambar" accept="image/*">
                                    <label class="custom-file-label" for="gambar">Pilih file...</label>
                                </div>
                                <small class="form-text text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
                                @error('gambar')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" 
                                           id="is_published" name="is_published" value="1" 
                                           {{ old('is_published', 1) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_published">
                                        Publikasikan sekarang
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="tanggal_publish">Tanggal Publish</label>
                                <input type="date" class="form-control @error('tanggal_publish') is-invalid @enderror" 
                                       id="tanggal_publish" name="tanggal_publish" 
                                       value="{{ old('tanggal_publish', date('Y-m-d')) }}">
                                @error('tanggal_publish')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('informasi.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Custom file input
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });
});
</script>
@endpush
