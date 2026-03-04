@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profil Saya</h1>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Sidebar Profil -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow text-center">
                <div class="card-body py-4">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle mb-3" style="width:100px;height:100px;object-fit:cover;">
                    @else
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:100px;height:100px;">
                            <i class="fas fa-user fa-3x text-white"></i>
                        </div>
                    @endif
                    <h5 class="fw-bold mb-1">{{ $profile['name'] }}</h5>
                    <span class="badge bg-primary mb-2">{{ $profile['role'] }}</span>
                    <div class="text-muted small">
                        <i class="fas fa-envelope me-1"></i> {{ $profile['email'] }}<br>
                        <i class="fas fa-calendar me-1"></i> Bergabung {{ \Carbon\Carbon::parse($profile['joined'])->format('d M Y') }}
                    </div>
                </div>
            </div>

            <!-- Statistik ringkas -->
            <div class="card shadow mt-3">
                <div class="card-header py-2">
                    <h6 class="mb-0 text-primary fw-bold">Statistik Aktivitas</h6>
                </div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between">
                        <span class="text-muted small">Total Aset</span>
                        <strong class="text-primary">{{ \App\Models\Asset::count() }}</strong>
                    </div>
                    <div class="list-group-item d-flex justify-content-between">
                        <span class="text-muted small">Total Transfer</span>
                        <strong class="text-success">{{ \App\Models\AssetHistory::count() }}</strong>
                    </div>
                    <div class="list-group-item d-flex justify-content-between">
                        <span class="text-muted small">Aset Bermasalah</span>
                        <strong class="text-warning">{{ \App\Models\Asset::whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat'])->count() }}</strong>
                    </div>
                    <div class="list-group-item d-flex justify-content-between">
                        <span class="text-muted small">Total Nilai Aset</span>
                        <strong class="text-info small">Rp {{ number_format(\App\Models\Asset::sum('nilai_perolehan'), 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Konten Utama -->
        <div class="col-lg-9">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab-profil">
                        <i class="fas fa-user-edit"></i> Edit Profil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-password">
                        <i class="fas fa-lock"></i> Ubah Password
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Edit Profil -->
                <div id="tab-profil" class="tab-pane fade show active">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Profil</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name', $profile['name']) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email', $profile['email']) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Nomor HP</label>
                                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $profile['phone']) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Jabatan</label>
                                        <input type="text" name="position" class="form-control" value="{{ old('position', $profile['position']) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Departemen</label>
                                        <input type="text" name="department" class="form-control" value="{{ old('department', $profile['department']) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Foto Profil</label>
                                        <input type="file" name="avatar" class="form-control" accept="image/*">
                                        <small class="text-muted">Format: JPG/PNG. Maks 2MB</small>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Ubah Password -->
                <div id="tab-password" class="tab-pane fade">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Ubah Password</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.update-password') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Password Saat Ini <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" name="current_password" class="form-control" id="currentPass" required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePass('currentPass')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Password Baru <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control" id="newPass" required minlength="8">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePass('newPass')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">Minimal 8 karakter</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" class="form-control" id="confirmPass" required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePass('confirmPass')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-key"></i> Ubah Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePass(id) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
@endpush
@endsection
