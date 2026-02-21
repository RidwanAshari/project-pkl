@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h4 class="mb-3">Buat DPB</h4>

    <div class="card">
        <div class="card-body">
            <div class="mb-2">
                <b>Aset:</b> {{ $maintenance->asset->nama_aset }}
            </div>

            <form method="POST" action="{{ route('finance.dpb.store', $maintenance->id) }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Dicetak di</label>
                        <input type="text" name="dicetak_di" class="form-control" placeholder="contoh: Kantor A">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" placeholder="opsional">
                    </div>
                </div>

                <hr>
                <h6>Item Nota</h6>

                <div id="items">
                    <div class="row g-2 mb-2 item-row">
                        <div class="col-md-8">
                            <input type="text" name="items[0][nama]" class="form-control" placeholder="Nama item" required>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="items[0][harga]" class="form-control" placeholder="Harga" required>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-secondary btn-sm" onclick="addItem()">+ Tambah Item</button>

                <div class="mt-3">
                    <button class="btn btn-primary">Simpan DPB</button>
                    <a href="{{ route('finance.dpb.inbox') }}" class="btn btn-light">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let idx = 1;

function addItem() {
    const wrap = document.getElementById('items');
    wrap.insertAdjacentHTML('beforeend', `
        <div class="row g-2 mb-2 item-row">
            <div class="col-md-8">
                <input type="text" name="items[${idx}][nama]" class="form-control" placeholder="Nama item" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="items[${idx}][harga]" class="form-control" placeholder="Harga" required>
            </div>
            <div class="col-md-1 d-grid">
                <button type="button" class="btn btn-danger" onclick="this.closest('.item-row').remove()">x</button>
            </div>
        </div>
    `);
    idx++;
}
</script>
@endsection