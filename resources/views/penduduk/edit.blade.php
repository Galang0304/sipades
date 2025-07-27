@extends('layouts.app')

@section('title', 'Edit Penduduk')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-primary">
                    <i class="fas fa-edit mr-2"></i>Edit Data Penduduk
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('penduduk.index') }}">Data Penduduk</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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

        @php
            // Cari user berdasarkan NIK dari penduduk
            $user = \App\Models\User::where('nik', $penduduk->nik)->first();
        @endphp

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-edit"></i>
                    Form Edit Data Penduduk
                </h3>
                <div class="card-tools">
                    <a href="{{ route('penduduk.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            @if($user)
            <form action="{{ route('penduduk.update', $penduduk->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <!-- Data Akun -->
                    <h5 class="text-primary mb-3">
                        <i class="fas fa-user-circle"></i> Data Akun
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user ? $user->name : $penduduk->nama_lengkap) }}" 
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
                                       id="email" name="email" value="{{ old('email', $user ? $user->email : '') }}" 
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

                    <hr>

                    <!-- Data Identitas -->
                    <h5 class="text-primary mb-3">
                        <i class="fas fa-id-card"></i> Data Identitas
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nik">NIK <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                                       id="nik" name="nik" value="{{ old('nik', $penduduk->nik) }}" 
                                       placeholder="Masukkan NIK (16 digit)" maxlength="16" pattern="[0-9]{16}" required>
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_kk">Nomor Kartu Keluarga <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('no_kk') is-invalid @enderror" 
                                       id="no_kk" name="no_kk" value="{{ old('no_kk', $penduduk->no_kk) }}" 
                                       placeholder="Masukkan No. KK (16 digit)" maxlength="16" pattern="[0-9]{16}" required>
                                @error('no_kk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_tlp">No. Telepon <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('no_tlp') is-invalid @enderror" 
                                       id="no_tlp" name="no_tlp" value="{{ old('no_tlp', $penduduk->no_tlp) }}" 
                                       placeholder="Masukkan nomor telepon" required>
                                @error('no_tlp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status_penduduk">Status Penduduk <span class="text-danger">*</span></label>
                                <select class="form-control @error('status_penduduk') is-invalid @enderror" 
                                        id="status_penduduk" name="status_penduduk" required>
                                    <option value="">Pilih Status Penduduk</option>
                                    <option value="Tetap" {{ old('status_penduduk', $penduduk->status_penduduk) == 'Tetap' ? 'selected' : '' }}>Penduduk Tetap</option>
                                    <option value="Sementara" {{ old('status_penduduk', $penduduk->status_penduduk) == 'Sementara' ? 'selected' : '' }}>Penduduk Sementara</option>
                                </select>
                                @error('status_penduduk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Data Pribadi -->
                    <h5 class="text-primary mb-3">
                        <i class="fas fa-user-circle"></i> Data Pribadi
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

                    <!-- Data Alamat -->
                    <h5 class="text-primary mb-3">
                        <i class="fas fa-map-marker-alt"></i> Data Alamat
                    </h5>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="alamat">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                          id="alamat" name="alamat" rows="3" 
                                          placeholder="Masukkan alamat lengkap" required>{{ old('alamat', $penduduk->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rt">RT <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('rt') is-invalid @enderror" 
                                       id="rt" name="rt"                                        value="{{ old('rt', $penduduk->rt) }}" 
                                       placeholder="Masukkan RT" maxlength="3" pattern="[0-9]{1,3}" required>
                                @error('rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rw">RW <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('rw') is-invalid @enderror" 
                                       id="rw" name="rw"                                        value="{{ old('rw', $penduduk->rw) }}" 
                                       placeholder="Masukkan RW" maxlength="3" pattern="[0-9]{1,3}" required>
                                @error('rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Upload Foto KK -->
                    <h5 class="text-primary mb-3">
                        <i class="fas fa-file-image"></i> Dokumen
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="foto_kk">Upload Foto Kartu Keluarga</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('foto_kk') is-invalid @enderror" 
                                           id="foto_kk" name="foto_kk" accept="image/*,.pdf">
                                    <label class="custom-file-label" for="foto_kk">Pilih file foto KK</label>
                                </div>
                                <small class="text-muted">Format: JPG, PNG, PDF (max 2MB). Kosongkan jika tidak ingin mengubah.</small>
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

                    <div class="form-group">
                        <label for="alamat">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="3" 
                                  placeholder="Masukkan alamat lengkap">{{ old('alamat', $penduduk->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('penduduk.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
            @else
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Data user tidak ditemukan untuk NIK ini. Silakan hubungi administrator.
                </div>
                <a href="{{ route('penduduk.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Custom file input
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass("selected").html(fileName);
    });

    // NIK validation
    $('#nik').on('input', function() {
        this.value = this.value.replace(/\D/g, '');
        if (this.value.length > 16) {
            this.value = this.value.slice(0, 16);
        }
    });

    // No KK validation
    $('#no_kk').on('input', function() {
        this.value = this.value.replace(/\D/g, '');
        if (this.value.length > 16) {
            this.value = this.value.slice(0, 16);
        }
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
});
</script>
@endsection
