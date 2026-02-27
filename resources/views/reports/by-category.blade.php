@extends('layouts.app')

@section('title', 'Laporan Per Kategori')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Aset Per Kategori</h1>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        @foreach($data as $item)
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">{{ $item->kategori }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 text-center border-end">
                            <h3 class="text-primary">{{ $item->jumlah }}</h3>
                            <p class="text-muted mb-0">Jumlah Aset</p>
                        </div>
                        <div class="col-6 text-center">
                            <h3 class="text-success">Rp {{ number_format($item->total_nilai, 0, ',', '.') }}</h3>
                            <p class="text-muted mb-0">Total Nilai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Detail Tabel -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Aset Per Kategori</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Kategori</th>
                            <th>Jumlah Aset</th>
                            <th>Total Nilai</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalAset = $data->sum('jumlah'); @endphp
                        @foreach($data as $item)
                        <tr>
                            <td><strong>{{ $item->kategori }}</strong></td>
                            <td>{{ $item->jumlah }} unit</td>
                            <td>Rp {{ number_format($item->total_nilai, 0, ',', '.') }}</td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" role="progressbar" 
                                         style="width: {{ ($item->jumlah / $totalAset) * 100 }}%">
                                        {{ number_format(($item->jumlah / $totalAset) * 100, 1) }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="table-secondary">
                            <td><strong>TOTAL</strong></td>
                            <td><strong>{{ $data->sum('jumlah') }} unit</strong></td>
                            <td><strong>Rp {{ number_format($data->sum('total_nilai'), 0, ',', '.') }}</strong></td>
                            <td><strong>100%</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection