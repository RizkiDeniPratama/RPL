@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Peminjaman</h5>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th width="140">No Peminjaman</th>
                                    <td>
                                        @if (isset($peminjaman))
                                            {{ $peminjaman instanceof \App\Models\PeminjamanSiswa ? $peminjaman->NoPinjamM : $peminjaman->NoPinjamN }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tipe Anggota</th>
                                    <td>
                                        @if (isset($peminjaman))
                                            {{ $peminjaman instanceof \App\Models\PeminjamanSiswa ? 'Siswa' : 'Non-Siswa' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nama Anggota</th>
                                    <td>
                                        @if (isset($peminjaman) && isset($peminjaman->anggota))
                                            {{ $peminjaman->anggota->NamaAnggota }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th width="140">Tanggal Pinjam</th>
                                    <td>
                                        @if (isset($peminjaman))
                                            {{ $peminjaman->TglPinjam }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kembali</th>
                                    <td>
                                        @if (isset($peminjaman))
                                            {{ optional($peminjaman->pengembalian)->TglKembali ?? '-' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if (isset($peminjaman))
                                            @if(optional($peminjaman->pengembalian) && optional($peminjaman->pengembalian)->TglKembali)
                                                <span class="badge bg-success">Dikembalikan</span>
                                            @elseif($peminjaman->TglJatuhTempo < now() && !$peminjaman->pengembalian)
                                                <span class="badge bg-danger">Terlambat</span>
                                            @else
                                                <span class="badge bg-warning">Pinjam</span>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <h6 class="fw-bold">Detail Buku</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Buku</th>
                                    <th>Judul Buku</th>
                                    <th>Jumlah Buku</th>
                                    @if (isset($peminjaman) && $peminjaman->status === 'dipinjam')
                                        <th class="text-center">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($peminjaman) && isset($peminjaman->detailPeminjaman) && count($peminjaman->detailPeminjaman))
                                    @foreach ($peminjaman->detailPeminjaman as $detail)
                                        <tr>
                                            <td>{{ $detail->KodeBuku }}</td>
                                            <td>{{ $detail->buku->Judul }}</td>
                                            {{-- <td>{{ $detail->JumlahBuku }}</td> --}}
                                            <td>{{ $detail->stok }}</td>
                                            @if ($peminjaman->status === 'dipinjam')
                                                <td class="text-center">
                                                    <form
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
                                                        action="{{ route('detail-peminjaman.destroy', ['no_pinjam' => $peminjaman instanceof \App\Models\PeminjamanSiswa ? $detail->NoPinjamM : $detail->NoPinjamN, 'kode_buku' => $detail->KodeBuku]) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="{{ (isset($peminjaman) && $peminjaman->status === 'dipinjam') ? 4 : 3 }}" class="text-center">Tidak ada data detail peminjaman.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if (isset($peminjaman) && $peminjaman->status === 'dipinjam')
                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('detail-peminjaman.create', ['peminjaman_id' => $peminjaman instanceof \App\Models\PeminjamanSiswa ? $peminjaman->NoPinjamM : $peminjaman->NoPinjamN]) }}" class="btn btn-primary">
                                Tambah Buku
                            </a>
                            <a href="{{ route('pengembalian.create', ['peminjaman_id' => $peminjaman instanceof \App\Models\PeminjamanSiswa ? $peminjaman->NoPinjamM : $peminjaman->NoPinjamN]) }}" class="btn btn-success">
                                Proses Pengembalian
                            </a>
                        </div>
                    @elseif(isset($peminjaman))
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{route('pengembalian.store',['peminjaman_id' => $peminjaman instanceof \App\Models\PeminjamanSiswa ? $peminjaman->NoPinjamM : $peminjaman->NoPinjamN])}}" class="btn btn-success">Proses Pengembalian</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
