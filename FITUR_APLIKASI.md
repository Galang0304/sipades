# Dokumentasi Fitur Aplikasi KUINSEL (Kelurahan Kuin Selatan)

## 📋 Informasi Umum
- **Nama Aplikasi**: KUINSEL (Kelurahan Kuin Selatan)
- **Framework**: Laravel 9.52.20
- **Database**: MySQL (kuinsel)
- **Template**: AdminLTE
- **Lokasi**: Kelurahan Kuin Selatan, Kecamatan Banjarmasin Barat, Kota Banjarmasin

## 🎯 Tujuan Aplikasi
Sistem informasi untuk mengelola administrasi kelurahan, pelayanan surat-menyurat, dan pengaduan masyarakat secara digital.

## 👥 Sistem Role dan Hak Akses

### 1. **Administrator (role_id: 1)**
- Akses penuh ke semua fitur sistem
- Mengelola data penduduk
- Mengelola semua jenis surat
- Mengelola pengaduan masyarakat
- Mengelola informasi kelurahan
- Mengelola pengguna sistem (user management)
- Melihat dan mengelola laporan
- Menambah Lurah dan Petugas

### 2. **Member/Warga (role_id: 2)**
- Mengajukan berbagai jenis surat
- Membuat pengaduan
- Melihat status pengajuan surat
- Mengelola profil pribadi
- Melihat informasi kelurahan

### 3. **Lurah (role_id: 3)**
- Dashboard khusus Lurah
- Validasi dan persetujuan surat
- Melihat laporan
- Akses ke data surat yang diajukan

### 4. **Petugas (role_id: 4)**
- Mengelola data penduduk
- Mengelola informasi kelurahan
- Melihat laporan administrasi

## 🏠 Fitur Website Publik

### Halaman Utama (Home)
- **Profil Kelurahan**: Informasi tentang Kelurahan Kuin Selatan
- **Layanan Surat**: Informasi tentang berbagai jenis surat yang dapat diajukan
- **Kontak dan Alamat**: Informasi kontak kantor kelurahan
- **Statistik**: Data statistik kelurahan

### Navigasi Publik
- Home
- Profil
- Layanan
- Kontak
- Statistik

## 🔐 Sistem Autentikasi

### Login
- Login dengan email dan password
- Redirect otomatis berdasarkan role:
  - Admin → Dashboard Admin
  - Lurah → Dashboard Lurah
  - Petugas → Data Penduduk
  - Member → Dashboard User

### Registrasi
- Registrasi sebagai warga/member
- Input data lengkap penduduk sekaligus
- Validasi NIK dan email unik
- Auto-active setelah registrasi

### Fitur Tambahan Auth
- Forgot Password
- Change Password
- Logout

## 📊 Dashboard dan Menu Utama

### Dashboard Admin
- Statistik umum aplikasi
- Overview data surat dan pengaduan

### Dashboard User/Member
- Informasi kelurahan terbaru
- Status pengajuan surat terbaru

### Dashboard Lurah
- Dashboard khusus untuk monitoring
- Data surat yang perlu divalidasi

## 👨‍👩‍👧‍👦 Manajemen Data Penduduk

### Fitur Penduduk
- **CRUD Data Penduduk** (Admin/Petugas):
  - Tambah data penduduk baru
  - Edit data penduduk
  - Hapus data penduduk
  - Lihat detail data penduduk
  - Pencarian data penduduk

### Data yang Dikelola
- NIK (16 digit)
- Nama Lengkap
- Tempat Lahir
- Tanggal Lahir
- Alamat
- Agama
- Jenis Kelamin
- Status Perkawinan
- Pekerjaan
- Status Penduduk

## 📄 Sistem Pelayanan Surat

### Jenis Surat yang Tersedia

#### 1. **Surat Keterangan Domisili (SKD)** - Kode: 145.1
- Template: "Template surat sesuai kebutuhan"
- Fungsi: Keterangan tempat tinggal/domisili

