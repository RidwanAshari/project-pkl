{{-- KABAG SIDEBAR --}}

<a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
   href="{{ route('dashboard') }}">
    <i class="fas fa-gauge"></i> Dashboard
</a>


<a class="nav-link d-flex justify-content-between align-items-center
    {{ request()->routeIs('kabag.acc.index') ? 'active' : '' }}"
   href="{{ route('kabag.acc.index') }}">

    <span>
        <i class="fas fa-file-signature"></i> Verifikasi Surat
    </span>

    @if(($pendingSuratCount ?? 0) > 0)
        <span class="badge text-bg-warning">
            {{ $pendingSuratCount }}
        </span>
    @endif
</a>

<a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"
   href="{{ route('reports.index') }}">
    <i class="fas fa-file-lines"></i> Laporan
</a>

<a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
   href="{{ route('profile.index') }}">
    <i class="fas fa-user-circle"></i> Profil
</a>
