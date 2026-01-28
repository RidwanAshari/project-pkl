<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Asset Manager'))</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4e73df;
            --primary-dark: #224abe;
            --success-color: #1cc88a;
            --warning-color: #f6c23e;
            --info-color: #36b9cc;
            --danger-color: #e74a3b;
        }
        
        body {
            background-color: #f8f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            position: fixed;
            width: 250px;
            z-index: 1000;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 1rem;
            transition: all 0.3s;
            border-radius: 0.375rem;
            margin: 0.25rem 1rem;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }
        
        .sidebar .nav-link i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }
        
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .border-left-primary {
            border-left: 0.25rem solid var(--primary-color) !important;
        }
        
        .border-left-success {
            border-left: 0.25rem solid var(--success-color) !important;
        }
        
        .border-left-warning {
            border-left: 0.25rem solid var(--warning-color) !important;
        }
        
        .border-left-info {
            border-left: 0.25rem solid var(--info-color) !important;
        }
        
        .border-left-danger {
            border-left: 0.25rem solid var(--danger-color) !important;
        }
        
        .topbar {
            height: 70px;
            background-color: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            position: sticky;
            top: 0;
            z-index: 999;
            padding: 0 2rem;
        }
        
        .brand-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            padding: 1.5rem 1rem;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        
        .brand-logo:hover {
            color: #fff;
            opacity: 0.9;
        }
        
        .brand-logo i {
            margin-right: 10px;
        }
        
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            transition: margin-left 0.3s;
        }
        
        .user-dropdown {
            cursor: pointer;
        }
        
        .user-dropdown-menu {
            min-width: 200px;
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border-radius: 0.5rem;
            padding: 0.5rem;
        }
        
        .user-dropdown-menu .dropdown-item {
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }
        
        .user-dropdown-menu .dropdown-item:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .toggle-sidebar {
            display: none;
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
                transition: margin-left 0.3s;
            }
            
            .sidebar.show {
                margin-left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .toggle-sidebar {
                display: block;
            }
            
            .topbar {
                padding: 0 1rem;
            }
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.5rem 2rem;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .alert {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }
        
        .badge {
            padding: 0.5em 0.8em;
            border-radius: 50rem;
        }
        
        .page-title {
            color: var(--primary-dark);
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(78, 115, 223, 0.1);
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .page-header h1 {
            color: var(--primary-dark);
            font-weight: 700;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="{{ route('dashboard') }}" class="brand-logo">
            <i class="fas fa-cubes"></i> Asset Manager
        </a>
        <nav class="nav flex-column mt-4">
            @auth
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-gauge"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('assets.*') ? 'active' : '' }}" href="{{ route('assets.index') }}">
                    <i class="fas fa-boxes"></i> Data Aset
                </a>
                <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                    <i class="fas fa-chart-line"></i> Laporan
                </a>
                <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                    <i class="fas fa-cog"></i> Pengaturan
                </a>
                <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.index') }}">
                    <i class="fas fa-user"></i> Profil Saya
                </a>
                
                <!-- Logout Button in Sidebar for Mobile -->
                <div class="d-block d-md-none mt-4 px-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-light w-100">
                            <i class="fas fa-sign-out-alt me-2"></i> Keluar
                        </button>
                    </form>
                </div>
            @endauth
        </nav>
    </div>
    
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Topbar -->
        <nav class="topbar d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <button class="toggle-sidebar me-3" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="mb-0 fw-semibold text-primary">@yield('page-title', 'Sistem Manajemen Aset')</h5>
            </div>
            
            <div class="d-flex align-items-center">
                <!-- Notification Bell -->
                <div class="position-relative me-4">
                    <button class="btn btn-light rounded-circle p-2" type="button" id="notificationDropdown" 
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end user-dropdown-menu" aria-labelledby="notificationDropdown">
                        <h6 class="dropdown-header">Notifikasi</h6>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-exclamation-circle text-warning me-2"></i>
                            <div>
                                <small class="text-muted">5 menit lalu</small>
                                <p class="mb-0">Aset XYZ perlu perawatan</p>
                            </div>
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-info-circle text-info me-2"></i>
                            <div>
                                <small class="text-muted">1 jam lalu</small>
                                <p class="mb-0">Laporan bulanan siap</p>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-center text-primary" href="#">
                            Lihat Semua Notifikasi
                        </a>
                    </div>
                </div>
                
                <!-- User Dropdown -->
                @auth
                    <div class="dropdown">
                        <button class="btn d-flex align-items-center user-dropdown" type="button" 
                                id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar me-2">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="d-none d-md-block text-start">
                                <div class="fw-semibold">{{ Auth::user()->name }}</div>
                                <small class="text-muted">{{ Auth::user()->role ?? 'Admin' }}</small>
                            </div>
                            <i class="fas fa-chevron-down ms-2"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end user-dropdown-menu" aria-labelledby="userDropdown">
                            <div class="dropdown-header">
                                <div class="fw-semibold">{{ Auth::user()->name }}</div>
                                <small>{{ Auth::user()->email }}</small>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                <i class="fas fa-user-circle me-2"></i> Profil Saya
                            </a>
                            <a class="dropdown-item" href="{{ route('settings.index') }}">
                                <i class="fas fa-cog me-2"></i> Pengaturan
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            <i class="fas fa-sign-in-alt me-2"></i> Masuk
                        </a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus me-2"></i> Daftar
                            </a>
                        @endif
                    </div>
                @endauth
            </div>
        </nav>
        
        <!-- Page Content -->
        <main class="p-4">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> 
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <!-- Page Header -->
            @hasSection('page-header')
                <div class="page-header">
                    <h1>@yield('page-header')</h1>
                    @hasSection('page-actions')
                        <div class="page-actions">
                            @yield('page-actions')
                        </div>
                    @endif
                </div>
            @endif
            
            <!-- Main Content -->
            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="py-3 px-4 border-top mt-5">
            <div class="row">
                <div class="col-md-6">
                    <small class="text-muted">
                        &copy; {{ date('Y') }} Asset Manager - Sistem Manajemen Aset Kantor
                    </small>
                </div>
                <div class="col-md-6 text-end">
                    <small class="text-muted">
                        Versi 1.0.0 | 
                        <a href="#" class="text-decoration-none">Bantuan</a> | 
                        <a href="#" class="text-decoration-none">Kebijakan Privasi</a>
                    </small>
                </div>
            </div>
        </footer>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Toggle Sidebar for Mobile
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        
        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            
            if (window.innerWidth <= 768) {
                if (sidebar.classList.contains('show')) {
                    mainContent.style.marginLeft = '250px';
                } else {
                    mainContent.style.marginLeft = '0';
                }
            }
        });
        
        // Auto-hide sidebar on mobile when clicking outside
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                !toggleSidebar.contains(e.target) && 
                sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                mainContent.style.marginLeft = '0';
            }
        });
        
        // Update active nav link based on current URL
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });
        
        // Initialize tooltips
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    </script>
    
    @stack('scripts')
</body>
</html>