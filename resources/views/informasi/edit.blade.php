@extends('layouts.app')

@section('title', 'Edit Informasi')

@section('content')
<div class="content-wrapper" style="margin-left: 0 !important;">
    <div class="content-header">
        <div class="container-fluid" style="padding-left: 5px; padding-right: 5px; max-width: 100%;">
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
        <div class="container-fluid" style="padding-left: 5px; padding-right: 5px; max-width: 100%;">
            <div class="card card-primary shadow-sm">
                <div class="card-header" style="background: linear-gradient(135deg, #007bff, #0056b3); border-radius: 10px 10px 0 0;">
                    <h3 class="card-title text-white">
                        <i class="fas fa-edit mr-2"></i>Edit Informasi
                    </h3>
                </div>
                
                <form action="{{ route('informasi.update', $informasi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
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
                                              required>{{ old('konten', $informasi->deskripsi) }}</textarea>
                                    @error('konten')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" 
                                               class="custom-control-input" 
                                               id="is_published" 
                                               name="is_published" 
                                               value="1" 
                                               {{ old('is_published', $informasi->is_published) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_published">Publikasikan</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gambar">Gambar (Opsional)</label>
                                    
                                    @if($informasi->gambar)
                                        <div class="mb-3">
                                            <img src="{{ $informasi->gambar_url }}" class="img-fluid img-thumbnail" alt="Current image" style="max-height: 200px;">
                                            <small class="form-text text-muted d-block">Gambar saat ini</small>
                                        </div>
                                    @endif
                                    
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('gambar') is-invalid @enderror" 
                                               id="gambar" name="gambar" accept="image/*">
                                        <label class="custom-file-label" for="gambar">{{ $informasi->gambar ? 'Ganti gambar...' : 'Pilih file...' }}</label>
                                    </div>
                                    <small class="form-text text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
                                    @error('gambar')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light">
                        <div class="btn-group" role="group">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save"></i> Update Informasi
                            </button>
                            <a href="{{ route('informasi.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

.card-primary .card-header {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border-color: #0056b3;
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
    min-height: calc(100vh - 120px);
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

.content-header {
    padding: 15px 5px !important;
}

/* Button styling */
.btn-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border-color: #007bff;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #0056b3, #004085);
    border-color: #004085;
    transform: translateY(-1px);
}

.btn-group .btn {
    margin-right: 5px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

/* Form styling */
.form-control {
    border-radius: 6px;
    border: 1px solid #ced4da;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-group label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 8px;
}

.card-footer.bg-light {
    background-color: #f8f9fa !important;
    border-top: 1px solid #dee2e6;
    border-radius: 0 0 10px 10px;
}

/* Custom control styling */
.custom-control-label {
    font-weight: 500;
    color: #495057;
}

.custom-switch .custom-control-input:checked ~ .custom-control-label::before {
    background-color: #007bff;
    border-color: #007bff;
}

/* Textarea specific styling */
textarea.form-control {
    min-height: 150px;
    resize: vertical;
}

/* Select styling */
select.form-control {
    background-position: right 8px center;
}

/* Responsive improvements */
@media (max-width: 768px) {
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
    
    .content-header h1 {
        font-size: 1.5rem;
    }
}

@media (max-width: 576px) {
    .card-body {
        padding: 15px;
    }
    
    .content-header {
        padding: 10px 5px !important;
    }
}
</style>
@endsection

@section('js')
<script>
// Custom file input label update
$('#gambar').on('change', function() {
    var fileName = $(this).val().split('\\').pop();
    $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
});
</script>
@endsection
