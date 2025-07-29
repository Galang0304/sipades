# 🚀 Panduan Deployment SIPADES

## 📋 Overview

Panduan lengkap untuk deploy aplikasi SIPADES ke production environment menggunakan berbagai platform hosting.

## 🌐 Deployment Platforms

### 1. Shared Hosting (cPanel)
### 2. VPS/Cloud Server (Ubuntu/CentOS)
### 3. Platform as a Service (Heroku, Railway)
### 4. Container Deployment (Docker)

---

## 🏠 Shared Hosting Deployment

### Prerequisites
- cPanel hosting dengan PHP 8.0+
- MySQL database
- SSH access (optional)
- File manager atau FTP client

### Step 1: Prepare Files
```bash
# Local preparation
composer install --optimize-autoloader --no-dev
npm run production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 2: Upload Files
```bash
# Struktur folder di hosting
public_html/
├── sipades/           # Laravel application files
│   ├── app/
│   ├── config/
│   ├── database/
│   └── ...
└── public/           # Public folder contents
    ├── index.php
    ├── assets/
    └── ...
```

### Step 3: Database Setup
```sql
-- Create database via cPanel
-- Import database.sql
-- Update .env with hosting database credentials
```

### Step 4: Configuration
```php
// public/index.php - Update paths
require __DIR__.'/../sipades/vendor/autoload.php';
$app = require_once __DIR__.'/../sipades/bootstrap/app.php';
```

```bash
# .htaccess for subdirectory
RewriteEngine On
RewriteRule ^(.*)$ public/$1 [L]
```

---

## 🖥️ VPS/Cloud Server Deployment

### Ubuntu 20.04/22.04 Setup

#### Step 1: Server Preparation
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install -y nginx mysql-server php8.1-fpm php8.1-mysql \
    php8.1-mbstring php8.1-xml php8.1-bcmath php8.1-curl \
    php8.1-zip php8.1-gd php8.1-intl composer nodejs npm git
```

#### Step 2: MySQL Configuration
```bash
# Secure MySQL installation
sudo mysql_secure_installation

# Create database
sudo mysql -u root -p
```

```sql
CREATE DATABASE sipades_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'sipades_user'@'localhost' IDENTIFIED BY 'secure_random_password';
GRANT ALL PRIVILEGES ON sipades_production.* TO 'sipades_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### Step 3: Application Deployment
```bash
# Clone repository
cd /var/www
sudo git clone https://github.com/Galang0304/sipades.git
sudo chown -R www-data:www-data sipades
cd sipades

# Install dependencies
sudo -u www-data composer install --optimize-autoloader --no-dev
sudo -u www-data npm install
sudo -u www-data npm run production
```

#### Step 4: Environment Configuration
```bash
# Copy and edit environment
sudo -u www-data cp .env.example .env
sudo -u www-data nano .env
```

```env
APP_NAME="SIPADES"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipades_production
DB_USERNAME=sipades_user
DB_PASSWORD=secure_random_password

# SSL/TLS Configuration
FORCE_HTTPS=true
SESSION_SECURE_COOKIE=true

# Cache Configuration
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

#### Step 5: Laravel Configuration
```bash
# Generate application key
sudo -u www-data php artisan key:generate

# Run migrations
sudo -u www-data php artisan migrate --force

# Seed database
sudo -u www-data php artisan db:seed --force

# Create storage link
sudo -u www-data php artisan storage:link

# Cache configuration
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
```

#### Step 6: Nginx Configuration
```nginx
# /etc/nginx/sites-available/sipades
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name your-domain.com www.your-domain.com;
    root /var/www/sipades/public;
    
    index index.php index.html index.htm;
    
    # SSL Configuration
    ssl_certificate /path/to/ssl/certificate.pem;
    ssl_certificate_key /path/to/ssl/private.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512;
    
    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
    
    location ~* \.(jpg|jpeg|png|gif|ico|css|js)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

```bash
# Enable site and restart nginx
sudo ln -s /etc/nginx/sites-available/sipades /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
sudo systemctl enable nginx
```

#### Step 7: PHP-FPM Configuration
```ini
# /etc/php/8.1/fpm/pool.d/www.conf
[www]
user = www-data
group = www-data
listen = /var/run/php/php8.1-fpm.sock
pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 35
pm.max_requests = 1000
```

```bash
sudo systemctl restart php8.1-fpm
sudo systemctl enable php8.1-fpm
```

#### Step 8: SSL Certificate (Let's Encrypt)
```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx

# Obtain SSL certificate
sudo certbot --nginx -d your-domain.com -d www.your-domain.com

# Auto-renewal
sudo crontab -e
# Add: 0 12 * * * /usr/bin/certbot renew --quiet
```

---

## ☁️ Cloud Platform Deployment

### Heroku Deployment

#### Step 1: Prepare Application
```bash
# Install Heroku CLI
# Create Procfile
echo "web: vendor/bin/heroku-php-apache2 public/" > Procfile

# Add to .gitignore
echo "/vendor" >> .gitignore
echo "/node_modules" >> .gitignore
echo ".env" >> .gitignore
```

#### Step 2: Heroku Setup
```bash
# Login to Heroku
heroku login

# Create application
heroku create sipades-app

