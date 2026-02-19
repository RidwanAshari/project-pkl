<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Manajemen Aset Kantor')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #4e73df 0%, #224abe 100%);
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 1rem;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link i { margin-right: 0.5rem; }

        .sidebar-heading {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 0.75rem 1rem 0.25rem 1rem;
            letter-spacing: 0.05em;
        }
        .card { border: none; border-radius: 0.35rem; }
        .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
        .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
        .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
        .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
        .text-xs { font-size: 0.7rem; }

        .topbar {
            height: 4.375rem;
            background-color: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        .brand-logo {
            font-size: 1.4rem;
            font-weight: 700;
            color: #fff;
            padding: 1rem;
            text-decoration: none;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            white-space: nowrap;
        }
        .brand-logo:hover { color: #fff; }
    </style>

    @stack('styles')
</head>
<body>
@php
    $user = auth()->user();
    $isKabag = $user && ($user->email === 'fajar@gmail.com'); // sementara
@endphp

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 px-0 sidebar">
            <a href="{{ route('dashboard') }}" class="brand-logo text-center">
                <i class="fas fa-building"></i> Asset Manager
            </a>

            <nav class="nav flex-column mt-4">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-gauge"></i> Dashboard
                </a>

                <a class="nav-link {{ request()->routeIs('assets.*') ? 'active' : '' }}" href="{{ route('assets.index') }}">
                    <i class="fas fa-boxes"></i> Data Aset
                </a>

                <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                    <i class="fas fa-file-lines"></i> Laporan
                </a>

                <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                    <i class="fas fa-gear"></i> Pengaturan
                </a>

                <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.index') }}">
                    <i class="fas fa-user-circle"></i> Profil
                </a>

                {{-- Sidebar khusus Kabag + badge pending --}}
                @if($isKabag)
                    <div class="sidebar-heading mt-2">
                        Kabag
                    </div>

                    <a
                        class="nav-link d-flex align-items-center justify-content-between {{ request()->routeIs('kabag.acc.index') ? 'active' : '' }}"
                        href="{{ route('kabag.acc.index') }}"
                    >
                        <span>
                            <i class="fas fa-file-signature"></i> Verifikasi Surat
                        </span>

                        @if(($pendingSuratCount ?? 0) > 0)
                            <span class="badge text-bg-warning">{{ $pendingSuratCount }}</span>
                        @endif
                    </a>
                @endif
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 px-0">
            <!-- Topbar -->
            <nav class="topbar d-flex align-items-center justify-content-between px-4">
                <h5 class="mb-0">Sistem Manajemen Aset Kantor</h5>

                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted">
                        <i class="fas fa-user-circle fa-lg"></i>
                        {{ $user?->name ?? 'User' }}
                        @if($isKabag)
                            <span class="badge text-bg-primary ms-2">Kabag</span>
                        @endif
                    </span>

                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-right-from-bracket me-1"></i> Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
