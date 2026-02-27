{{-- KABAG SIDEBAR --}}

<a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
   href="{{ route('dashboard') }}">
    <i class="fas fa-gauge"></i> Dashboard
</a>

@php
    $activeMenu = null;
    if (request()->routeIs('assets.show') || request()->routeIs('vehicles.show')) {
        $currentAsset = isset($asset) ? $asset : null;
        if ($currentAsset) {
            if ($currentAsset->tipe_dashboard === 'biaya') {
                $activeMenu = 'biaya';
            } elseif ($currentAsset->tipe_dashboard === 'pinjaman') {
                $activeMenu = 'pinjaman';
            } else {
                $activeMenu = 'aset';
            }
        }
    }
    elseif (request()->routeIs('assets-biaya.*')) {
        $activeMenu = 'biaya';
    } elseif (request()->routeIs('assets-pinjaman.*')) {
        $activeMenu = 'pinjaman';
    }
    elseif (request()->routeIs('assets.*')) {
        $activeMenu = 'aset';
    }
@endphp

<a class="nav-link {{ $activeMenu === 'aset' ? 'active' : '' }}" 
   href="{{ route('assets.index') }}">
    <i class="fas fa-boxes"></i> Data Aset
</a>

<a class="nav-link {{ $activeMenu === 'biaya' ? 'active' : '' }}" 
   href="{{ route('assets-biaya.index') }}">
    <i class="fas fa-money-bill-wave"></i> Aset Biaya
</a>

<a class="nav-link {{ $activeMenu === 'pinjaman' ? 'active' : '' }}" 
   href="{{ route('assets-pinjaman.index') }}">
    <i class="fas fa-handshake"></i> Aset Pinjaman
</a>

{{-- MENU KHUSUS KABAG --}}
<div class="sidebar-section-title mt-3">Menu Kabag</div>

<a class="nav-link d-flex justify-content-between align-items-center
    {{ request()->routeIs('kabag.acc.*') ? 'active' : '' }}"
   href="{{ route('kabag.acc.index') }}">
    <span>
        <i class="fas fa-file-signature"></i> Verifikasi Surat
    </span>
    @php
        $pendingCount = \App\Models\VehicleMaintenance::whereNotNull('file_nota')
            ->where(function($q) {
                $q->whereNull('status_surat')->orWhere('status_surat', 'pending');
            })->count();
    @endphp
    @if($pendingCount > 0)
        <span class="badge bg-warning text-dark">{{ $pendingCount }}</span>
    @endif
</a>

<a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"
   href="{{ route('reports.index') }}">
    <i class="fas fa-file-lines"></i> Laporan
</a>

<a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}"
   href="{{ route('settings.index') }}">
    <i class="fas fa-gear"></i> Pengaturan
</a>

<a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
   href="{{ route('profile.index') }}">
    <i class="fas fa-user-circle"></i> Profil
</a>