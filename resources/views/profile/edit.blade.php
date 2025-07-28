@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-primary">
                    <i class="fas fa-user-edit mr-2"></i>Edit Profile
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Edit Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-circle"></i>
                    Form Edit Profile
                </h3>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    
                    <!-- Data Akun -->
                    <h5 class="text-primary mb-3">
                        <i class="fas fa-key"></i> Data Akun
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" 
                                       placeholder="Masukkan nama lengkap" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" 
                                       placeholder="Masukkan email" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" 
                                       placeholder="Konfirmasi password baru">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="foto_profil">
                                    <i class="fas fa-camera"></i> Foto Profil
                                </label>
                                
                                <!-- Card foto profil yang keren -->
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body p-4">
                                        <div class="row align-items-center">
                                            <div class="col-md-3 text-center">
                                                <!-- Preview foto profil -->
                                                <div class="position-relative d-inline-block">
                                                    @if($user->foto_profil)
                                                        <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" 
                                                             id="profilePreview"
                                                             class="img-fluid rounded-circle shadow" 
                                                             style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff;">
                                                    @else
                                                        <div id="profilePreview" 
                                                             class="bg-gradient-primary rounded-circle shadow d-flex align-items-center justify-content-center text-white" 
                                                             style="width: 120px; height: 120px; border: 4px solid #fff;">
                                                            <i class="fas fa-user fa-3x"></i>
                                                        </div>
                                                    @endif
                                                    
                                                    <!-- Overlay upload button -->
                                                    <div class="position-absolute" style="bottom: 0; right: 0;">
                                                        <button type="button" class="btn btn-primary btn-sm rounded-circle shadow-sm" 
                                                                onclick="document.getElementById('foto_profil').click()" 
                                                                style="width: 35px; height: 35px;">
                                                            <i class="fas fa-camera"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-9">
                                                <h5 class="mb-2 text-primary">Upload Foto Profil</h5>
                                                <p class="text-muted mb-3">Pilih foto terbaik Anda untuk profil. Foto akan ditampilkan di seluruh sistem.</p>
                                                
                                                <!-- File input tersembunyi -->
                                                <input type="file" id="foto_profil" name="foto_profil" 
                                                       class="d-none @error('foto_profil') is-invalid @enderror" 
                                                       accept="image/*" onchange="previewImage(this)">
                                                
                                                <!-- Custom file display -->
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="flex-grow-1">
                                                        <div class="border rounded p-2 bg-light">
                                                            <span id="fileName" class="text-muted">
                                                                <i class="fas fa-image mr-2"></i>Belum ada file dipilih
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-outline-primary ml-2" 
                                                            onclick="document.getElementById('foto_profil').click()">
                                                        <i class="fas fa-folder-open"></i> Browse
                                                    </button>
                                                </div>
                                                
                                                <!-- Info dan actions -->
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">
                                                        <i class="fas fa-info-circle"></i> JPG, PNG • Max 2MB
                                                    </small>
                                                    @if($user->foto_profil)
                                                        <button type="button" class="btn btn-outline-danger btn-sm" 
                                                                onclick="removePhoto()">
                                                            <i class="fas fa-trash"></i> Hapus Foto
                                                        </button>
                                                    @endif
                                                </div>
                                                
                                                <!-- Preview status -->
                                                <div id="previewStatus" class="alert alert-info mt-3 d-none">
                                                    <i class="fas fa-info-circle"></i> 
                                                    Foto telah diubah. Klik <strong>"Simpan Perubahan"</strong> untuk menyimpan secara permanen.
                                                </div>
                                                
                                                @error('foto_profil')
                                                    <div class="text-danger mt-2">
                                                        <small><i class="fas fa-exclamation-triangle"></i> {{ $message }}</small>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($penduduk)
                    <hr>

                    <!-- Data Pribadi -->
                    <h5 class="text-primary mb-3">
                        <i class="fas fa-user"></i> Data Pribadi
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                       id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}" 
                                       placeholder="Masukkan tempat lahir">
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                       id="tanggal_lahir" name="tanggal_lahir" 
                                       value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir ? \Carbon\Carbon::parse($penduduk->tanggal_lahir)->format('Y-m-d') : '') }}">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-control @error('jenis_kelamin') is-invalid @enderror" 
                                        id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="">Pilih jenis kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status_perkawinan">Status Perkawinan</label>
                                <select class="form-control @error('status_perkawinan') is-invalid @enderror" 
                                        id="status_perkawinan" name="status_perkawinan">
                                    <option value="">Pilih status perkawinan</option>
                                    <option value="Belum Kawin" {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                    <option value="Kawin" {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                    <option value="Cerai Hidup" {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                    <option value="Cerai Mati" {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                </select>
                                @error('status_perkawinan')
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
                                    <option value="Islam" {{ old('agama', $penduduk->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('agama', $penduduk->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('agama', $penduduk->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('agama', $penduduk->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('agama', $penduduk->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('agama', $penduduk->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
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
                                       id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $penduduk->pekerjaan) }}" 
                                       placeholder="Masukkan pekerjaan">
                                @error('pekerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Data Alamat & Kontak -->
                    <h5 class="text-primary mb-3">
                        <i class="fas fa-map-marker-alt"></i> Data Alamat & Kontak
                    </h5>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="alamat">Alamat Lengkap</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                          id="alamat" name="alamat" rows="3" 
                                          placeholder="Masukkan alamat lengkap">{{ old('alamat', $penduduk->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rt">RT</label>
                                <input type="text" class="form-control @error('rt') is-invalid @enderror" 
                                       id="rt" name="rt" value="{{ old('rt', $penduduk->rt) }}" 
                                       placeholder="Masukkan RT" maxlength="3">
                                @error('rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rw">RW</label>
                                <input type="text" class="form-control @error('rw') is-invalid @enderror" 
                                       id="rw" name="rw" value="{{ old('rw', $penduduk->rw) }}" 
                                       placeholder="Masukkan RW" maxlength="3">
                                @error('rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="no_tlp">No. Telepon</label>
                                <input type="tel" class="form-control @error('no_tlp') is-invalid @enderror" 
                                       id="no_tlp" name="no_tlp" value="{{ old('no_tlp', $penduduk->no_tlp) }}" 
                                       placeholder="Masukkan nomor telepon">
                                @error('no_tlp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="foto_kk">Upload Foto Kartu Keluarga</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('foto_kk') is-invalid @enderror" 
                                           id="foto_kk" name="foto_kk" accept="image/*,.pdf">
                                    <label class="custom-file-label" for="foto_kk">Pilih file foto KK</label>
                                </div>
                                <small class="text-muted">Format: JPG, PNG, PDF (max 2MB)</small>
                                @error('foto_kk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if($penduduk->foto_kk)
                                <div class="form-group">
                                    <label>Foto KK Saat Ini:</label>
                                    <div>
                                        <a href="{{ asset('storage/' . $penduduk->foto_kk) }}" target="_blank" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Lihat Foto KK
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        Data pribadi belum tersedia. Silakan hubungi administrator untuk melengkapi data penduduk Anda.
                    </div>
                    @endif

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Custom file input untuk foto KK (bukan foto profil)
    $('#foto_kk').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass("selected").html(fileName);
    });

    // RT/RW validation
    $('#rt, #rw').on('input', function() {
        this.value = this.value.replace(/\D/g, '');
        if (this.value.length > 3) {
            this.value = this.value.slice(0, 3);
        }
    });

    // Phone validation
    $('#no_tlp').on('input', function() {
        this.value = this.value.replace(/[^0-9+\-\s]/g, '');
    });

    // Form submit handler
    $('form').on('submit', function(e) {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
        submitBtn.prop('disabled', true);
        
        // Hide preview status
        $('#previewStatus').addClass('d-none');
    });
});

// Modern preview image function
function previewImage(input) {
    console.log('previewImage function called', input);
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        console.log('File selected:', file.name, file.size, file.type);
        
        // Validasi ukuran file (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('File terlalu besar! Maksimal 2MB.');
            input.value = '';
            return;
        }

        // Validasi tipe file
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!validTypes.includes(file.type)) {
            alert('Format file tidak valid! Gunakan JPG, JPEG, atau PNG.');
            input.value = '';
            return;
        }

        // Preview image
        const reader = new FileReader();
        reader.onload = function(e) {
            console.log('FileReader loaded, updating preview...');
            
            // Update preview
            $('#profilePreview').replaceWith(
                '<img src="' + e.target.result + '" alt="Foto Profil" id="profilePreview" ' +
                'class="img-fluid rounded-circle shadow" ' +
                'style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff;">'
            );
            
            // Update navbar photo (live preview)
            $('.navbar .img-circle').attr('src', e.target.result);
            
            // Show filename
            $('#fileName').html('<i class="fas fa-image text-success mr-2"></i>' + file.name);
            
            // Show preview status
            $('#previewStatus').removeClass('d-none');
            
            console.log('Preview updated successfully!');
            
            // Simple alert instead of SweetAlert for testing
            alert('Preview foto berhasil diupdate!');
        };
        
        reader.readAsDataURL(file);
    } else {
        console.log('No file selected or files array empty');
    }
}

// Remove photo function
function removePhoto() {
    if (confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
        // Reset input
        document.getElementById('foto_profil').value = '';
        
        // Reset preview
        $('#profilePreview').replaceWith(
            '<div id="profilePreview" ' +
            'class="bg-gradient-primary rounded-circle shadow d-flex align-items-center justify-content-center text-white" ' +
            'style="width: 120px; height: 120px; border: 4px solid #fff;">' +
            '<i class="fas fa-user fa-3x"></i>' +
            '</div>'
        );
        
        // Reset navbar
        $('.navbar .img-circle').attr('src', '{{ asset("images/default-avatar.svg") }}');
        
        // Reset filename
        $('#fileName').html('<i class="fas fa-image mr-2"></i>Belum ada file dipilih');
        
        // Hide preview status
        $('#previewStatus').addClass('d-none');
        
        alert('Foto profil telah dihapus dari preview.');
    }
}
</script>
@endsection
