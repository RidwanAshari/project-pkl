<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manajemen Aset Kantor')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        
        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }
        
        .sidebar-section-title {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.5rem 1rem;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
        }
        
        .card {
            border: none;
            border-radius: 0.35rem;
        }
        
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }
        
        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }
        
        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }
        
        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }
        
        .text-xs {
            font-size: 0.7rem;
        }
        
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
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }
        
        .brand-logo:hover {
            color: #fff;
        }
    </style>
    @stack('styles')
</head>
<body>

@php
    $user = auth()->user();
@endphp

<div class="container-fluid">
    <div class="row">
        {{-- SIDEBAR --}}
        <div class="col-md-2 px-0 sidebar">
            <a href="{{ route('dashboard') }}" class="brand-logo text-center">
                <i class="fas fa-building"></i> Asset Manager
            </a>
            <nav class="nav flex-column mt-4">
                @auth
                    @includeIf('layouts.sidebar.' . $user->role)
                @endauth
            </nav>
        </div>
        
        {{-- MAIN CONTENT --}}
        <div class="col-md-10 px-0">
            {{-- Topbar --}}
            <nav class="topbar d-flex align-items-center justify-content-between px-4">
                <h5 class="mb-0">Sistem Manajemen Aset Kantor</h5>
                <div class="d-flex align-items-center">
                    <span class="me-3">
                        <i class="fas fa-user-circle"></i> {{ $user?->name ?? 'User' }}
                        @if($user)
                            <span class="badge bg-primary ms-2 text-capitalize">{{ $user->role }}</span>
                        @endif
                    </span>
                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-power-off"></i> Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </nav>
            
            <div class="p-4">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>