# Add buildpacks
heroku buildpacks:add heroku/php
heroku buildpacks:add heroku/nodejs

# Add database
heroku addons:create cleardb:ignite
```

#### Step 3: Environment Variables
```bash
# Set environment variables
heroku config:set APP_NAME="SIPADES"
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_KEY=$(php artisan --no-ansi key:generate --show)

# Database (from ClearDB addon)
heroku config:set DB_CONNECTION=mysql
heroku config:set DB_HOST=your-cleardb-host
heroku config:set DB_PORT=3306
heroku config:set DB_DATABASE=your-cleardb-database
heroku config:set DB_USERNAME=your-cleardb-username
heroku config:set DB_PASSWORD=your-cleardb-password
```

#### Step 4: Deploy
```bash
# Commit and push
git add .
git commit -m "Prepare for Heroku deployment"
git push heroku main

# Run migrations
heroku run php artisan migrate --force
heroku run php artisan db:seed --force
```

### Railway Deployment

#### Step 1: Railway Setup
```bash
# Install Railway CLI
npm install -g @railway/cli

# Login and init
railway login
railway init
```

#### Step 2: Configure railway.json
```json
{
  "build": {
    "builder": "nixpacks"
  },
  "deploy": {
    "startCommand": "php artisan serve --host=0.0.0.0 --port=$PORT",
    "healthcheckPath": "/",
    "healthcheckTimeout": 300
  }
}
```

#### Step 3: Environment Variables
```bash
# Set via Railway dashboard or CLI
railway variables set APP_KEY=$(php artisan --no-ansi key:generate --show)
railway variables set APP_ENV=production
railway variables set APP_DEBUG=false
```

---

## 🐳 Docker Deployment

### Dockerfile
```dockerfile
FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader --no-dev
RUN npm install && npm run production

# Set permissions
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

EXPOSE 9000

CMD ["php-fpm"]
```

### docker-compose.yml
```yaml
version: '3.8'

services:
  app:
    build: .
    container_name: sipades-app
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./:/var/www
    networks:
      - sipades

  nginx:
    image: nginx:alpine
    container_name: sipades-nginx
    restart: unless-stopped
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./:/var/www
      - ./docker/nginx:/etc/nginx/conf.d
    networks:
      - sipades

  mysql:
    image: mysql:8.0
    container_name: sipades-mysql
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: sipades
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_USER: sipades_user
      MYSQL_PASSWORD: user_password
    volumes:
      - mysql_data:/var/lib/mysql
    networks:
      - sipades

  redis:
    image: redis:alpine
    container_name: sipades-redis
    restart: unless-stopped
    networks:
      - sipades

networks:
  sipades:
    driver: bridge

volumes:
  mysql_data:
```

---

## 🔧 Post-Deployment Configuration

### 1. Performance Optimization
```bash
# Enable OPcache
# php.ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=2
opcache.fast_shutdown=1

# Install Redis (for caching)
sudo apt install redis-server
sudo systemctl enable redis-server
```

### 2. Monitoring Setup
```bash
# Install monitoring tools
sudo apt install htop iotop nethogs

# Setup log rotation
sudo nano /etc/logrotate.d/sipades
```

```
/var/www/sipades/storage/logs/*.log {
    daily
    rotate 30
    missingok
    notifempty
    compress
    delaycompress
    create 644 www-data www-data
}
```

### 3. Backup Strategy
```bash
# Database backup script
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/sipades"
mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u sipades_user -p sipades_production > $BACKUP_DIR/database_$DATE.sql

# Files backup
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/sipades/storage/app

# Cleanup old backups (keep 30 days)
find $BACKUP_DIR -type f -mtime +30 -delete
```

### 4. Security Hardening
```bash
# Install fail2ban
sudo apt install fail2ban

# Configure firewall
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable

# Hide server information
# nginx.conf
server_tokens off;

# php.ini
expose_php = Off
```

---

## 🚨 Troubleshooting

### Common Issues

#### 1. Permission Errors
```bash
sudo chown -R www-data:www-data /var/www/sipades
sudo chmod -R 755 /var/www/sipades
sudo chmod -R 775 /var/www/sipades/storage
sudo chmod -R 775 /var/www/sipades/bootstrap/cache
```

#### 2. Database Connection
```bash
# Test connection
php artisan tinker
DB::connection()->getPdo();

# Check MySQL status
sudo systemctl status mysql
```

#### 3. SSL Issues
```bash
# Check certificate
sudo certbot certificates

# Renew certificate
sudo certbot renew --dry-run
```

#### 4. Performance Issues
```bash
# Check server resources
htop
df -h
free -h

# Clear Laravel cache
php artisan cache:clear
php artisan config:clear
```

---

## 📊 Maintenance

### Regular Tasks
- **Daily**: Check logs, monitor disk space
- **Weekly**: Update system packages
- **Monthly**: Review security logs, update SSL certificates
- **Quarterly**: Laravel framework updates

### Backup Verification
```bash
# Test database restore
mysql -u root -p test_db < backup.sql

# Verify file integrity
tar -tzf backup.tar.gz > /dev/null
```

---

**🎉 SIPADES Successfully Deployed!**

Access your application at: https://your-domain.com  
Monitor logs at: `/var/www/sipades/storage/logs/laravel.log`
