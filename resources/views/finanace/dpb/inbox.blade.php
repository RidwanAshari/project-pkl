@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h4 class="mb-3">Inbox Nota (Finance)</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Aset</th>
                <th>Tanggal</th>
                <th>Nota</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($maintenances as $m)
            <tr>
                <td>{{ $m->asset->nama_aset }}</td>
                <td>{{ optional($m->tanggal)->format('d-m-Y') }}</td>
                <td>
                    @if($m->file_nota)
                        <span class="badge bg-success">Ada</span>
                    @else
                        <span class="badge bg-secondary">Tidak ada</span>
                    @endif
                </td>
                <td>
                    <a class="btn btn-sm btn-primary"
                       href="{{ route('finance.dpb.create', $m->id) }}">
                        Buat DPB
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $maintenances->links() }}
</div>
@endsection