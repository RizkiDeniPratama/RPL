<?php

namespace Database\Seeders;

use App\Models\PeminjamanSiswa;
use App\Models\Anggota;
use App\Models\Petugas;
use Illuminate\Database\Seeder;

class PeminjamanSiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 peminjaman siswa
        PeminjamanSiswa::factory()
            ->count(10)
            ->create([
                'NoAnggotaM' => function () {
                    return Anggota::inRandomOrder()->first()->NoAnggotaM;
                },
                'KodePetugas' => function () {
                    return Petugas::inRandomOrder()->first()->KodePetugas;
                }
            ]);
    }
}
