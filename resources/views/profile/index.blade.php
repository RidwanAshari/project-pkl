@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-header', 'Profil Saya')

@section('page-actions')
    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
        <i class="fas fa-edit me-2"></i> Edit Profil
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Informasi Profil
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="text-center mb-4">
                                    <div class="user-avatar mx-auto" style="width: 120px; height: 120px; font-size: 48px;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <h5 class="mt-3">{{ Auth::user()->name }}</h5>
                                    <span class="badge bg-primary">{{ Auth::user()->role ?? 'User' }}</span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="200">Nama Lengkap</th>
                                        <td>{{ Auth::user()->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ Auth::user()->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Role</th>
                                        <td><span class="badge bg-primary">{{ Auth::user()->role ?? 'User' }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Bergabung Sejak</th>
                                        <td>{{ Auth::user()->created_at->format('d F Y') }}</td>
                                    </tr>
                                    @if(Auth::user()->phone)
                                    <tr>
                                        <th>Telepon</th>
                                        <td>{{ Auth::user()->phone }}</td>
                                    </tr>
                                    @endif
                                    @if(Auth::user()->address)
                                    <tr>
                                        <th>Alamat</th>
                                        <td>{{ Auth::user()->address }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-left-info shadow h-100 py-2 mb-4">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Aksi Cepat
                        </div>
                        <div class="mt-3 d-grid gap-2">
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                <i class="fas fa-edit me-2"></i> Edit Profil
                            </a>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="fas fa-key me-2"></i> Ganti Password
                            </button>
                            <a href="{{ route('logout') }}" class="btn btn-outline-danger"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Keluar
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Statistik
                        </div>
                        <div class="mt-3">
                            <p class="mb-2"><i class="fas fa-calendar-check text-primary me-2"></i> Login terakhir: {{ now()->format('d M Y H:i') }}</p>
                            <p class="mb-0"><i class="fas fa-user-clock text-info me-2"></i> Member sejak: {{ Auth::user()->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ganti Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Ganti Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
<form action="{{ route('profile.password.update') }}" method="POST">
    @csrf
    @method('PUT') {{-- TAMBAHKAN INI KARENA ROUTE MENGGUNAKAN METHOD PUT --}}
            @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto show modal if there are password errors
    @if($errors->has('current_password') || $errors->has('password'))
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
            modal.show();
        });
    @endif
</script>
@endpush