@extends('layouts.auth')

@section('title', 'Register - KUINSEL')

@push('styles')
<style>
    .custom-file-input:lang(en)~.custom-file-label::after {
        content: "Pilih File";
    }
    .custom-file-label {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .custom-file {
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script>
    // Show filename in custom file input
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var label = e.target.nextElementSibling;
            label.textContent = fileName;
        });
    });
</script>
@endpush

@section('content')
<div class="register-box">
    <div class="register-logo">
                <b>KUINSEL</b> Register
    </div>
    <div class="card">
        <div class="card-body register-card-body">
                        <p class="register-box-msg">Daftar akun penduduk baru untuk menggunakan layanan KUINSEL</p>

            <form action="{{ route('register') }}" method="post" enctype="multipart/form-data">
                @csrf
                
                <h5 class="text-center mb-3 text-primary">
                    <i class="fas fa-user-circle"></i> Data Akun
                </h5>
                
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           placeholder="Email" value="{{ old('email') }}" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control" 
                           placeholder="Konfirmasi Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <hr>
                <h5 class="text-center mb-3 text-warning">
                    <i class="fas fa-file-image"></i> Upload Dokumen
                </h5>

                <div class="input-group mb-3">
                    <div class="custom-file flex-grow-1">
                        <input type="file" name="foto_kk" class="custom-file-input @error('foto_kk') is-invalid @enderror" 
                               id="foto_kk" accept="image/*" required>
                        <label class="custom-file-label" for="foto_kk">Pilih file foto Kartu Keluarga</label>
                    </div>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-id-card"></span>
                        </div>
                    </div>
                    @error('foto_kk')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <small class="text-muted mb-3 d-block">
                    <i class="fas fa-info-circle"></i> Upload foto Kartu Keluarga (Format: JPG, PNG, max 2MB)
                </small>

                <hr>
                <h5 class="text-center mb-3 text-success">
                    <i class="fas fa-id-card"></i> Data Penduduk (KTP)
                </h5>

                <div class="input-group mb-3">
                    <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" 
                           placeholder="NIK (16 digit)" value="{{ old('nik') }}" required maxlength="16"
                           pattern="[0-9]{16}" title="NIK harus 16 digit angka">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-id-card"></span>
                        </div>
                    </div>
                    @error('nik')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="text" name="no_kk" class="form-control @error('no_kk') is-invalid @enderror" 
                           placeholder="Nomor Kartu Keluarga" value="{{ old('no_kk') }}" required maxlength="16"
                           pattern="[0-9]{16}" title="No KK harus 16 digit angka">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-users"></span>
                        </div>
                    </div>
                    @error('no_kk')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                              placeholder="Alamat Lengkap" rows="3" required>{{ old('alamat') }}</textarea>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-map-marker-alt"></span>
                        </div>
                    </div>
                    @error('alamat')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="tel" name="no_tlp" class="form-control @error('no_tlp') is-invalid @enderror" 
                           placeholder="Nomor Telepon/HP" value="{{ old('no_tlp') }}" required
                           pattern="[0-9+\-\s]{10,15}" title="Nomor telepon harus 10-15 digit">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-phone"></span>
                        </div>
                    </div>
                    @error('no_tlp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="status_penduduk" class="form-label">
                        <i class="fas fa-user-tag"></i> Status Penduduk
                    </label>
                    <select name="status_penduduk" class="form-control @error('status_penduduk') is-invalid @enderror" required>
                        <option value="">Pilih Status Penduduk</option>
                        <option value="penduduk_tetap" {{ old('status_penduduk') == 'penduduk_tetap' ? 'selected' : '' }}>Penduduk Tetap</option>
                        <option value="pindahan" {{ old('status_penduduk') == 'pindahan' ? 'selected' : '' }}>Pindahan</option>
                        <option value="pendatang" {{ old('status_penduduk') == 'pendatang' ? 'selected' : '' }}>Pendatang</option>
                    </select>
                    @error('status_penduduk')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                   placeholder="Tempat Lahir" value="{{ old('tempat_lahir') }}" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-map-marker-alt"></span>
                                </div>
                            </div>
                            @error('tempat_lahir')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                   value="{{ old('tanggal_lahir') }}" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-calendar"></span>
                                </div>
                            </div>
                            @error('tanggal_lahir')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-venus-mars"></span>
                        </div>
                    </div>
                    @error('jenis_kelamin')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <input type="text" name="rt" class="form-control @error('rt') is-invalid @enderror" 
                                   placeholder="RT" value="{{ old('rt') }}" required maxlength="3">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-map"></span>
                                </div>
                            </div>
                            @error('rt')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <input type="text" name="rw" class="form-control @error('rw') is-invalid @enderror" 
                                   placeholder="RW" value="{{ old('rw') }}" required maxlength="3">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-map"></span>
                                </div>
                            </div>
                            @error('rw')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <select name="agama" class="form-control @error('agama') is-invalid @enderror" required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Khonghucu" {{ old('agama') == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-praying-hands"></span>
                                </div>
                            </div>
                            @error('agama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <select name="status_perkawinan" class="form-control @error('status_perkawinan') is-invalid @enderror" required>
                                <option value="">Status Perkawinan</option>
                                <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-heart"></span>
                                </div>
                            </div>
                            @error('status_perkawinan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <input type="text" name="pekerjaan" class="form-control @error('pekerjaan') is-invalid @enderror" 
                                   placeholder="Pekerjaan" value="{{ old('pekerjaan') }}" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-briefcase"></span>
                                </div>
                            </div>
                            @error('pekerjaan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <select name="kewarganegaraan" class="form-control @error('kewarganegaraan') is-invalid @enderror" required>
                                <option value="">Kewarganegaraan</option>
                                <option value="WNI" {{ old('kewarganegaraan') == 'WNI' ? 'selected' : '' }}>WNI</option>
                                <option value="WNA" {{ old('kewarganegaraan') == 'WNA' ? 'selected' : '' }}>WNA</option>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-flag"></span>
                                </div>
                            </div>
                            @error('kewarganegaraan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
                            <label for="agreeTerms">
                                Saya setuju dengan <a href="#" class="text-primary">syarat & ketentuan</a>
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-user-plus"></i> Register
                        </button>
                    </div>
                </div>
            </form>

            <div class="social-auth-links text-center">
                <p class="mb-1">
                    <a href="{{ route('login') }}" class="text-center">
                        <i class="fas fa-sign-in-alt"></i> Sudah punya akun? Login di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
