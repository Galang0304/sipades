<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'KUINSEL') | Sistem Informasi Pelayanan Administrasi Desa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    
    @stack('styles')
    
    <style>
        .main-header .navbar {
            background-color: #28a745 !important;
        }
        .main-sidebar {
            background-color: #343a40 !important;
        }
        .brand-link {
            background-color: #28a745 !important;
        }
        
        /* Navbar profile image styling */
        .navbar .nav-link img.img-circle {
            border: 2px solid #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        /* Dropdown profile image styling */
        .user-header img.img-circle {
            border: 3px solid rgba(255,255,255,0.3);
            margin: 10px auto;
        }
        
        /* Logout button styling */
        .nav-sidebar .nav-link.text-danger:hover {
            background-color: #dc3545 !important;
            color: #fff !important;
        }
        
        .nav-sidebar .nav-link.text-danger {
            border-top: 1px solid #495057;
            margin-top: 20px;
            padding-top: 15px !important;
        }
        
        .nav-sidebar .nav-link.text-danger .nav-icon {
            margin-right: 10px;
        }
        
        /* Badge notification styling */
        .nav-sidebar .badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.4rem;
            font-weight: bold;
        }
        
        .nav-sidebar .badge.right {
            margin-left: auto;
            margin-right: 0.5rem;
        }
        
        /* User dropdown menu styling */
        .user-menu .dropdown-menu {
            min-width: 280px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .user-menu .dropdown-header {
            padding: 10px 15px;
            text-align: center;
        }
        
        .user-menu .dropdown-menu .btn {
            margin: 2px;
        }
        
        /* Force dropdown to show when needed */
        .user-menu.show .dropdown-menu,
        .user-menu .dropdown-menu.show {
            display: block !important;
        }
        
        /* Make sure dropdown is clickable */
        .dropdown-toggle::after {
            content: "";
        }
        
        /* Ensure dropdown positioning */
        .dropdown-menu-right {
            right: 0;
            left: auto;
        }
        
        /* Make sidebar scrollable and logout always at bottom */
        .sidebar {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 57px);
        }
        
        .sidebar .nav {
            flex: 1;
        }

        /* Treeview menu styles */
        .nav-treeview {
            display: none;
            padding-left: 15px;
            margin-left: 0;
            list-style: none;
        }

        .menu-open > .nav-treeview {
            display: block;
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-item .fa-angle-left {
            transition: transform 0.3s;
            float: right;
            margin-top: 3px;
        }

        .menu-open > .nav-link .fa-angle-left {
            transform: rotate(-90deg);
        }

        .nav-sidebar .nav-link p {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-sidebar .nav-treeview .nav-link {
            padding-left: 1rem;
            font-size: 0.95em;
        }

        .nav-sidebar .nav-treeview .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            @auth
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                    <!-- Foto profil bulat kecil -->
                    @if(auth()->user()->foto_profil)
                        <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" 
                             alt="Foto Profil" 
                             class="img-circle"
                             style="width: 25px; height: 25px; object-fit: cover; margin-right: 8px;">
                    @else
                        <img src="{{ asset('images/default-avatar.svg') }}" 
                             alt="Default Avatar" 
                             class="img-circle"
                             style="width: 25px; height: 25px; object-fit: cover; margin-right: 8px;">
                    @endif
                    <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                    <i class="fas fa-caret-down ml-1"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <!-- User info -->
                    <div class="dropdown-header bg-primary text-white">
                        <strong>{{ auth()->user()->name }}</strong><br>
                        <small>{{ auth()->user()->role_name }}</small>
                    </div>
                    <!-- Menu Body-->
                    <div class="dropdown-divider"></div>
                    <div class="row mx-2 my-3">
                        <div class="col-6">
                            <a href="{{ route('surat.create') }}" class="btn btn-primary btn-sm btn-block">
                                <i class="fas fa-plus-circle"></i> Buat Surat
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('profile.edit') }}" class="btn btn-secondary btn-sm btn-block">
                                <i class="fas fa-user-edit"></i> Edit Profile
                            </a>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <!-- Menu Footer-->
                    <div class="dropdown-item-text text-center">
                        <a href="#" class="btn btn-danger btn-sm" onclick="confirmLogout()">
                            <i class="fas fa-sign-out-alt"></i> Sign out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </li>
            @endauth
        </ul>
    </nav>

    <!-- Main Sidebar Container -->
    @auth
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('dashboard') }}" class="brand-link">
            @if(file_exists(public_path('assets/images/logo/kuinsel-logo.png')))
                <img src="{{ asset('assets/images/logo/kuinsel-logo.png') }}" alt="KUINSEL Logo" class="brand-image img-circle elevation-3" style="opacity: .8; max-height: 33px;">
            @else
                <i class="fas fa-building brand-image" style="opacity: .8; margin-left: 10px; font-size: 20px;"></i>
            @endif
            <span class="brand-text font-weight-light">KUINSEL</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') && !request()->routeIs('laporan.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    @role('admin|petugas')
                    <!-- Data Penduduk -->
                    <li class="nav-item">
                        <a href="{{ route('penduduk.index') }}" class="nav-link {{ request()->routeIs('penduduk.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Data Penduduk</p>
                        </a>
                    </li>
                    @endrole

                    @role('admin')
                    <!-- User Approval -->
                    <li class="nav-item">
                        <a href="{{ route('user-approval.index') }}" class="nav-link {{ request()->routeIs('user-approval.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>
                                User Approval
                                @php
                                    $pendingCount = \App\Models\User::where('is_pending', true)->where('is_active', false)->count();
                                @endphp
                                @if($pendingCount > 0)
                                    <span class="badge badge-warning right">{{ $pendingCount }}</span>
                                @endif
                            </p>
                        </a>
                    </li>

                    <!-- Role Management -->
                    <li class="nav-item">
                        <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-tag"></i>
                            <p>Manajemen Role</p>
                        </a>
                    </li>
                    @endrole

                    @role('petugas')
                    <!-- User Approval for Petugas -->
                    <li class="nav-item">
                        <a href="{{ route('user-approval.index') }}" class="nav-link {{ request()->routeIs('user-approval.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-clock"></i>
                            <p>
                                User Approval
                                @php
                                    $pendingCountPetugas = \App\Models\User::where('is_pending', true)->where('is_active', false)->count();
                                @endphp
                                @if($pendingCountPetugas > 0)
                                    <span class="badge badge-warning right">{{ $pendingCountPetugas }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                    @endrole

                    <!-- Surat -->
                    <li class="nav-item {{ request()->routeIs('surat.*') || request()->routeIs('validasi.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('surat.*') || request()->routeIs('validasi.*') ? 'active' : '' }}" data-toggle="treeview">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>
                                Surat
                                @php
                                    $totalNotifications = 0;
                                    if(isset($notifications['surat_pending_petugas'])) {
                                        $totalNotifications += $notifications['surat_pending_petugas'];
                                    }
                                    if(isset($notifications['surat_pending_lurah'])) {
                                        $totalNotifications += $notifications['surat_pending_lurah'];
                                    }
                                @endphp
                                @if($totalNotifications > 0)
                                    <span class="badge badge-info right">{{ $totalNotifications }}</span>
                                @endif
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(auth()->user()->hasRole(['admin', 'user']))
                            <li class="nav-item">
                                <a href="{{ route('surat.create') }}" class="nav-link {{ request()->routeIs('surat.create') ? 'active' : '' }}">
                                    <i class="far fa-plus-square nav-icon"></i>
                                    <p>Buat Surat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('surat.index') }}" class="nav-link {{ request()->routeIs('surat.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pengajuan Surat</p>
                                </a>
                            </li>
                            @endif

                            @if(auth()->user()->hasRole('petugas'))
                            <li class="nav-item">
                                <a href="{{ route('surat.index') }}" class="nav-link {{ request()->routeIs('surat.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Proses Surat
                                        @if(isset($notifications['surat_pending_petugas']) && $notifications['surat_pending_petugas'] > 0)
                                            <span class="badge badge-danger right">{{ $notifications['surat_pending_petugas'] }}</span>
                                        @endif
                                    </p>
                                </a>
                            </li>
                            @endif
                            
                            @if(auth()->user()->hasRole(['admin', 'lurah']))
                            <li class="nav-item">
                                <a href="{{ route('validasi.index') }}" class="nav-link {{ request()->routeIs('validasi.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Validasi Surat
                                        @if(isset($notifications['surat_pending_lurah']) && $notifications['surat_pending_lurah'] > 0)
                                            <span class="badge badge-warning right">{{ $notifications['surat_pending_lurah'] }}</span>
                                        @endif
                                    </p>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>

                    <!-- Informasi Public - untuk semua role -->
                    <li class="nav-item">
                        <a href="{{ route('informasi.public') }}" class="nav-link {{ request()->routeIs('informasi.public') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>Informasi Public</p>
                        </a>
                    </li>

                    @hasrole(['admin', 'petugas'])
                    <!-- Kelola Informasi -->
                    <li class="nav-item">
                        <a href="{{ route('informasi.index') }}" class="nav-link {{ request()->routeIs('informasi.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-info-circle"></i>
                            <p>Kelola Informasi</p>
                        </a>
                    </li>
                    @endhasrole

                    @hasrole(['admin', 'petugas', 'lurah'])
                    <!-- Laporan -->
                    <li class="nav-item {{ request()->routeIs('laporan.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" data-toggle="treeview">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>
                                Laporan
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('laporan.surat') }}" class="nav-link {{ request()->routeIs('laporan.surat') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Surat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('laporan.penduduk') }}" class="nav-link {{ request()->routeIs('laporan.penduduk') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Penduduk</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('laporan.informasi') }}" class="nav-link {{ request()->routeIs('laporan.informasi') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Informasi</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endhasrole

                    <!-- Profile Menu untuk semua user -->
                    <li class="nav-item">
                        <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-edit"></i>
                            <p>Edit Profile</p>
                        </a>
                    </li>

                    <!-- Logout Button -->
                    <li class="nav-item">
                        <a href="#" class="nav-link text-danger" onclick="confirmLogout()">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                        <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>
    @endauth

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
                
            </div>
        </section>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stack('scripts')

<script>
    // Setup CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Logout confirmation function
    function confirmLogout() {
        Swal.fire({
            title: 'Konfirmasi Logout',
            text: 'Apakah Anda yakin ingin keluar dari sistem?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('sidebar-logout-form').submit();
            }
        });
    }

    // Show SweetAlert for success/error messages
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session("error") }}'
        });
    @endif

    // Initialize Sidebar Menu
    $(document).ready(function() {
        // Initialize AdminLTE sidebar
        if (typeof $.fn.Treeview !== 'undefined') {
            $('[data-widget="treeview"]').Treeview('init');
        }
        
        // Initialize Bootstrap dropdowns
        $('.dropdown-toggle').dropdown();
        
        // Manual dropdown toggle for user menu (fallback)
        $('.user-menu .dropdown-toggle').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const $dropdown = $(this).parent();
            const $menu = $dropdown.find('.dropdown-menu');
            
            // Close all other dropdowns
            $('.dropdown').not($dropdown).removeClass('show').find('.dropdown-menu').removeClass('show');
            
            // Toggle current dropdown
            $dropdown.toggleClass('show');
            $menu.toggleClass('show');
        });
        
        // Close dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.user-menu').length) {
                $('.user-menu').removeClass('show').find('.dropdown-menu').removeClass('show');
            }
        });
        
        // Fallback for dropdown functionality
        $('.nav-link[data-toggle="treeview"]').off('click').on('click', function(e) {
            e.preventDefault();
            
            const $this = $(this);
            const $parent = $this.parent('.nav-item');
            const $submenu = $this.siblings('.nav-treeview');
            
            // Close other open menus
            $('.nav-item.menu-open').not($parent).removeClass('menu-open').find('.nav-treeview').slideUp(300);
            
            // Toggle current menu
            if ($parent.hasClass('menu-open')) {
                $parent.removeClass('menu-open');
                $submenu.slideUp(300);
            } else {
                $parent.addClass('menu-open');
                $submenu.slideDown(300);
            }
        });

        // Keep active submenu open
        $('.nav-treeview .nav-link.active').each(function() {
            $(this).closest('.nav-item').addClass('menu-open');
            $(this).closest('.nav-treeview').show();
        });
    });
</script>

@stack('scripts')

</body>
</html>
