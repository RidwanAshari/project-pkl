{{-- FINANCE SIDEBAR --}}

<a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
   href="{{ route('dashboard') }}">
    <i class="fas fa-gauge"></i> Dashboard
</a>

<div class="sidebar-heading mt-3">
    Keuangan
</div>
<a class="nav-link {{ request()->routeIs('finance.dpb.*') ? 'active' : '' }}"
   href="{{ route('finance.dpb.inbox') }}">
    <i class="fas fa-inbox"></i> Inbox Nota / DPB
</a>

<a class="nav-link {{ request()->routeIs('finance.laporan.*') ? 'active' : '' }}"
   href="{{ route('finance.laporan.index') }}">
    <i class="fas fa-chart-line"></i> Laporan Keuangan
</a>

{{-- Menambahkan menu untuk proses nota --}}
<a class="nav-link {{ request()->routeIs('vehicles.process_nota') ? 'active' : '' }}"
   href="{{ route('vehicles.process_nota', ['maintenance' => 1]) }}">
    <i class="fas fa-check-circle"></i> Proses Nota
</a>

{{-- Menambahkan menu untuk cetak DPB --}}
<a class="nav-link {{ request()->routeIs('vehicles.printDpb') ? 'active' : '' }}"
   href="{{ route('vehicles.printDpb', ['maintenance' => 1]) }}">
    <i class="fas fa-print"></i> Cetak DPB
</a>

<a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
   href="{{ route('profile.index') }}">
    <i class="fas fa-user-circle"></i> Profil
</a>