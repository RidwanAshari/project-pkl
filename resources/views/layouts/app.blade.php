<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manajemen Aset Kantor')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --sidebar-bg: #1f2937;
            --sidebar-bg-alt: #111827;
            --sidebar-accent: #3b82f6;
            --sidebar-text: #e5e7eb;
            --sidebar-text-muted: #9ca3af;
            /* background konten lebih gelap sedikit, tidak putih */
            --content-bg: #e0e7ff; /* bisa diganti #e5e7eb / #dde5f0 sesuai selera */
        }

        body {
            background-color: var(--content-bg);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            font-size: 14px;
            color: #111827;
        }

        .sidebar {
            min-height: 100vh;
            background: radial-gradient(circle at top, #111827 0, var(--sidebar-bg) 45%, var(--sidebar-bg-alt) 100%);
            box-shadow: 2px 0 12px rgba(15, 23, 42, 0.4);
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 1rem 1rem 0.9rem;
            color: var(--sidebar-text);
            text-decoration: none;
            border-bottom: 1px solid rgba(31, 41, 55, 0.9);
        }

        .brand-logo-icon {
            width: 32px;
            height: 32px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            color: #f9fafb;
            box-shadow: 0 6px 12px rgba(37, 99, 235, 0.5);
        }

        .brand-logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .brand-logo-text .title {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .brand-logo-text .subtitle {
            font-size: 0.7rem;
            color: var(--sidebar-text-muted);
        }

        .sidebar .nav {
            padding: 0.75rem 0.5rem 1rem;
        }

        .sidebar-section-title {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--sidebar-text-muted);
            padding: 0.4rem 0.75rem 0.25rem;
        }

        .sidebar .nav-link {
            color: var(--sidebar-text);
            margin: 0.1rem 0.25rem;
            padding: 0.55rem 0.8rem;
            border-radius: 0.5rem;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.55rem;
            transition: background-color 0.18s, color 0.18s, transform 0.08s;
            white-space: nowrap;
        }

        .sidebar .nav-link i {
            font-size: 0.9rem;
            width: 1.1rem;
            text-align: center;
        }

        .sidebar .nav-link span {
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(55, 65, 81, 0.8);
            color: #f9fafb;
            transform: translateX(1px);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(90deg, var(--sidebar-accent), #22c55e);
            color: #f9fafb;
            box-shadow: 0 0 0 1px rgba(15, 23, 42, 0.5), 0 4px 10px rgba(15, 23, 42, 0.5);
        }

        .sidebar .nav-link.active i {
            color: #eff6ff;
        }

        .sidebar-divider {
            border-color: rgba(55, 65, 81, 0.9);
            margin: 0.4rem 0.75rem;
        }

        .topbar {
            height: 3.5rem;
            /* sedikit lebih gelap daripada putih murni */
            background-color: #f1f5f9;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.08);
        }

        .topbar h5 {
            font-size: 0.95rem;
            font-weight: 600;
            color: #111827;
        }

        .topbar .user-info {
            font-size: 0.85rem;
            color: #4b5563;
        }

        .topbar .user-info i {
            color: #6b7280;
        }

        .topbar .badge {
            font-size: 0.7rem;
        }

        .content-wrapper {
            padding: 1.25rem 1.5rem 1.75rem;
            background-color: var(--content-bg);
            min-height: calc(100vh - 3.5rem);
        }

        .card {
            border-radius: 0.6rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.1);
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

        {{-- SIDEBAR: include per role --}}
        <aside class="col-md-2 px-0 sidebar">
            <a href="{{ route('dashboard') }}" class="brand-logo">
                <div class="brand-logo-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="brand-logo-text">
                    <span class="title">Asset Manager</span>
                    <span class="subtitle">Office Assets System</span>
                </div>
            </a>

            @auth
                {{-- layouts/sidebar/staff.blade.php, kabag.blade.php, finance.blade.php --}}
                @includeIf('layouts.sidebar.' . $user->role)
            @endauth
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="col-md-10 px-0">

            {{-- Topbar --}}
            <nav class="topbar d-flex align-items-center justify-content-between px-4">
                <h5 class="mb-0">Sistem Manajemen Aset Kantor</h5>

                <div class="d-flex align-items-center gap-3">
                    <div class="user-info d-flex align-items-center gap-2">
                        <i class="fas fa-user-circle fa-lg"></i>
                        <span>
                            {{ $user?->name ?? 'User' }}
                            @if($user)
                                <span class="badge text-bg-primary ms-2 text-capitalize">
                                    {{ $user->role }}
                                </span>
                            @endif
                        </span>
                    </div>

                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-right-from-bracket me-1"></i>
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </nav>

            <section class="content-wrapper">
                @yield('content')
            </section>

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>
