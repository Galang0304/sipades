# SIPADES - Sistem Informasi Pelayanan Administrasi Desa

![Laravel](https://img.shields.io/badge/Laravel-9.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.0%2B-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-orange.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

## 📋 Deskripsi

SIPADES (Sistem Informasi Pelayanan Administrasi Desa) adalah aplikasi web yang dirancang untuk memudahkan pengelolaan administrasi desa dan pelayanan kepada masyarakat. Sistem ini menggunakan teknologi Laravel 9 dengan tema KUINSEL yang user-friendly.

## ✨ Fitur Utama

### 🔐 Manajemen User & Role
- **Multi-Role System**: Admin, Petugas, Lurah, dan Penduduk
- **User Approval**: Sistem persetujuan pendaftaran penduduk baru
- **Profile Management**: Pengelolaan profil lengkap dengan foto dan dokumen

### 📄 Pelayanan Surat
- **Pengajuan Surat Online**: Penduduk dapat mengajukan berbagai jenis surat
- **Two-Stage Approval**: Approval bertingkat (Petugas → Lurah)
- **Template Surat**: Template otomatis untuk berbagai jenis surat
- **Status Tracking**: Pelacakan status pengajuan real-time
- **Notifikasi Email**: Pemberitahuan otomatis via email

### 👥 Manajemen Penduduk
- **Data Penduduk Lengkap**: KTP, KK, alamat, dan data demografis
- **Import/Export Data**: Fitur impor dan ekspor data penduduk
- **Barcode System**: Sistem barcode untuk identifikasi unik
- **RT/RW Management**: Pengelolaan data berdasarkan RT/RW

### 📊 Laporan & Analytics
- **Laporan Pengajuan Surat**: Laporan lengkap dengan filter dan statistik
- **Laporan Penduduk**: Analisis demografis dan statistik penduduk
- **Export PDF**: Cetak laporan dalam format PDF
- **Dashboard Analytics**: Grafik dan statistik real-time

### ℹ️ Informasi Kelurahan
- **Profil Kelurahan**: Informasi lengkap kelurahan/desa
- **Visi Misi**: Pengelolaan visi misi dan struktur organisasi
- **Galeri**: Dokumentasi kegiatan dan fasilitas

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 9.x
- **Frontend**: AdminLTE 3, Bootstrap 4, jQuery
- **Database**: MySQL 8.0+
- **Authentication**: Laravel Sanctum
- **Authorization**: Spatie Laravel Permission
- **Email**: Laravel Mail dengan SMTP
- **PDF**: DomPDF
- **DataTables**: Server-side processing
- **Icons**: FontAwesome 5

## 📋 Persyaratan Sistem

### Minimum Requirements
- PHP >= 8.0
- MySQL >= 8.0 atau MariaDB >= 10.3
- Apache/Nginx Web Server
- Composer >= 2.0
- Node.js >= 14.x (untuk asset compilation)

### Recommended Requirements
- PHP 8.1+
- MySQL 8.0+
- 2GB RAM minimum
- SSL Certificate (untuk production)

## 🚀 Instalasi & Setup

### 1. Clone Repository
```bash
git clone https://github.com/Galang0304/sipades.git
cd sipades
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup
Edit file `.env` dengan konfigurasi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipades_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Jalankan migrasi dan seeder:
```bash
# Create database (optional)
mysql -u root -p -e "CREATE DATABASE sipades_db"

# Run migrations
php artisan migrate

# Run seeders
php artisan db:seed
```

### 5. Storage Configuration
```bash
# Create storage symlink
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 6. Email Configuration (Optional)
Edit konfigurasi email di `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="SIPADES System"
```

### 7. Compile Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### 8. Run Application
```bash
# Development server
php artisan serve

# Access application at: http://localhost:8000
```

## 👥 Default Users

Setelah menjalankan seeder, Anda dapat login dengan akun berikut:

| Role | Username | Password | Deskripsi |
|------|----------|----------|-----------|
| Admin | admin@sipades.com | password | Administrator sistem |
| Petugas | petugas@sipades.com | password | Petugas kelurahan |
| Lurah | lurah@sipades.com | password | Kepala lurah/desa |

## 📱 Penggunaan Aplikasi

### Untuk Administrator
1. **Login** ke sistem menggunakan akun admin
2. **Kelola User**: Approve pendaftaran penduduk baru
3. **Manajemen Data**: Input dan update data penduduk
4. **Setup Jenis Surat**: Konfigurasi template surat
5. **Monitor Laporan**: Lihat statistik dan analytics

### Untuk Petugas
1. **Proses Pengajuan**: Review dan proses pengajuan surat tahap 1
2. **Manajemen Penduduk**: Input dan update data penduduk
3. **Generate Laporan**: Buat laporan berdasarkan filter

### Untuk Lurah
1. **Final Approval**: Approve final pengajuan surat
2. **Review Laporan**: Monitor semua aktivitas
3. **Kelola Informasi**: Update informasi kelurahan

### Untuk Penduduk
1. **Registrasi**: Daftar akun baru (perlu approval)
2. **Ajukan Surat**: Submit pengajuan surat online
3. **Track Status**: Pantau progress pengajuan
4. **Download Surat**: Download surat yang sudah selesai

## 🗂️ Struktur Database

### Tabel Utama
- `users` - Data pengguna sistem
- `penduduk` - Data penduduk desa
- `jenis_surats` - Master jenis surat
- `pengajuan_surats` - Data pengajuan surat
- `informasi_kelurahan` - Informasi profil desa

### Relasi Database
```
users (1) → (n) pengajuan_surats
penduduk (1) → (1) users
jenis_surats (1) → (n) pengajuan_surats
```

## 🔒 Keamanan

### Authentication & Authorization
- Role-based access control dengan Spatie Permission
- Password hashing menggunakan bcrypt
- CSRF protection pada semua form
- Rate limiting untuk login attempts

### Data Protection
- SQL injection prevention dengan Eloquent ORM
- XSS protection dengan Blade templating
- File upload validation dan sanitization
- Secure session management

## 📊 Monitoring & Logging

### Error Handling
- Custom error pages (404, 500)
- Application logging dengan Laravel Log
- Email notification untuk critical errors

### Performance
- Database query optimization
- Eager loading untuk relasi
- Caching untuk data statis
- Asset minification dan compression

## 🚀 Deployment ke Production

### 1. Server Requirements
```bash
# Install required packages (Ubuntu/Debian)
sudo apt update
sudo apt install apache2 mysql-server php8.1 php8.1-mysql php8.1-zip php8.1-gd php8.1-curl php8.1-xml composer
```

### 2. Apache Configuration
```apache
<VirtualHost *:80>
    ServerName your-domain.com
    DocumentRoot /var/www/sipades/public
    
    <Directory /var/www/sipades/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/sipades_error.log
    CustomLog ${APACHE_LOG_DIR}/sipades_access.log combined
</VirtualHost>
```

### 3. Production Environment
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Use production database
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_DATABASE=sipades_production
```

### 4. Optimization
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

## 🛠️ Troubleshooting

### Common Issues

#### 1. Permission Error
```bash
sudo chown -R www-data:www-data /var/www/sipades
sudo chmod -R 755 /var/www/sipades/storage
```

#### 2. Database Connection Error
- Periksa konfigurasi `.env`
- Pastikan MySQL service berjalan
- Verifikasi username/password database

#### 3. Email Not Sending
- Periksa konfigurasi SMTP di `.env`
- Pastikan port tidak diblokir firewall
- Test dengan `php artisan tinker`

#### 4. Asset Not Loading
```bash
# Recompile assets
npm run build

# Clear cache
php artisan cache:clear
php artisan view:clear
```

## 🔄 Update & Maintenance

### Regular Maintenance
```bash
# Update dependencies
composer update
npm update

# Run migrations
php artisan migrate

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Backup Database
```bash
# Create backup
mysqldump -u username -p sipades_db > backup_$(date +%Y%m%d).sql

# Restore backup
mysql -u username -p sipades_db < backup_20240129.sql
```

## 📞 Support & Kontribusi

### Support
- **Email**: support@sipades.com
- **Documentation**: [Wiki Page](https://github.com/Galang0304/sipades/wiki)
- **Issues**: [GitHub Issues](https://github.com/Galang0304/sipades/issues)

### Contributing
1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

### Development Guidelines
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation
- Use semantic versioning

## 📄 License

Distributed under the MIT License. See `LICENSE` file for more information.

## 👨‍💻 Developer

**Galang Saputra**
- GitHub: [@Galang0304](https://github.com/Galang0304)
- Email: galang@example.com

## 🙏 Acknowledgments

- [Laravel Framework](https://laravel.com/)
- [AdminLTE](https://adminlte.io/)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- [DataTables](https://datatables.net/)
- [FontAwesome](https://fontawesome.com/)

---

## 📈 Roadmap

### Version 2.0 (Planned)
- [ ] Mobile responsive PWA
- [ ] API REST untuk mobile app
- [ ] Integration dengan sistem kependudukan nasional
- [ ] Digital signature untuk surat
- [ ] Chat system untuk komunikasi
- [ ] Advanced analytics dashboard

### Version 1.1 (In Progress)
- [x] Enhanced reporting system
- [x] Improved UI/UX dengan KUINSEL theme
- [x] Two-stage approval workflow
- [x] Email notifications
- [ ] Backup automation
- [ ] Performance optimization

---

**Last Updated**: July 29, 2025  
**Version**: 1.0.0  
**PHP Version**: 8.1+  
**Laravel Version**: 9.x
