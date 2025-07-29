# 🚀 Panduan Instalasi SIPADES - Lengkap

## 📋 Prerequisites

### System Requirements
- **Operating System**: Windows 10/11, macOS 10.15+, atau Ubuntu 18.04+
- **PHP**: 8.0 atau lebih tinggi
- **MySQL**: 8.0+ atau MariaDB 10.3+
- **Web Server**: Apache 2.4+ atau Nginx 1.18+
- **Composer**: 2.0+
- **Node.js**: 14.x atau 16.x
- **NPM**: 6.x+

### Development Tools (Recommended)
- **IDE**: Visual Studio Code dengan PHP extensions
- **Database Manager**: phpMyAdmin, MySQL Workbench, atau DBeaver
- **Git**: Untuk version control
- **Terminal**: Command Prompt, PowerShell, atau Terminal

## 📥 Download & Setup

### 1. Clone Repository
```bash
# Clone dari GitHub
git clone https://github.com/Galang0304/sipades.git

# Masuk ke direktori project
cd sipades

# Cek status git
git status
```

### 2. Install PHP Dependencies
```bash
# Install Composer dependencies
composer install

# Jika ada error permission (Linux/Mac)
sudo composer install

# Update dependencies (optional)
composer update
```

### 3. Install Node.js Dependencies
```bash
# Install NPM packages
npm install

# Atau menggunakan Yarn
yarn install

# Cek versi Node & NPM
node --version
npm --version
```

## ⚙️ Configuration

### 1. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Windows PowerShell
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 2. Edit Environment File
Buka `.env` dan sesuaikan konfigurasi:

```env
# Application
APP_NAME="SIPADES"
APP_ENV=local
APP_KEY=base64:GENERATED_KEY_HERE
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipades_db
DB_USERNAME=root
DB_PASSWORD=your_password

# Mail Configuration (Optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your_email@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"

# Session & Cache
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

# Filesystem
FILESYSTEM_DISK=local
```

## 🗄️ Database Setup

### 1. Create Database
```sql
-- Login ke MySQL
mysql -u root -p

-- Create database
CREATE DATABASE sipades_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user (optional)
CREATE USER 'sipades_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON sipades_db.* TO 'sipades_user'@'localhost';
FLUSH PRIVILEGES;

-- Exit MySQL
EXIT;
```

### 2. Run Migrations
```bash
# Check migration status
php artisan migrate:status

# Run migrations
php artisan migrate

# Rollback if needed
php artisan migrate:rollback

# Fresh migration (CAUTION: Deletes all data)
php artisan migrate:fresh
```

### 3. Seed Database
```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=JenisSuratSeeder
php artisan db:seed --class=InformasiKelurahanSeeder

# Fresh migration with seeding
php artisan migrate:fresh --seed
```

## 🔗 Storage & Permissions

### 1. Create Storage Link
```bash
# Create symbolic link
php artisan storage:link

# Verify link creation
ls -la public/storage  # Linux/Mac
dir public\storage     # Windows
```

### 2. Set Permissions (Linux/Mac)
```bash
# Set ownership
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache

# Set permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# For production server
sudo chown -R www-data:www-data /path/to/sipades
sudo chmod -R 755 /path/to/sipades
sudo chmod -R 775 /path/to/sipades/storage
sudo chmod -R 775 /path/to/sipades/bootstrap/cache
```

### 3. Windows Permissions
```cmd
# No special permissions needed for development
# Ensure the web server can read/write to storage and bootstrap/cache
```

## 🎨 Asset Compilation

### 1. Development Assets
```bash
# Compile assets for development
npm run dev

# Watch for changes
npm run watch

# Hot reloading (advanced)
npm run hot
```

### 2. Production Assets
```bash
# Compile and minify for production
npm run production

# Or using build command
npm run build
```

## 🚀 Running the Application

### 1. Development Server
```bash
# Start Laravel development server
php artisan serve

# Custom host and port
php artisan serve --host=192.168.1.100 --port=8080

# Check if server is running
curl http://localhost:8000
```

### 2. Using Local Server (XAMPP/WAMP/MAMP)
```apache
# Apache Virtual Host Configuration
<VirtualHost *:80>
    ServerName sipades.local
    DocumentRoot /path/to/sipades/public
    
    <Directory /path/to/sipades/public>
        AllowOverride All
        Require all granted
        DirectoryIndex index.php
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/sipades_error.log
    CustomLog ${APACHE_LOG_DIR}/sipades_access.log combined
</VirtualHost>
```

