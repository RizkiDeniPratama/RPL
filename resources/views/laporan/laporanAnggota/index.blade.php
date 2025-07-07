@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Laporan Anggota Perpustakaan</h4>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.laporanAnggota.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control"
                                value="{{ request('start_date', optional($startDate)->format('Y-m-d')) }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end_date">Tanggal Akhir</label>
                            <input type="date" name="end_date" class="form-control"
                                value="{{ request('end_date', optional($endDate)->format('Y-m-d')) }}" />
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary me-2">Filter</button>
                            <a href="{{ route('laporan.laporanAnggota.cetak', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
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
                            <th>Jenis</th>
                <th>No Anggota</th>
                <th>Nama</th>
                <th>NIS / NIP</th>
                <th>Kelas / Pekerjaan</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>No Telp</th>
                <th>Nama Ortu</th>
                <th>No Telp Ortu</th>
                        </tr>
                    </thead>
                    <tbody>
                         @php $no = 1; @endphp

            {{-- Anggota Siswa --}}
            @foreach ($anggotaSiswa as $a)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>Siswa</td>
                    <td>{{ $a->NoAnggotaM }}</td>
                    <td>{{ $a->NamaAnggota }}</td>
                    <td>{{ $a->NIS }}</td>
                    <td>{{ $a->Kelas }}</td>
                    <td>{{ $a->JenisKelamin }}</td>
                    <td>{{ $a->TanggalLahir->format('d-m-Y') }}</td>
                    <td>{{ $a->Alamat }}</td>
                    <td>{{ $a->NoTelp }}</td>
                    <td>{{ $a->NamaOrtu }}</td>
                    <td>{{ $a->NoTelpOrtu }}</td>
                </tr>
            @endforeach

            {{-- Anggota Non Siswa --}}
            @foreach ($anggotaNonSiswa as $a)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>Non Siswa</td>
                    <td>{{ $a->NoAnggotaN }}</td>
                    <td>{{ $a->NamaAnggota }}</td>
                    <td>{{ $a->NIP }}</td>
                    <td>{{ $a->Pekerjaan }}</td>
                    <td>{{ $a->JenisKelamin }}</td>
                    <td>{{ $a->TanggalLahir->format('d-m-Y') }}</td>
                    <td>{{ $a->Alamat }}</td>
                    <td>{{ $a->NoTelp }}</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
            @endforeach

            @if($anggotaSiswa->isEmpty() && $anggotaNonSiswa->isEmpty())
                <tr>
                    <td colspan="12" style="text-align: center;">Tidak ada data anggota dalam rentang tanggal ini.</td>
                </tr>
            @endif
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
