@extends('layouts.app')

@section('title', 'Kelola Pemegang Aset')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Pemegang Aset</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus"></i> Tambah Pemegang
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Jabatan</th>
                        <th>Departemen</th>
                        <th>No. Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->position ? ucfirst($user->position) : '-' }}</td>
                        <td>{{ $user->department ? ucfirst($user->department) : '-' }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEdit"
                                data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}"
                                data-position="{{ $user->position }}"
                                data-department="{{ $user->department }}"
                                data-phone="{{ $user->phone }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('settings.pemegang.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pemegang ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-users fa-3x mb-3 d-block"></i>
                            Belum ada data pemegang
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('settings.pemegang.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pemegang Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <select name="position" class="form-select">
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="Direktur Utama">Direktur Utama</option>
                            <option value="Direktur">Direktur</option>
                            <option value="Ka Sub Bag Umum & PDE">Ka Sub Bag Umum &amp; PDE</option>
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
                        <label class="form-label">Departemen</label>
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
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required minlength="8">
                        <small class="text-muted">Minimal 8 karakter</small>
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

{{-- Modal Edit --}}
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEdit" method="POST">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pemegang Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" id="edit-name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <select name="position" id="edit-position" class="form-select">
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="Direktur Utama">Direktur Utama</option>
                            <option value="Direktur">Direktur</option>
                            <option value="Ka Sub Bag Umum & PDE">Ka Sub Bag Umum &amp; PDE</option>
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
                        <label class="form-label">Departemen</label>
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
                        <label class="form-label">No. Telepon</label>
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

@push('scripts')
<script>
document.getElementById('modalEdit').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('edit-name').value       = btn.getAttribute('data-name');
    document.getElementById('edit-position').value   = btn.getAttribute('data-position');
    document.getElementById('edit-department').value = btn.getAttribute('data-department');
    document.getElementById('edit-phone').value      = btn.getAttribute('data-phone');
    document.getElementById('formEdit').action       = '/settings/pemegang/' + btn.getAttribute('data-id');
});
</script>
@endpush
@endsection