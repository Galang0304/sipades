    @extends('layouts.app')

@section('title', 'Pengajuan Surat Baru')
@section('page-title', 'Pengajuan Surat Baru')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('surat.index') }}">Surat</a></li>
    <li class="breadcrumb-item active">Pengajuan Baru</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Pengajuan Surat</h3>
            </div>
            <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <!-- Data pemohon ditampilkan untuk semua user -->
                    <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; margin-bottom: 20px;">
                        <div class="card-body text-white">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <h5 class="mb-1" style="color: white; font-weight: 600;">Data Pemohon</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small style="color: rgba(255,255,255,0.8);">Nama Lengkap:</small>
                                            <div style="font-weight: 500; font-size: 16px;">
                                                {{ auth()->user()->penduduk->nama_lengkap ?? auth()->user()->name }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <small style="color: rgba(255,255,255,0.8);">NIK:</small>
                                            <div style="font-weight: 500; font-size: 16px; letter-spacing: 1px;">
                                                {{ auth()->user()->nik ?? 'NIK belum terdaftar' }}
                                            </div>
                                        </div>
                                    </div>
                                    @if(auth()->user()->penduduk)
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <small style="color: rgba(255,255,255,0.8);">Alamat:</small>
                                            <div style="font-size: 14px;">
                                                {{ Str::limit(auth()->user()->penduduk->alamat, 40) }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <small style="color: rgba(255,255,255,0.8);">Pekerjaan:</small>
                                            <div style="font-size: 14px;">
                                                {{ auth()->user()->penduduk->pekerjaan }}
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    <div style="background: rgba(255,255,255,0.2); border-radius: 8px; padding: 8px 12px;">
                                        <small style="color: rgba(255,255,255,0.8);">Status:</small>
                                        <div style="font-weight: 600; color: #4CAF50;">
                                            <i class="fas fa-check-circle"></i> Terverifikasi
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if(!auth()->user()->nik || !auth()->user()->penduduk)
                            <div class="alert alert-warning mt-3 mb-0" style="background: rgba(255,193,7,0.2); border: 1px solid rgba(255,193,7,0.3); color: #fff;">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Perhatian:</strong> Data penduduk Anda belum lengkap. Silakan hubungi petugas desa untuk melengkapi data sebelum mengajukan surat.
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Hidden input untuk NIK -->
                    <input type="hidden" name="nik" value="{{ auth()->user()->nik }}">

                    <div class="form-group">
                        <label for="jenis_surat_id">Jenis Surat <span class="text-danger">*</span></label>
                        <select name="jenis_surat_id" id="jenis_surat_id" class="form-control @error('jenis_surat_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Jenis Surat --</option>
                            @foreach($jenis_surat as $jenis)
                                <option value="{{ $jenis->id }}" {{ old('jenis_surat_id') == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->nama_surat }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_surat_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="keperluan">Keperluan <span class="text-danger">*</span></label>
                        <textarea name="keperluan" id="keperluan" rows="3" class="form-control @error('keperluan') is-invalid @enderror" 
                                  placeholder="Jelaskan keperluan surat ini..." required>{{ old('keperluan') }}</textarea>
                        @error('keperluan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Dynamic Form Fields Based on Surat Type -->
                    <div id="dynamic-fields" class="mt-4">
                        <!-- Fields will be populated via JavaScript -->
                    </div>

                    <div class="form-group">
                        <label for="berkas_pendukung">Berkas Pendukung</label>
                        <div class="custom-file">
                            <input type="file" name="berkas_pendukung" id="berkas_pendukung" 
                                   class="custom-file-input @error('berkas_pendukung') is-invalid @enderror"
                                   accept=".pdf,.jpg,.jpeg,.png">
                            <label class="custom-file-label" for="berkas_pendukung">Pilih file...</label>
                        </div>
                        <small class="form-text text-muted">
                            Format yang didukung: PDF, JPG, JPEG, PNG. Maksimal 2MB.
                        </small>
                        @error('berkas_pendukung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Ajukan Surat
                    </button>
                    <a href="{{ route('surat.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi</h3>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-info"></i> Petunjuk</h5>
                    <ul class="mb-0">
                        <li>Pilih jenis surat yang sesuai dengan kebutuhan</li>
                        <li>Isi keperluan dengan jelas dan detail</li>
                        <li>Lampirkan berkas pendukung jika diperlukan</li>
                        <li>Surat akan diproses dalam 2-3 hari kerja</li>
                    </ul>
                </div>

                <div class="alert alert-warning">
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Persyaratan</h5>
                    <ul class="mb-0">
                        <li>Data penduduk harus sudah terdaftar</li>
                        <li>Berkas pendukung harus jelas dan terbaca</li>
                        <li>Keperluan harus sesuai dengan jenis surat</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // NIK Search for admin
    $('#searchNik').on('click', function() {
        const nik = $('#nik_search').val().trim();
        if (nik) {
            // Show loading
            $('#penduduk_detail').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Mencari data...</div>').show();
            
            // Fetch penduduk data
            $.get(`/api/penduduk/search/${nik}`, function(response) {
                if (response.success) {
                    const penduduk = response.data;
                    $('#selected_nik').val(penduduk.nik);
                    
                    // Display penduduk data
                    $('#penduduk_detail').html(`
                        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                            <div class="card-body text-white">
                                <h6 class="mb-3">Data Ditemukan:</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><small>Nama Lengkap:</small><br>
                                        <strong>${penduduk.nama_lengkap}</strong></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><small>NIK:</small><br>
                                        <strong>${penduduk.nik}</strong></p>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <p class="mb-1"><small>Alamat:</small><br>
                                        ${penduduk.alamat}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><small>Pekerjaan:</small><br>
                                        ${penduduk.pekerjaan}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                } else {
                    $('#penduduk_detail').html(`
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> 
                            Data penduduk dengan NIK tersebut tidak ditemukan
                        </div>
                    `);
                    $('#selected_nik').val('');
                }
            }).fail(function() {
                $('#penduduk_detail').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle"></i> 
                        Terjadi kesalahan saat mencari data penduduk
                    </div>
                `);
                $('#selected_nik').val('');
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'NIK Kosong',
                text: 'Silakan masukkan NIK terlebih dahulu'
            });
        }
    });

    // Dynamic form fields based on jenis surat
    $('#jenis_surat_id').on('change', function() {
        const jenisId = $(this).val();
        const jenisText = $(this).find('option:selected').text();
        
        if (jenisId) {
            showDynamicFields(jenisText, jenisId);
        } else {
            $('#dynamic-fields').html('');
        }
    });

    function showDynamicFields(jenisText, jenisId) {
        let dynamicHTML = '';
        
        // Surat Kematian
        if (jenisText.toLowerCase().includes('kematian')) {
            dynamicHTML = `
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Data Khusus Surat Kematian</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hari_meninggal">Hari Meninggal <span class="text-danger">*</span></label>
                                    <select name="hari_meninggal" id="hari_meninggal" class="form-control" required>
                                        <option value="">-- Pilih Hari --</option>
                                        <option value="Senin">Senin</option>
                                        <option value="Selasa">Selasa</option>
                                        <option value="Rabu">Rabu</option>
                                        <option value="Kamis">Kamis</option>
                                        <option value="Jumat">Jumat</option>
                                        <option value="Sabtu">Sabtu</option>
                                        <option value="Minggu">Minggu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_meninggal">Tanggal Meninggal <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_meninggal" id="tanggal_meninggal" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sebab_kematian">Sebab Kematian <span class="text-danger">*</span></label>
                                    <input type="text" name="sebab_kematian" id="sebab_kematian" class="form-control" 
                                           placeholder="Contoh: Sakit, Kecelakaan, dll" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alamat_meninggal">Tempat Meninggal <span class="text-danger">*</span></label>
                                    <input type="text" name="alamat_meninggal" id="alamat_meninggal" class="form-control" 
                                           placeholder="Contoh: Rumah Sakit, Rumah, dll" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        // Surat Izin Usaha
        else if (jenisText.toLowerCase().includes('usaha') || jenisText.toLowerCase().includes('izin usaha')) {
            dynamicHTML = `
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-briefcase"></i> Data Khusus Surat Izin Usaha</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_usaha">Nama Usaha <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_usaha" id="nama_usaha" class="form-control" 
                                           placeholder="Masukkan nama usaha" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_usaha">Jenis Usaha <span class="text-danger">*</span></label>
                                    <select name="jenis_usaha" id="jenis_usaha" class="form-control" required>
                                        <option value="">-- Pilih Jenis Usaha --</option>
                                        <option value="Perdagangan">Perdagangan</option>
                                        <option value="Jasa">Jasa</option>
                                        <option value="Manufaktur">Manufaktur</option>
                                        <option value="Kuliner">Kuliner</option>
                                        <option value="Pertanian">Pertanian</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat_usaha">Alamat Usaha <span class="text-danger">*</span></label>
                            <textarea name="alamat_usaha" id="alamat_usaha" rows="3" class="form-control" 
                                      placeholder="Masukkan alamat lengkap tempat usaha" required></textarea>
                        </div>
                    </div>
                </div>
            `;
        }
        // Surat Keterangan Pindah
        else if (jenisText.toLowerCase().includes('pindah')) {
            dynamicHTML = `
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-home"></i> Data Khusus Surat Keterangan Pindah</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="alamat_baru">Alamat Baru <span class="text-danger">*</span></label>
                            <textarea name="alamat_baru" id="alamat_baru" rows="3" class="form-control" 
                                      placeholder="Masukkan alamat lengkap tujuan pindah" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_keluarga">Jumlah Keluarga Pindah <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_keluarga" id="jumlah_keluarga" class="form-control" 
                                   placeholder="Masukkan jumlah anggota keluarga yang pindah" min="1" required>
                        </div>
                    </div>
                </div>
            `;
        }

        $('#dynamic-fields').html(dynamicHTML);
    }

    // Custom file input
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // Enhanced form validation
    $('form').on('submit', function(e) {
        let isValid = true;
        let errorMessages = [];
        
        // Basic validation
        if (!$('#jenis_surat_id').val()) {
            isValid = false;
            errorMessages.push('Jenis surat harus dipilih');
            $('#jenis_surat_id').addClass('is-invalid');
        }
        
        if (!$('#keperluan').val().trim()) {
            isValid = false;
            errorMessages.push('Keperluan harus diisi');
            $('#keperluan').addClass('is-invalid');
        }

        // Dynamic field validation
        const jenisText = $('#jenis_surat_id option:selected').text();
        
        if (jenisText.toLowerCase().includes('kematian')) {
            if (!$('#hari_meninggal').val()) {
                isValid = false;
                errorMessages.push('Hari meninggal harus dipilih');
                $('#hari_meninggal').addClass('is-invalid');
            }
            if (!$('#tanggal_meninggal').val()) {
                isValid = false;
                errorMessages.push('Tanggal meninggal harus diisi');
                $('#tanggal_meninggal').addClass('is-invalid');
            }
            if (!$('#sebab_kematian').val().trim()) {
                isValid = false;
                errorMessages.push('Sebab kematian harus diisi');
                $('#sebab_kematian').addClass('is-invalid');
            }
            if (!$('#alamat_meninggal').val().trim()) {
                isValid = false;
                errorMessages.push('Tempat meninggal harus diisi');
                $('#alamat_meninggal').addClass('is-invalid');
            }
        }
        
        if (jenisText.toLowerCase().includes('usaha')) {
            if (!$('#nama_usaha').val().trim()) {
                isValid = false;
                errorMessages.push('Nama usaha harus diisi');
                $('#nama_usaha').addClass('is-invalid');
            }
            if (!$('#jenis_usaha').val()) {
                isValid = false;
                errorMessages.push('Jenis usaha harus dipilih');
                $('#jenis_usaha').addClass('is-invalid');
            }
            if (!$('#alamat_usaha').val().trim()) {
                isValid = false;
                errorMessages.push('Alamat usaha harus diisi');
                $('#alamat_usaha').addClass('is-invalid');
            }
        }
        
        if (jenisText.toLowerCase().includes('pindah')) {
            if (!$('#alamat_baru').val().trim()) {
                isValid = false;
                errorMessages.push('Alamat baru harus diisi');
                $('#alamat_baru').addClass('is-invalid');
            }
            if (!$('#jumlah_keluarga').val() || $('#jumlah_keluarga').val() < 1) {
                isValid = false;
                errorMessages.push('Jumlah keluarga pindah harus diisi dengan benar');
                $('#jumlah_keluarga').addClass('is-invalid');
            }
        }
        
        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Form Tidak Valid',
                html: '<ul style="text-align: left;">' + errorMessages.map(msg => '<li>' + msg + '</li>').join('') + '</ul>'
            });
        }
    });

    // Remove is-invalid class when user starts typing
    $('body').on('input change', 'input, select, textarea', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@endpush
