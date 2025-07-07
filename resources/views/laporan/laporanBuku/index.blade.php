@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Laporan Buku</h4>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.laporanBuku.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control"
                                value="{{ request('start_date', optional($start)->format('Y-m-d')) }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end_date">Tanggal Akhir</label>
                            <input type="date" name="end_date" class="form-control"
                                value="{{ request('end_date', optional($end)->format('Y-m-d')) }}" />
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary me-2">Filter</button>
                            <a href="{{ route('laporan.laporanBuku.cetak', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
                               class="btn btn-secondary" target="_blank">Cetak PDF</a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Buku</th>
                            <th>Judul</th>
                            <th>Pengarang</th>
                            <th>Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th>No UDC</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($buku as $item)
                        <tr>
                            <td>{{ $item->KodeBuku }}</td>
                            <td>{{ $item->Judul }}</td>
                            <td>{{ $item->Pengarang }}</td>
                            <td>{{ $item->Penerbit }}</td>
                            <td>{{ $item->TahunTerbit }}</td>
                            <td>{{ $item->NoUDC }}</td>
                            <td>{{ $item->Stok }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end mt-3">
    {{ $buku->appends(request()->query())->links() }}
</div>
            </div>
        </div>
    </div>
</div>
@endsection
