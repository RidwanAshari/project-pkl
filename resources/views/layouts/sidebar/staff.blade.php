{{-- resources/views/layouts/sidebar/staff.blade.php --}}
{{-- STAFF SIDEBAR --}}

@php
    $activeMenu = null;

    // Halaman detail aset / kendaraan
    if (request()->routeIs('assets.show') || request()->routeIs('vehicles.show')) {
        $currentAsset = $asset ?? null;

        if ($currentAsset) {
            $activeMenu = match ($currentAsset->tipe_dashboard) {
                'biaya'    => 'biaya',
                'pinjaman' => 'pinjaman',
                default    => 'aset',
            };
        }
    }
    // Route biaya & pinjaman
    elseif (request()->routeIs('assets-biaya.*')) {
        $activeMenu = 'biaya';
    } elseif (request()->routeIs('assets-pinjaman.*')) {
        $activeMenu = 'pinjaman';
    }
    // Route aset biasa
    elseif (request()->routeIs('assets.*')) {
        $activeMenu = 'aset';
    }
@endphp

{{-- MENU: Dashboard --}}
<a href="{{ route('dashboard') }}"
   class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <span class="me-2">
        <i class="fas fa-gauge"></i>
    </span>
    <span>Dashboard</span>
</a>

<hr class="my-2 border-light opacity-25">



<a href="{{ route('assets.index') }}"
   class="nav-link d-flex align-items-center gap-2 {{ $activeMenu === 'aset' ? 'active' : '' }}">
    <span class="me-2">
        <i class="fas fa-boxes"></i>
    </span>
    <span>Data Aset</span>
</a>

<a href="{{ route('assets-biaya.index') }}"
   class="nav-link d-flex align-items-center gap-2 {{ $activeMenu === 'biaya' ? 'active' : '' }}">
    <span class="me-2">
        <i class="fas fa-money-bill-wave"></i>
    </span>
    <span>Aset Biaya</span>
</a>

<a href="{{ route('assets-pinjaman.index') }}"
   class="nav-link d-flex align-items-center gap-2 {{ $activeMenu === 'pinjaman' ? 'active' : '' }}">
    <span class="me-2">
        <i class="fas fa-handshake"></i>
    </span>
    <span>Aset Pinjaman</span>
</a>

<hr class="my-2 border-light opacity-25">


<a href="{{ route('reports.index') }}"
   class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('reports.*') ? 'active' : '' }}">
    <span class="me-2">
        <i class="fas fa-file-lines"></i>
    </span>
    <span>Laporan</span>
</a>

<a href="{{ route('settings.index') }}"
   class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('settings.*') ? 'active' : '' }}">
    <span class="me-2">
        <i class="fas fa-gear"></i>
    </span>
    <span>Pengaturan</span>
</a>

<a href="{{ route('profile.index') }}"
   class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('profile.*') ? 'active' : '' }}">
    <span class="me-2">
        <i class="fas fa-user-circle"></i>
    </span>
    <span>Profil</span>
</a>