Add to hosts file:
```
127.0.0.1    sipades.local
```

## 👥 Default User Accounts

Setelah seeding, gunakan akun berikut untuk login:

| Role | Email | Password | Deskripsi |
|------|-------|----------|-----------|
| Admin | admin@sipades.com | password | Administrator utama |
| Petugas | petugas@sipades.com | password | Petugas kelurahan |
| Lurah | lurah@sipades.com | password | Kepala lurah |
| Penduduk | penduduk@sipades.com | password | Contoh penduduk |

## 🔧 Troubleshooting

### Common Installation Issues

#### 1. Composer Install Failed
```bash
# Clear composer cache
composer clear-cache

# Install with memory limit
php -d memory_limit=-1 composer install

# Skip platform requirements
composer install --ignore-platform-reqs
```

#### 2. NPM Install Failed
```bash
# Clear npm cache
npm cache clean --force

# Delete node_modules and reinstall
rm -rf node_modules package-lock.json
npm install

# Use legacy peer deps
npm install --legacy-peer-deps
```

#### 3. Database Connection Error
```bash
# Test database connection
php artisan tinker
DB::connection()->getPdo();

# Check MySQL service
sudo systemctl status mysql        # Linux
brew services list | grep mysql    # Mac
net start mysql                    # Windows
```

#### 4. Permission Errors
```bash
# Linux/Mac
sudo chown -R $(whoami) .
chmod -R 755 .
chmod -R 775 storage bootstrap/cache

# Check Apache/Nginx user
ps aux | grep apache
ps aux | grep nginx
```

#### 5. .env Key Error
```bash
# Regenerate application key
php artisan key:generate

# Clear config cache
php artisan config:clear
```

#### 6. Migration Errors
```bash
# Check current migration status
php artisan migrate:status

# Reset migrations
php artisan migrate:reset
php artisan migrate

# Drop all tables and re-migrate
php artisan migrate:fresh
```

#### 7. Asset Compilation Errors
```bash
# Update Node.js
node --version
npm install -g npm@latest

# Clear npm cache
npm cache clean --force

# Reinstall dependencies
rm -rf node_modules package-lock.json
npm install
```

## 🔍 Verification Steps

### 1. Application Health Check
```bash
# Check Laravel installation
php artisan --version

# Check environment
php artisan env

# Check routes
php artisan route:list

# Check database connection
php artisan migrate:status
```

### 2. Web Interface Test
1. Open browser: `http://localhost:8000`
2. Login dengan akun admin
3. Navigate to different menu items
4. Test create/edit functionality
5. Check responsive design

### 3. Email Test (If Configured)
```bash
php artisan tinker
Mail::raw('Test email', function($message) {
    $message->to('test@example.com')->subject('Test');
});
```

## 📊 Performance Optimization

### 1. Development Optimization
```bash
# Clear all cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize autoloader
composer dump-autoload
```

### 2. Production Optimization
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize Composer autoloader
composer install --optimize-autoloader --no-dev
```

## 🔄 Update Procedures

### 1. Regular Updates
```bash
# Pull latest changes
git pull origin main

# Update dependencies
composer update
npm update

# Run new migrations
php artisan migrate

# Clear caches
php artisan cache:clear
php artisan config:clear
```

### 2. Version Upgrade
```bash
# Check current version
php artisan --version

# Backup database
mysqldump -u username -p sipades_db > backup.sql

# Update Laravel
composer update laravel/framework
```

## 📝 Development Workflow

### 1. Daily Development
```bash
# Start development
git pull origin main
composer install
npm install
php artisan migrate
php artisan serve

# End development
git add .
git commit -m "Your commit message"
git push origin your-branch
```

### 2. Feature Development
```bash
# Create feature branch
git checkout -b feature/new-feature

# Make changes and commit
git add .
git commit -m "Add new feature"

# Push to remote
git push origin feature/new-feature

# Create pull request on GitHub
```

## 🆘 Support

### Getting Help
1. **Documentation**: Check README.md dan FITUR_APLIKASI.md
2. **GitHub Issues**: https://github.com/Galang0304/sipades/issues
3. **Email Support**: galang@example.com
4. **Community**: Laravel Indonesia Discord/Telegram

### Reporting Bugs
1. Check existing issues first
2. Provide detailed error messages
3. Include system information
4. Steps to reproduce the issue
5. Expected vs actual behavior

---

**🎉 Selamat! SIPADES berhasil diinstall dan siap digunakan!**

Access aplikasi di: http://localhost:8000  
Login dengan akun admin untuk mulai konfigurasi sistem.
