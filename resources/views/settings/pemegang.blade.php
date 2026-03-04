@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Pengguna & Role</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus"></i> Tambah Pengguna
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Info Role --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body py-3">
                    <div class="d-flex flex-wrap gap-3 align-items-center">
                        <span class="fw-semibold text-muted small"><i class="fas fa-info-circle me-1"></i> Keterangan Role:</span>
                        <span><span class="badge bg-danger me-1">Admin</span> <small class="text-muted">Akses penuh semua fitur</small></span>
                        <span><span class="badge bg-warning text-dark me-1">Kabag</span> <small class="text-muted">Seperti admin + verifikasi surat</small></span>
                        <span><span class="badge bg-info me-1">Finance</span> <small class="text-muted">Hanya dashboard DPB</small></span>
                        <span><span class="badge bg-success me-1">Umum</span> <small class="text-muted">Ka.Sub.bag. Umum — Verifikasi DPB</small></span>
                        <span><span class="badge bg-secondary me-1">Staff</span> <small class="text-muted">Tambah & lihat aset</small></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Nama</th>
                            <th>Email</th>
                            <th>Jabatan</th>
                            <th>Departemen</th>
                            <th>No. Telepon</th>
                            <th>Role Sistem</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="ps-3">
                                <strong>{{ $user->name }}</strong>
                                @if($user->id === auth()->id())
                                    <span class="badge bg-primary ms-1" style="font-size:0.6rem;">Anda</span>
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->position ?? '-' }}</td>
                            <td>{{ $user->department ? ucfirst($user->department) : '-' }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>
                                @php
                                    $role = $user->role ?? 'staff';
                                    $badgeColor = match($role) {
                                        'admin'   => 'danger',
                                        'kabag'   => 'warning',
                                        'finance' => 'info',
                                        'umum'    => 'success',
                                        default   => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeColor }} text-{{ $role === 'kabag' ? 'dark' : 'white' }}">
                                    {{ ucfirst($role) }}
                                </span>
                            </td>
                            <td class="text-center">
                                {{-- Tombol Edit Info --}}
                                <button class="btn btn-sm btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-position="{{ $user->position }}"
                                    data-department="{{ $user->department }}"
                                    data-phone="{{ $user->phone }}"
                                    title="Edit Info">
                                    <i class="fas fa-edit"></i>
                                </button>

                                {{-- Tombol Ubah Role (tidak untuk diri sendiri) --}}
                                @if($user->id !== auth()->id())
                                <button class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalRole"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-role="{{ $user->role ?? 'staff' }}"
                                    title="Ubah Role">
                                    <i class="fas fa-user-shield"></i>
                                </button>

                                <form action="{{ route('settings.pemegang.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengguna {{ $user->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="fas fa-users fa-3x mb-3 d-block"></i>
                                Belum ada pengguna
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Pengguna --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('settings.pemegang.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role Sistem <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" required>
                            <option value="staff">Staff — Tambah & lihat aset</option>
                            <option value="kabag">Kabag — Admin + verifikasi surat</option>
                            <option value="finance">Finance — Dashboard DPB saja</option>
                            <option value="admin">Admin — Akses penuh</option>
                        </select>
                        <small class="text-muted">Tentukan hak akses pengguna di sistem</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jabatan</label>
                        <select name="position" class="form-select">
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="Direktur Utama">Direktur Utama</option>
                            <option value="Direktur">Direktur</option>
                            <option value="Ka Sub Bag Umum & PDE">Ka Sub Bag Umum & PDE</option>
                            <option value="Ka Sub Bag Keuangan">Ka Sub Bag Keuangan</option>
                            <option value="Ka Sub Bag SDM">Ka Sub Bag SDM</option>
                            <option value="Ka Sub Unit Banjarnegoro">Ka Sub Unit Banjarnegoro</option>
                            <option value="Ka Sub Unit Mertoyudan">Ka Sub Unit Mertoyudan</option>
                            <option value="Ka Sub Unit Muntilan">Ka Sub Unit Muntilan</option>
                            <option value="Ka Sub Unit Grabag">Ka Sub Unit Grabag</option>
                            <option value="Plt. Ka Sub Unit Banjarnegoro">Plt. Ka Sub Unit Banjarnegoro</option>
                            <option value="Plt. Ka Sub Unit Mertoyudan">Plt. Ka Sub Unit Mertoyudan</option>
                            <option value="Staf Umum">Staf Umum</option>
                            <option value="Staf Keuangan">Staf Keuangan</option>
                            <option value="Staf Teknik">Staf Teknik</option>
                            <option value="Bagian Pengadaan">Bagian Pengadaan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Departemen</label>
                        <select name="department" class="form-select">
                            <option value="">-- Pilih Departemen --</option>
                            <option value="it">IT & Teknologi</option>
                            <option value="finance">Keuangan</option>
                            <option value="operations">Operasional</option>
                            <option value="maintenance">Pemeliharaan</option>
                            <option value="admin">Administrasi</option>
                            <option value="hr">SDM</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. Telepon</label>
                        <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required minlength="8">
                        <small class="text-muted">Minimal 8 karakter</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Info --}}
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEdit" method="POST">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Info Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="name" id="edit-name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jabatan</label>
                        <select name="position" id="edit-position" class="form-select">
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="Direktur Utama">Direktur Utama</option>
                            <option value="Direktur">Direktur</option>
                            <option value="Ka Sub Bag Umum & PDE">Ka Sub Bag Umum & PDE</option>
                            <option value="Ka Sub Bag Keuangan">Ka Sub Bag Keuangan</option>
                            <option value="Ka Sub Bag SDM">Ka Sub Bag SDM</option>
                            <option value="Ka Sub Unit Banjarnegoro">Ka Sub Unit Banjarnegoro</option>
                            <option value="Ka Sub Unit Mertoyudan">Ka Sub Unit Mertoyudan</option>
                            <option value="Ka Sub Unit Muntilan">Ka Sub Unit Muntilan</option>
                            <option value="Ka Sub Unit Grabag">Ka Sub Unit Grabag</option>
                            <option value="Plt. Ka Sub Unit Banjarnegoro">Plt. Ka Sub Unit Banjarnegoro</option>
                            <option value="Plt. Ka Sub Unit Mertoyudan">Plt. Ka Sub Unit Mertoyudan</option>
                            <option value="Staf Umum">Staf Umum</option>
                            <option value="Staf Keuangan">Staf Keuangan</option>
                            <option value="Staf Teknik">Staf Teknik</option>
                            <option value="Bagian Pengadaan">Bagian Pengadaan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Departemen</label>
                        <select name="department" id="edit-department" class="form-select">
                            <option value="">-- Pilih Departemen --</option>
                            <option value="it">IT & Teknologi</option>
                            <option value="finance">Keuangan</option>
                            <option value="operations">Operasional</option>
                            <option value="maintenance">Pemeliharaan</option>
                            <option value="admin">Administrasi</option>
                            <option value="hr">SDM</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. Telepon</label>
                        <input type="text" name="phone" id="edit-phone" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Ubah Role --}}
