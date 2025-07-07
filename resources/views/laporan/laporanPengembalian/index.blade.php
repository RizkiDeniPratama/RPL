@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Laporan Buku</h4>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.laporanPengembalian.index') }}" class="mb-4">
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
                            <a href="{{ route('laporan.laporanPengembalian.cetak', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
                               class="btn btn-secondary" target="_blank">Cetak PDF</a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                             <th>No</th>
                            <th>Nama Peminjam</th>
                            <th>Jenis</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Petugas</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                       @php $no = 1; @endphp

                        @foreach ($kembaliSiswa as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->peminjaman->anggota->NamaAnggota ?? '-' }}</td>
                                <td>Siswa</td>
                                <td>{{ $item->peminjaman->detailPeminjaman->first()->buku->Judul ?? '-' }}</td>
                                <td>{{ $item->peminjaman->TglPinjam ?? '-' }}</td>
                                <td>{{ $item->TglKembali }}</td>
                                <td>{{ $item->petugas->Nama ?? '-' }}</td>
                                <td>Rp {{ number_format($item->Denda, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach

                        @foreach ($kembaliNonSiswa as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->peminjaman->anggota->NamaAnggota ?? '-' }}</td>
                                <td>Non Siswa</td>
                                <td>{{ $item->peminjaman->detailPeminjaman->first()->buku->Judul ?? '-' }}</td>
                                <td>{{ $item->peminjaman->TglPinjam ?? '-' }}</td>
                                <td>{{ $item->TglKembali }}</td>
                                <td>{{ $item->petugas->Nama ?? '-' }}</td>
                                <td>Rp {{ number_format($item->Denda, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <div class="d-flex justify-content-end mt-3">
    {{ $buku->appends(request()->query())->links() }}
</div> --}}
            </div>
        </div>
    </div>
</div>
@endsection
