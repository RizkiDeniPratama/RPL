@extends('layouts.master')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="menu-icon tf-icons bx bx-user me-2"></i>
                        <h5 class="mb-0">Detail Anggota Non Siswa</h5>
                    </div>
                    <a href="{{ route('anggota-non-siswa.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                        <i class="bx bx-arrow-back me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <h5 class="card-header">Informasi Pribadi</h5>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">No Anggota</label>
                                        <p class="form-control-static fw-semibold">{{ $anggotaNonSiswa->NoAnggotaN }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">NIP</label>
                                        <p class="form-control-static fw-semibold">{{ $anggotaNonSiswa->NIP }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Nama Anggota</label>
                                        <p class="form-control-static fw-semibold">{{ $anggotaNonSiswa->NamaAnggota }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Jabatan</label>
                                        <p class="form-control-static fw-semibold">{{ $anggotaNonSiswa->Jabatan }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Tanggal Lahir</label>
                                        <p class="form-control-static fw-semibold">{{ $anggotaNonSiswa->TTL->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <h5 class="card-header">Informasi Kontak</h5>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Alamat</label>
                                        <p class="form-control-static fw-semibold">{{ $anggotaNonSiswa->Alamat }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Kode Pos</label>
                                        <p class="form-control-static fw-semibold">{{ $anggotaNonSiswa->KodePos }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">No Telp/HP</label>
                                        <p class="form-control-static fw-semibold">{{ $anggotaNonSiswa->NoTelpHp }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Tanggal Daftar</label>
                                        <p class="form-control-static fw-semibold">{{ $anggotaNonSiswa->TglDaftar->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection