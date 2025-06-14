<?php

namespace Database\Seeders;

use App\Models\PeminjamanNonSiswa;
use App\Models\AnggotaNonSiswa;
use App\Models\Petugas;
use Illuminate\Database\Seeder;

class PeminjamanNonSiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 peminjaman non siswa
        PeminjamanNonSiswa::factory()
            ->count(5)
            ->create([
                'NoAnggotaN' => function () {
                    return AnggotaNonSiswa::inRandomOrder()->first()->NoAnggotaN;
                },
                'KodePetugas' => function () {
                    return Petugas::inRandomOrder()->first()->KodePetugas;
                }
            ]);
    }
}