<div class="modal fade" id="modalRole" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form id="formRole" method="POST">
                @csrf @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-user-shield me-2"></i>Ubah Role</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small mb-3">Mengubah role untuk: <strong id="role-username"></strong></p>
                    <div class="mb-0">
                        <label class="form-label fw-semibold">Role Sistem <span class="text-danger">*</span></label>
                        <select name="role" id="role-select" class="form-select" required>
                            <option value="staff">🔵 Staff — Tambah & lihat aset</option>
                            <option value="kabag">🟡 Kabag — Admin + verifikasi surat</option>
                            <option value="umum">🟢 Umum — Ka.Sub.bag. Verifikasi DPB</option>
                            <option value="finance">🔷 Finance — Dashboard DPB saja</option>
                            <option value="admin">🔴 Admin — Akses penuh</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save me-1"></i>Simpan Role</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Modal Edit Info
document.getElementById('modalEdit').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('edit-name').value       = btn.getAttribute('data-name');
    document.getElementById('edit-position').value   = btn.getAttribute('data-position');
    document.getElementById('edit-department').value = btn.getAttribute('data-department');
    document.getElementById('edit-phone').value      = btn.getAttribute('data-phone');
    document.getElementById('formEdit').action       = '/settings/pemegang/' + btn.getAttribute('data-id');
});

// Modal Ubah Role
document.getElementById('modalRole').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('role-username').textContent = btn.getAttribute('data-name');
    document.getElementById('role-select').value         = btn.getAttribute('data-role');
    document.getElementById('formRole').action           = '/settings/pemegang/' + btn.getAttribute('data-id') + '/role';
});
</script>
@endpush
@endsection