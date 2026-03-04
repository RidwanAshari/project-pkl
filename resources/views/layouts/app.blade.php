<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manajemen Aset Kantor')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { min-height: 100vh; background: linear-gradient(180deg, #4e73df 0%, #224abe 100%); box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); }
        .sidebar .nav-link { color: rgba(255, 255, 255, 0.8); padding: 0.75rem 1rem; transition: all 0.3s; border-radius: 0.25rem; margin: 0.1rem 0.5rem; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background-color: rgba(255, 255, 255, 0.15); }
        .sidebar .nav-link i { margin-right: 0.5rem; width: 1.2rem; text-align: center; }
        .sidebar .nav-section { color: rgba(255,255,255,0.4); font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.08em; padding: 0.5rem 1.5rem; margin-top: 0.5rem; }
        .card { border: none; border-radius: 0.5rem; }
        .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
        .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
        .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
        .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
        .border-left-danger { border-left: 0.25rem solid #e74a3b !important; }
        .text-xs { font-size: 0.7rem; }
        .topbar { height: 4.375rem; background-color: #fff; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); }
        .brand-logo { font-size: 1.3rem; font-weight: 700; color: #fff; padding: 1.2rem 1rem; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .brand-logo:hover { color: #fff; }
        .role-badge { display: inline-block; background: rgba(255,255,255,0.2); color: #fff; font-size: 0.65rem; padding: 0.15rem 0.5rem; border-radius: 1rem; margin-left: auto; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            @php $role = auth()->user()->role ?? 'staff'; @endphp
            <div class="col-md-2 px-0 sidebar">
                <a href="{{ route('dashboard') }}" class="brand-logo">
                    <i class="fas fa-building"></i>
                    <span>Asset Manager</span>
                </a>
                <nav class="nav flex-column mt-2 pb-4">
                    @php
                        $activeMenu = null;
                        if (request()->routeIs('assets.trash')) {
                            $activeMenu = 'trash'; // khusus trash, tidak overlap dengan aset
                        } elseif (request()->routeIs('assets.show') || request()->routeIs('vehicles.show') || request()->routeIs('asset-details.show')) {
                            $currentAsset = isset($asset) ? $asset : null;
                            if ($currentAsset) {
                                $activeMenu = $currentAsset->tipe_dashboard === 'biaya' ? 'biaya' : ($currentAsset->tipe_dashboard === 'pinjaman' ? 'pinjaman' : 'aset');
                            }
                        } elseif (request()->routeIs('assets-biaya.*')) { $activeMenu = 'biaya'; }
                        elseif (request()->routeIs('assets-pinjaman.*')) { $activeMenu = 'pinjaman'; }
                        elseif (request()->routeIs('assets.*')) { $activeMenu = 'aset'; }
                    @endphp

                    <div class="nav-section">Menu Utama</div>
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-gauge"></i> Dashboard
                    </a>

                    @if(in_array($role, ['admin', 'staff', 'kabag']))
                    <a class="nav-link {{ $activeMenu === 'aset' ? 'active' : '' }}" href="{{ route('assets.index') }}">
                        <i class="fas fa-boxes"></i> Data Aset
                    </a>
                    <a class="nav-link {{ $activeMenu === 'biaya' ? 'active' : '' }}" href="{{ route('assets-biaya.index') }}">
                        <i class="fas fa-money-bill-wave"></i> Data Aset Biaya
                    </a>
                    <a class="nav-link {{ $activeMenu === 'pinjaman' ? 'active' : '' }}" href="{{ route('assets-pinjaman.index') }}">
                        <i class="fas fa-handshake"></i> Data Aset Pinjaman
                    </a>
                    <a class="nav-link {{ $activeMenu === 'trash' ? 'active' : '' }}" href="{{ route('assets.trash') }}">
                        <i class="fas fa-trash-restore"></i> Aset Dihapus
                    </a>
                    
                    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                        <i class="fas fa-file-lines"></i> Laporan
                    </a>
                    @endif

                    @if($role === 'kabag')
                    <div class="nav-section">Kabag</div>
                    <a class="nav-link {{ request()->routeIs('kabag.*') ? 'active' : '' }}" href="{{ route('kabag.index') }}">
                        <i class="fas fa-stamp"></i> Verifikasi Surat
                        @php $pending = \App\Models\VehicleMaintenance::where('status_surat','menunggu_acc')->count(); @endphp
                        @if($pending > 0)
                            <span class="badge bg-warning text-dark ms-1">{{ $pending }}</span>
                        @endif
                    </a>
                    @endif

                    @if($role === 'finance')
                    <div class="nav-section">Finance</div>
                    <a class="nav-link {{ request()->routeIs('finance.*') ? 'active' : '' }}" href="{{ route('finance.index') }}">
                        <i class="fas fa-file-invoice-dollar"></i> Surat DPB
                        @php $readyDpb = \App\Models\VehicleMaintenance::where('terkirim_ke_finance',true)->whereDoesntHave('dpbDocument')->count(); @endphp
                        @if($readyDpb > 0)
                            <span class="badge bg-danger ms-1">{{ $readyDpb }}</span>
                        @endif
                    </a>
                    @endif

                    @if($role === 'admin')
                    <div class="nav-section">Administrasi</div>
                    <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                        <i class="fas fa-gear"></i> Pengaturan
                    </a>
                    @endif

                    <div class="nav-section">Akun</div>
                    <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.index') }}">
                        <i class="fas fa-user-circle"></i> Profil Saya
                    </a>
                </nav>
            </div>

            <div class="col-md-10 px-0">
                <nav class="topbar d-flex align-items-center justify-content-between px-4">
                    <h5 class="mb-0 text-muted">Sistem Manajemen Aset Kantor</h5>
                    <div class="d-flex align-items-center gap-3">

                        {{-- NOTIFIKASI STNK --}}
                        @php
                            $stnkCount = \App\Models\VehicleDetail::with('asset')
                                ->whereNotNull('tanggal_berlaku')
                                ->whereHas('asset', fn($q) => $q->where('kategori', 'Kendaraan'))
                                ->get()
                                ->filter(function($v) {
                                    $sisa = \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::parse($v->tanggal_berlaku), false);
                                    return $sisa <= session('stnk_threshold', 30);
                                });
                        @endphp
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm position-relative" id="notifDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false" style="border-radius:50%;width:38px;height:38px;padding:0;">
                                <i class="fas fa-bell" style="font-size:15px;color:#4e73df;"></i>
                                @if($stnkCount->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                    style="font-size:0.6rem;">
                                    {{ $stnkCount->count() }}
                                </span>
                                @endif
                            </button>
                            <div class="dropdown-menu dropdown-menu-end shadow" style="width:340px;max-height:420px;overflow-y:auto;" aria-labelledby="notifDropdown">
                                <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
                                    <span class="fw-bold" style="font-size:13px;"><i class="fas fa-bell text-primary me-1"></i> Notifikasi STNK</span>
                                    @if($stnkCount->count() > 0)
                                    <span class="badge bg-danger">{{ $stnkCount->count() }}</span>
                                    @endif
                                </div>
                                @forelse($stnkCount as $v)
                                @php
                                    $sisa = \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::parse($v->tanggal_berlaku), false);
                                    $tgl  = \Carbon\Carbon::parse($v->tanggal_berlaku)->format('d/m/Y');
                                @endphp
                                <a href="{{ $v->asset ? route('vehicles.show', $v->asset) : '#' }}"
                                   class="dropdown-item py-2 px-3 border-bottom {{ $sisa < 0 ? 'bg-danger bg-opacity-10' : ($sisa <= 7 ? 'bg-warning bg-opacity-10' : '') }}">
                                    <div class="d-flex align-items-start gap-2">
                                        <span style="font-size:18px;margin-top:1px;">
                                            {{ $sisa < 0 ? '🚨' : ($sisa <= 7 ? '⚠️' : '🔔') }}
                                        </span>
                                        <div>
                                            <div class="fw-semibold" style="font-size:12.5px;">{{ $v->asset->nama_aset ?? '-' }}</div>
                                            <div style="font-size:11px;color:#555;">
                                                <span class="badge bg-dark" style="font-size:10px;">{{ $v->nomor_plat }}</span>
                                                &nbsp;
                                                @if($sisa < 0)
                                                    <span class="text-danger fw-bold">Expired {{ abs($sisa) }} hari lalu</span>
                                                @elseif($sisa <= 7)
                                                    <span class="text-warning fw-bold">{{ $sisa }} hari lagi!</span>
                                                @else
                                                    <span class="text-muted">{{ $sisa }} hari lagi</span>
                                                @endif
                                            </div>
                                            <div style="font-size:10.5px;color:#888;">Berlaku s/d {{ $tgl }}</div>
                                        </div>
                                    </div>
                                </a>
                                @empty
                                <div class="px-3 py-4 text-center text-muted" style="font-size:13px;">
                                    <i class="fas fa-check-circle text-success d-block mb-1" style="font-size:22px;"></i>
                                    Semua STNK masih berlaku
                                </div>
                                @endforelse
                                <a href="{{ route('dashboard') }}" class="dropdown-item text-center py-2" style="font-size:12px;color:#4e73df;">
                                    Lihat semua di Dashboard →
                                </a>
                            </div>
                        </div>

                        <div class="text-end">
                            <div class="fw-semibold small">{{ auth()->user()->name }}</div>
                            <span class="badge bg-primary" style="font-size:0.65rem;">{{ ucfirst($role) }}</span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-power-off"></i> Logout
                            </button>
                        </form>
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