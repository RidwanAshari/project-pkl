@extends('layouts.app')

@section('content')
@php
$data = json_decode($dpb->nota, true) ?? [];
$items = $data['items'] ?? [];
$total = 0;
@endphp

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>DPB</h4>
        <button class="btn btn-success" onclick="window.print()">Cetak</button>
    </div>

    <div class="mb-2"><b>Aset:</b> {{ $dpb->asset->nama_aset ?? '-' }}</div>
    <div class="mb-2"><b>Dicetak di:</b> {{ $data['dicetak_di'] ?? '-' }}</div>
    <div class="mb-3"><b>Keterangan:</b> {{ $data['keterangan'] ?? '-' }}</div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th style="width:200px">Harga</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $it)
            @php $total += (float)($it['harga'] ?? 0); @endphp
            <tr>
                <td>{{ $it['nama'] ?? '-' }}</td>
                <td>{{ number_format((float)($it['harga'] ?? 0), 0, ',', '.') }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th>{{ number_format($total, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection