<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUINSEL - Sistem Informasi Kelurahan Kuin Selatan</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="rgba(255,255,255,0.1)"><polygon points="1000,100 1000,0 0,100"/></svg>');
            background-size: cover;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .btn-custom {
            background: #dc3545;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-custom:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }
        
        .btn-outline-custom {
            border: 2px solid white;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-custom:hover {
            background: white;
            color: #28a745;
            transform: translateY(-2px);
        }
        
        /* Hero Stats */
        .hero-image-container {
            padding: 50px 0;
        }
        
        .hero-stats {
            display: flex;
            flex-direction: column;
            gap: 30px;
            max-width: 400px;
            margin: 0 auto;
        }
        
        .stat-item {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            transition: all 0.3s ease;
        }
        
        .stat-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(10px);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            font-size: 24px;
            color: white;
        }
        
        .stat-text h5 {
            margin: 0;
            color: white;
            font-weight: 600;
        }
        
        .stat-text p {
            margin: 0;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background: #f8f9fa;
        }
        
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 30px;
        }
        
        /* Info Section */
        .info-section {
            padding: 80px 0;
        }
        
        .info-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .info-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        /* Footer */
        .footer {
            background: #2c3e50;
            color: white;
            padding: 50px 0 20px;
        }
        
        .footer h5 {
            color: #28a745;
            margin-bottom: 20px;
        }
        
        .footer a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer a:hover {
            color: #28a745;
        }
        
        /* Animation */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .fade-in.active {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1.1rem;
            }
            
            .hero-stats {
                gap: 20px;
                max-width: 100%;
            }
            
            .stat-item {
                padding: 15px;
            }
            
            .stat-item:hover {
                transform: translateY(-5px);
            }
            
            .stat-icon {
                width: 50px;
                height: 50px;
                font-size: 20px;
                margin-right: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: rgba(44, 62, 80, 0.95); backdrop-filter: blur(10px);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                @if(file_exists(public_path('assets/images/logo/kuinsel-logo.png')))
                    <img src="{{ asset('assets/images/logo/kuinsel-logo.png') }}" alt="KUINSEL Logo" style="height: 35px; margin-right: 10px;">
                @else
                    <i class="fas fa-building"></i>
                @endif
                KUINSEL
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#layanan">Layanan</a>
                    </li>
                    @if(isset($informasi) && count($informasi) > 0)
                    <li class="nav-item">
                        <a class="nav-link" href="#informasi">Informasi</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content fade-in">
                        <h1 class="display-4 fw-bold mb-4">
                            Selamat Datang di KUINSEL
                        </h1>
                        <p class="lead mb-4">
                            Sistem Informasi Kelurahan Kuin Selatan. 
                            Layanan digital yang memudahkan Anda dalam mengurus berbagai keperluan administrasi kelurahan.
                        </p>
                        <div class="d-flex gap-3 flex-wrap">
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-custom btn-lg">
                                    <i class="fas fa-sign-in-alt"></i> Masuk
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-outline-custom btn-lg">
                                    <i class="fas fa-user-plus"></i> Daftar
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="btn btn-custom btn-lg">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center fade-in">
                        <div class="hero-image-container">
                            <div class="hero-stats">
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="stat-text">
                                        <h5>Surat Online</h5>
                                        <p>Mudah & Cepat</p>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="stat-text">
                                        <h5>Data Penduduk</h5>
                                        <p>Terintegrasi</p>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div class="stat-text">
                                        <h5>Informasi</h5>
                                        <p>Real-time</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="layanan" class="features">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="fw-bold fade-in">Layanan Kami</h2>
                    <p class="lead text-muted fade-in">Berbagai layanan administrasi yang dapat Anda akses secara online</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Pengajuan Surat</h4>
                        <p class="text-muted">Ajukan berbagai jenis surat keterangan secara online dengan mudah dan cepat.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Data Penduduk</h4>
                        <p class="text-muted">Kelola dan update data penduduk dengan sistem yang terintegrasi.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Informasi</h4>
                        <p class="text-muted">Dapatkan informasi terbaru dari kelurahan secara real-time.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Information Section -->
    @if(isset($informasi) && count($informasi) > 0)
    <section id="informasi" class="info-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="fw-bold fade-in">Informasi Terbaru</h2>
                    <p class="lead text-muted fade-in">Berita dan pengumuman terkini dari Kelurahan Kuin Selatan</p>
                </div>
            </div>
            <div class="row g-4">
                @foreach($informasi as $item)
                <div class="col-md-4">
                    <div class="info-card fade-in">
                        @if($item->gambar)
                            <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}">
                        @else
                            <div class="bg-primary d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-info-circle fa-3x text-white"></i>
                            </div>
                        @endif
                        <div class="p-4">
                            <div class="mb-2">
                                <span class="badge bg-primary">{{ $item->kategori ?? 'Umum' }}</span>
                                <small class="text-muted float-end">{{ $item->created_at->format('d/m/Y') }}</small>
                            </div>
                            <h5 class="fw-bold">{{ $item->judul }}</h5>
                            <p class="text-muted">{{ Str::limit($item->konten ?? $item->deskripsi ?? '', 100) }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Contact Section -->
    <section id="kontak" class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-building"></i> Kelurahan Kuin Selatan</h5>
                    <p>Sistem Informasi Kelurahan yang melayani masyarakat dengan sepenuh hati melalui platform digital KUINSEL.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-map-marker-alt"></i> Alamat</h5>
                    <p>JL. SIMPANG KUIN SELATAN RT.22 NO.01<br>
                    Kecamatan Banjarmasin Barat<br>
                    Kota Banjarmasin<br>
                    Kode Pos: 70128</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-phone"></i> Kontak</h5>
                    <p>
                        <i class="fas fa-envelope"></i> kelurahankuinsel@gmail.com<br>
                        <i class="fas fa-clock"></i> Senin - Jumat: 08:00 - 16:00<br>
                        <i class="fas fa-calendar"></i> Sabtu: 08:00 - 12:00
                    </p>
                </div>
            </div>
            <hr class="mt-4">
            <div class="row">
                <div class="col-12 text-center">
                    <p>&copy; {{ date('Y') }} KUINSEL - Kelurahan Kuin Selatan. All rights reserved.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Animation Script -->
    <script>
        // Fade in animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        // Observe all fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.style.background = 'rgba(44, 62, 80, 0.95)';
            } else {
                navbar.style.background = 'rgba(44, 62, 80, 0.95)';
            }
        });
    </script>
</body>
</html>
                         
                </div>
            </div>
        </div>
    </body>
</html>
