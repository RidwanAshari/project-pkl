@extends('layouts.app')

@section('title', 'Laporan Per Kondisi')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Aset Per Kondisi</h1>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        @foreach($data as $item)
        <div class="col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 
                    @if($item->kondisi == 'Baik') bg-success 
                    @elseif($item->kondisi == 'Rusak Ringan') bg-warning 
                    @else bg-danger 
                    @endif text-white">
                    <h6 class="m-0 font-weight-bold">{{ $item->kondisi }}</h6>
                </div>
                <div class="card-body text-center">
                    <h2 class="
                        @if($item->kondisi == 'Baik') text-success 
                        @elseif($item->kondisi == 'Rusak Ringan') text-warning 
                        @else text-danger 
                        @endif">
                        {{ $item->jumlah }}
                    </h2>
                    <p class="text-muted">Unit Aset</p>
                    <hr>
                    <h4 class="text-success">Rp {{ number_format($item->total_nilai, 0, ',', '.') }}</h4>
                    <p class="text-muted mb-0">Total Nilai</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Detail Tabel -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Aset Per Kondisi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Kondisi</th>
                            <th>Jumlah Aset</th>
                            <th>Total Nilai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>
                                <span class="badge 
                                    @if($item->kondisi == 'Baik') bg-success 
                                    @elseif($item->kondisi == 'Rusak Ringan') bg-warning 
                                    @else bg-danger 
                                    @endif">
                                    {{ $item->kondisi }}
                                </span>
                            </td>
                            <td>{{ $item->jumlah }} unit</td>
                            <td>Rp {{ number_format($item->total_nilai, 0, ',', '.') }}</td>
                            <td>
                                @if($item->kondisi == 'Baik')
                                    <i class="fas fa-check-circle text-success"></i> Normal
                                @elseif($item->kondisi == 'Rusak Ringan')
                                    <i class="fas fa-exclamation-triangle text-warning"></i> Perlu Perhatian
                                @else
                                    <i class="fas fa-times-circle text-danger"></i> Perlu Perbaikan Urgent
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        <tr class="table-secondary">
                            <td><strong>TOTAL</strong></td>
                            <td><strong>{{ $data->sum('jumlah') }} unit</strong></td>
                            <td><strong>Rp {{ number_format($data->sum('total_nilai'), 0, ',', '.') }}</strong></td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Rekomendasi -->
    <div class="card shadow mt-4">
        <div class="card-header py-3 bg-info text-white">
            <h6 class="m-0 font-weight-bold">💡 Rekomendasi</h6>
        </div>
        <div class="card-body">
            @php
                $rusakRingan = $data->where('kondisi', 'Rusak Ringan')->first();
                $rusakBerat = $data->where('kondisi', 'Rusak Berat')->first();
            @endphp
            
            @if($rusakRingan && $rusakRingan->jumlah > 0)
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                Terdapat <strong>{{ $rusakRingan->jumlah }} aset</strong> dalam kondisi Rusak Ringan yang memerlukan perawatan.
            </div>
            @endif

            @if($rusakBerat && $rusakBerat->jumlah > 0)
            <div class="alert alert-danger">
                <i class="fas fa-times-circle"></i>
                Terdapat <strong>{{ $rusakBerat->jumlah }} aset</strong> dalam kondisi Rusak Berat yang memerlukan perbaikan segera.
            </div>
            @endif

            @if((!$rusakRingan || $rusakRingan->jumlah == 0) && (!$rusakBerat || $rusakBerat->jumlah == 0))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                Semua aset dalam kondisi baik. Lanjutkan perawatan rutin!
            </div>
            @endif
        </div>
    </div>
</div>
@endsection