#### 2. **Surat Keterangan Tidak Mampu (SKTM)** - Kode: 312.1
- Template: "Dengan ini menerangkan bahwa {nama} benar merupakan warga yang tidak mampu di {alamat}. Surat ini digunakan untuk keperluan {keperluan}."
- Fungsi: Keterangan ekonomi tidak mampu

#### 3. **Surat Domisili** - Kode: 470
- Fungsi: Keterangan domisili umum

#### 4. **Surat Keterangan Belum Menikah (SKBM)** - Kode: 470.1
- Template: "Template surat sesuai kebutuhan"
- Fungsi: Keterangan status belum menikah

#### 5. **Surat Pindah** - Kode: 474
- Data tambahan:
  - Alamat baru
  - Jumlah keluarga yang pindah
- Fungsi: Administrasi pindah domisili

#### 6. **Surat Kematian** - Kode: 474.3
- Data tambahan:
  - Hari meninggal
  - Tanggal meninggal
  - Sebab kematian
  - Alamat meninggal
- Fungsi: Administrasi kematian

#### 7. **Surat Izin Usaha** - Kode: 503
- Data tambahan:
  - Nama usaha
  - Jenis usaha
  - Alamat usaha
  - Keterangan usaha
- Fungsi: Perizinan usaha

#### 8. **Surat Keterangan Umum** - Kode: UMUM
- Template: "Template surat sesuai kebutuhan"
- Fungsi: Keterangan umum sesuai kebutuhan

### Proses Pengajuan Surat

#### Untuk Member/Warga:
1. **Login** ke sistem
2. **Pilih jenis surat** yang diinginkan
3. **Isi form** dengan data lengkap:
   - NIK (validasi 16 digit)
   - Keterangan/keperluan
   - Data spesifik sesuai jenis surat
4. **Submit pengajuan**
5. **Auto-trigger** masuk ke sistem validasi

#### Untuk Admin:
1. **Akses menu Data Surat**
2. **Tambah surat** langsung untuk warga
3. **Edit/hapus** surat yang ada
4. **Lihat detail** pengajuan

### Sistem Validasi Surat

#### Status Validasi:
- **Proses**: Surat baru diajukan, menunggu persetujuan
- **Selesai**: Surat telah disetujui dan dapat dicetak
- **Ditolak**: Surat ditolak dengan keterangan

#### Proses Validasi (Lurah):
1. **Akses menu Validasi Surat**
2. **Review** pengajuan surat
3. **Approve/Reject** dengan keterangan
4. **Auto-notification** ke pemohon

#### Sistem Trigger Database:
- **Auto-insert** ke `tbl_validasi` saat surat dibuat
- **Default status**: "Proses" dengan keterangan "Mohon Tunggu"
- **Auto-delete** validasi saat surat dihapus

## 📝 Sistem Pengaduan Masyarakat

### Fitur Pengaduan untuk Member:
1. **Buat Pengaduan Baru**:
   - NIK pemohon
   - Isi laporan
   - Upload foto pendukung
   - Auto-status "Proses"

2. **Lihat Status Pengaduan**:
   - Daftar pengaduan yang dibuat
   - Status terbaru
   - Tanggapan dari petugas

### Fitur Pengaduan untuk Admin:
1. **Kelola Semua Pengaduan**:
   - Lihat semua pengaduan masuk
   - Detail lengkap pengaduan
   - Balas/tanggapi pengaduan

2. **Status Pengaduan**:
   - **Proses**: Pengaduan baru masuk
   - **Ditanggapi**: Sudah diberi tanggapan
   - **Selesai**: Pengaduan selesai ditangani

### Sistem Trigger:
- **Auto-create** tanggapan kosong saat pengaduan dibuat
- **Insert** ke `tbl_tindakan` dengan tanggapan "-"

## 📰 Manajemen Informasi Kelurahan

### Fitur Informasi (Admin/Petugas):
1. **Tambah Informasi**:
   - Judul informasi
   - Deskripsi/keterangan
   - Upload gambar
   - Tanggal publish

2. **Edit/Hapus Informasi**
3. **Manajemen gambar** di folder `assets/img/`

### Display Informasi:
- **Homepage publik**: Informasi terbaru
- **Dashboard user**: Feed informasi kelurahan

## 👨‍💼 Manajemen User Sistem

### User Management (Admin Only):
1. **Kelola Semua User**:
   - Lihat daftar semua pengguna
   - Edit data pengguna
   - Hapus pengguna (dengan validasi)
   - Pencarian pengguna

2. **Tambah User Khusus**:
   - **Tambah Lurah**: Registrasi khusus role Lurah
   - **Tambah Petugas**: Registrasi khusus role Petugas

3. **Validasi Hapus User**:
   - Cek apakah user memiliki pengaduan
   - Blokir hapus jika ada data terkait

### Data User yang Dikelola:
- Informasi dasar (nama, email, password)
- NIK (linked ke data penduduk)
- Role/hak akses
- Status aktif
- Foto profil

## 📊 Sistem Laporan

### Laporan untuk Admin & Petugas:

#### 1. **Laporan Surat**:
- **Laporan SKTM**: Daftar semua surat tidak mampu
- **Laporan SKBM**: Daftar surat belum menikah
- **Laporan Surat Umum**: Daftar surat keterangan umum
- **Laporan Surat Keterangan**: Laporan SKD
- **Laporan Surat Izin Usaha**: Daftar izin usaha
- **Laporan Surat Kematian**: Data administrasi kematian
- **Laporan Surat Pindah**: Data perpindahan penduduk

#### 2. **Laporan Pengaduan**:
- Daftar semua pengaduan masyarakat
- Status penanganan
- Statistik pengaduan

### Format Laporan:
- **Web view**: Tabel interaktif
- **Export**: PDF menggunakan DomPDF
- **Filter**: Berdasarkan tanggal, status, dll

## 🖨️ Sistem Cetak Dokumen

### Cetak Surat (PDF):
1. **Cetak SKTM**: Format resmi surat tidak mampu
2. **Cetak SKBM**: Format surat belum menikah
3. **Cetak surat lainnya**: Template dinamis

### Library yang Digunakan:
- **DomPDF**: Untuk generate PDF
- **Template**: File view khusus untuk cetak
- **Styling**: CSS khusus untuk dokumen resmi

## 🗂️ Struktur Database

### Tabel Utama:

#### User & Auth:
- `tbl_user`: Data pengguna sistem
- `user_role`: Master role (Admin, Member, Lurah, Petugas)
- `user_menu` & `user_sub_menu`: Menu dinamis
- `user_access_menu`: Hak akses menu per role

#### Data Master:
- `tbl_penduduk`: Data penduduk kelurahan
- `tbl_surat`: Master jenis surat dan template
- `tbl_informasi`: Informasi kelurahan

#### Transaksi Surat:
- `tbl_pengajuan_surat`: Pengajuan surat umum
- `tbl_surat_ket`: Surat keterangan (SKD, SKTM, SKBM, Umum)
- `tbl_surat_izin`: Surat izin usaha
- `tbl_surat_mati`: Surat kematian
- `tbl_surat_pindah`: Surat pindah domisili

#### Validasi & Workflow:
- `tbl_validasi`: Status validasi semua surat

#### Pengaduan:
- `tbl_pengaduan`: Data pengaduan masyarakat
- `tbl_tindakan`: Tanggapan terhadap pengaduan

### Relasi Database:
- **Foreign Key Constraints**: Menjaga integritas data
- **Cascade Delete**: Auto-hapus data terkait
- **Database Triggers**: Otomasi workflow

## 🔧 Fitur Teknis

### Validasi Form:
- **Server-side validation**: CodeIgniter Form Validation
- **NIK validation**: 16 digit numeric
- **Email validation**: Format dan unique
- **File upload validation**: Type dan size

### Security:
- **Password hashing**: PHP password_hash()
- **XSS protection**: HTML special chars
- **SQL injection protection**: CI Query Builder
- **Session management**: CI Session library

### File Management:
- **Upload gambar**: JPG, PNG, GIF (max 2MB)
- **Storage**: `assets/img/` directory
- **Validation**: File type dan size

### User Interface:
- **Responsive design**: Bootstrap + AdminLTE
- **Interactive elements**: jQuery, DataTables
- **Icons**: FontAwesome
- **Notifications**: SweetAlert/Flash messages

## 🎨 Kustomisasi UI

### Template yang Digunakan:
- **AdminLTE**: Dashboard admin
- **Bootstrap**: Frontend responsive
- **Custom CSS**: Styling khusus aplikasi

### Fitur UI:
- **Dynamic sidebar**: Menu berdasarkan role
- **DataTables**: Tabel interaktif dengan search/sort
- **Modal dialogs**: Pop-up forms
- **File upload preview**: Preview gambar sebelum upload
- **Status badges**: Visual status surat dan pengaduan

## 📱 Responsive Design
- **Mobile-friendly**: Dapat diakses dari smartphone
- **Adaptive layout**: Menyesuaikan ukuran layar
- **Touch-friendly**: Interface mudah digunakan di mobile

## 🔄 Workflow Bisnis

### Alur Pengajuan Surat:
1. **Member** → Login → Pilih Jenis Surat → Isi Form → Submit
2. **System** → Auto-create record di tbl_validasi (status: Proses)
3. **Lurah** → Login → Menu Validasi → Review → Approve/Reject
4. **System** → Update status → Notifikasi ke member
5. **Member** → Cetak surat (jika approved)

### Alur Pengaduan:
1. **Member** → Login → Buat Pengaduan → Upload Foto → Submit
2. **System** → Auto-create tanggapan kosong
3. **Admin** → Review pengaduan → Beri tanggapan
4. **System** → Update status pengaduan
5. **Member** → Lihat tanggapan

## 📈 Statistik dan Monitoring

### Data yang Dapat Dimonitor:
- Jumlah penduduk total
- Jumlah pengajuan surat per jenis
- Status validasi surat
- Jumlah pengaduan dan penanganannya
- User aktif sistem

### Dashboard Analytics:
- **Admin**: Overview semua data
- **Lurah**: Data yang perlu validasi
- **Member**: Status personal pengajuan

## 🔒 Keamanan Sistem

### Authentication:
- Session-based login
- Role-based access control
- Auto-logout security

### Authorization:
- Menu access berdasarkan role
- Function-level security
- Data isolation per user

### Data Protection:
- Input sanitization
- SQL injection prevention
- XSS protection
- File upload validation

## 🛠️ Maintenance dan Support

### Backup Database:
- Database export: `kuinsel (10).sql`
- Regular backup recommended

### File Structure:
- **CodeIgniter 3** structure
- **MVC pattern** implementation
- **Modular design** untuk easy maintenance

### Logging:
- CI error logging
- User activity can be tracked
- Database transaction logging

---

## 📝 Kesimpulan

Aplikasi KUINSEL (Kelurahan Kuin Selatan) adalah sistem informasi lengkap untuk mengelola administrasi kelurahan dengan fitur:

✅ **8 jenis surat** dengan workflow approval  
✅ **4 level user** dengan hak akses berbeda  
✅ **Sistem pengaduan** masyarakat  
✅ **Manajemen penduduk** lengkap  
✅ **Laporan** komprehensif  
✅ **Interface** user-friendly dan responsive  
✅ **Keamanan** berlapis  
✅ **Database** terstruktur dengan triggers  

Aplikasi ini dapat mempermudah pelayanan administrasi kelurahan dan meningkatkan efisiensi pelayanan publik.
