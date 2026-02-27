@extends('layouts.app')

@section('content')
<div class="container">

<h4>Proses Nota</h4>

<form method="POST" action="{{ route('vehicles.process_nota', $maintenance->id) }}">
@csrf

<div class="mb-3">
    <label>Nama Item</label>
    <input type="text" name="items[0][nama]" class="form-control" required>
</div>

<div class="mb-3">
    <label>Harga</label>
    <input type="number" name="items[0][harga]" class="form-control" required>
</div>

<button class="btn btn-primary">Simpan DPB</button>

</form>

</div>
@endsection